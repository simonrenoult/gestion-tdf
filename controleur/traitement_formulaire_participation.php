<?php 
	
include '../config/participation_config.php';
include '../config/bdd_config.php';
include '../modele/bdd.class.php';
include '../modele/participation.class.php';		
include './creer_liste_deroulante_formulaire.php';
include_once '../modele/transaction.class.php';


if(isset($_POST['executer']) && ($_POST['annee']!="NULL" && 
$_POST['coureur'] != "NULL" && $_POST['equipe'] != "NULL"))
{
	$bdd = new BDD();
	
	$tab = explode("-",$_POST['equipe']);
	
	$requete = "select annee, n_coureur,n_equipe,n_sponsor,n_dossard,jeune from tdf_participation
		where annee =".$_POST['annee']. 
		" and n_coureur =".$_POST['coureur']. 
		" and (n_equipe ,n_sponsor)in (select n_equipe,n_sponsor from tdf_sponsor where n_equipe = ".$tab[0]." and n_sponsor = ".$tab[1].")";
		
	try
	{
		$query = $bdd->getBDD()->query($requete);
		$data_bdd = array();
		while ($donnee = $query->fetch(PDO::FETCH_ASSOC))
		{
			$data_bdd = $donnee;
		}
		 
		$query->closeCursor();
	}
	catch (Exception $e)
	{
		echo "probleme de requete";
	}
	if (!empty($data_bdd))
	{
		$participation = new participation( 
			$data_bdd['N_COUREUR'],
			$data_bdd['N_EQUIPE'],
			$data_bdd['N_SPONSOR'],
			$data_bdd['ANNEE'],
			$data_bdd['N_DOSSARD'],
			$data_bdd['JEUNE']
			);
		
		$participation->display();
		$messageFiltre="";
	}
	else{
		$messageFiltre="Auncun résultat trouvé";
	}
}
		
if((isset($_POST['valider']))||(isset($_POST['maj']))||
(isset($_POST['supprimer']))||(isset($_POST['reinitialiser'])))
{
		$id;//permet de savoir sur quel coureur on compare, travaille, etc. --> déclaré en global dans les fonctions

		if(isset($_POST['valider']))
		{
			if (verification_champ_null())
			{
				//S'il n'y a pas conflit entre participants (equipe et coureurs)
				$message = concordanceParticipation();
				if ($message == "ok")
				{		//Toutes les vérifications sont passées, on peut ajouter le coureur dans la bdd.
						$partcicpationFormulaire = creer_participation();
						ajouterParticipationBDD($partcicpationFormulaire);
						unset($_POST);
						$message_confirmation = "Le coureur ".$partcicpationFormulaire->get_n_coureur().
							" de l'équipe ".$partcicpationFormulaire->get_n_equipe().
							" a été ajouté à la base de données.";
				}
				else
				{
					$message_annulation = $message;
				}
			}
			else
			{
				$message_annulation = "Le formulaire n'a pas été correctement rempli : chaque champ symbolisé par * doit être rempli.";
			}
		}
		
	}
	
	/*
	 * Création d'un objet coureur en fonction des paramètres de $_POST.
	*/
	function creer_Participation()
	{
		$tab = explode("-",$_POST['equipe']);
		$participation = new participation(
		$_POST['coureur'],
		$tab[0],
		$tab[1],
		$_POST['annee'],
		$_POST['dossard'],
		$_POST['jeune']
		);
		
	
	return $participation;
	}
	
	
	/*
	* Fonction de vérification des champs nullable.
	* Retourn un booléen. True si les champs nullable ont été complétés, False dans le cas contraire.
	*/
	function verification_champ_null()
	{
		$boolean = false;
		
		if($_POST['annee'] =='NULL')
		{
			$_POST['annee'] ="";
		}
		if($_POST['coureur'] =='NULL')
		{
			$_POST['coureur'] = "";
		}
		if($_POST['equipe'] =='NULL')
		{
			$_POST['equipe'] = "";
		}
		if($_POST['dossard'] =='NULL')
		{
		$_POST['dossard'] = "";
		}
			
		if((!empty($_POST['annee'])) &&(!empty($_POST['coureur'])) && 
				(!empty($_POST['equipe'])) && (!empty($_POST['dossard']))){
			
			$boolean = true;
		}
				
			return $boolean;
	}
	
	
		/*
		* Fonction de vérification de conflit entre coureur issu du formulaire et coureur de la bdd.
		* Paramètres de vérification : nom, prenom et date de naissance.
		* Retourne un booléen. True si conflit, False dans le cas contraire.
		*/
		function concordanceParticipation()
		{
		global $id;
		$bdd = new BDD();
		$tab = explode("-",$_POST['equipe']);
		// IL ne faut pas retrouver le même coureur deux fois la même année.
		$requete = "select * from tdf_participation where n_coureur =".$_POST['coureur']." and annee = ".$_POST['annee'];
			
		$data = $bdd->getBDD()->prepare($requete);
		$data->execute();
	
		while ($donnee = $data->fetch())
		{
		if (($donnee['N_COUREUR']==$_POST['coureur'])){
			
				return "Le coureur selectionné est déjà enregistré pour l'année selectionnée.";
			}
		}
		$data->closeCursor();
		
		//il ne faut plus de 9 coureurs par équipe pour l'année
	
		$requete = "select max(n_equipe) as total from tdf_participation where n_equipe =".$tab[0]." and  annee = ".$_POST['annee'];
	
		$data = $bdd->getBDD()->prepare($requete);
		$data->execute();
	
		while ($donnee = $data->fetch())
		{
		if (($donnee['TOTAL']==9)){
		return "L'équipe selectionné compte déjà 9 participants, vous ne pouvez plus ajouter de participants pour l'équipe selectionné et l'année selectionnée";
				
			}
		}
		$data->closeCursor();
		
		//il ne faut pas que le numéro de dossard soit pris pour une année
	
		$requete = "select n_dossard from tdf_participation where annee = ".$_POST['annee'];
		
		$data = $bdd->getBDD()->prepare($requete);
		$data->execute();
		
		while ($donnee = $data->fetch())
		{
		
		if (($donnee['N_DOSSARD']==$_POST['dossard'])){
		return "Le numéro de dossard selectionné existe déjà pour l'année selectionnée";
					
			}
		}
		$data->closeCursor();
		
		return "ok";
		}
	
		/*
		* Ajoute un coureur en BDD
		*/
		function ajouterParticipationBDD($participation)
		{
		$bdd = new BDD();
		echo "donné correct à insérer mais problème non résolu quant à son écriture sur base : ","<br />";
		echo $participation->display();
		$req = $participation->create($bdd->getBDD());
		inserer_transaction($req, $participation->get_attr());
		}
	
		/*
		* Modifie un coureur en BDD.
		*/
		function majParticipationBDD($participation)
		{
		$bdd = new BDD();
		$req = $participation->update($bdd->getBDD());
		inserer_transaction($req, $participation->get_attr());
		}
	
		/*
		* Supprime un coureur en BDD.
		*/
		function supprimerParticipationBDD($participation)
		{
		$bdd = new BDD();
		$req = $participation->delete($bdd->getBDD());
		inserer_transaction($req, $participation->get_attr());
	
		}
	
		function inserer_transaction($p_requete,$p_valeur)
		{
		$transaction = new transaction($p_requete, $p_valeur);
		$transaction->ecrire_transaction();
		}
	
		include '../vue/formulaire_participation.php';

?>