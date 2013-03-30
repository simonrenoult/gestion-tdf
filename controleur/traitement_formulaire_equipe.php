<?php 

include '../config/equipe_config.php';
include_once '../config/bdd_config.php';
include_once '../modele/bdd.class.php';
include '../modele/sponsor.class.php';
include '../modele/equipe.class.php';
include './creer_liste_deroulante_formulaire.php';
include_once '../modele/transaction.class.php';

if (isset($_POST['executer']) && $_POST['sponsor']!="NULL")
{
	$tab = explode("-",$_POST['sponsor'] );
	
	$bdd = new BDD();
	$requete = "select * from tdf_sponsor where n_equipe = ".$tab[0]." and n_sponsor = ".$tab[1];
		
	try
	{
		$query=$bdd->getBDD()->query($requete);
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

	$sponsor = new sponsor($data_bdd['N_EQUIPE'],
	$data_bdd['N_SPONSOR'],
	$data_bdd['NOM'],
	$data_bdd['NA_SPONSOR'],
	$data_bdd['CODE_TDF'],
	$data_bdd['ANNEE_SPONSOR']
	);
}

if((isset($_POST['valider']))||(isset($_POST['maj']))||
(isset($_POST['supprimer']))||(isset($_POST['reinitialiser'])))
{
	$idSponsor;
	$idEquipe;//permet de savoir sur quel coureur on compare, travaille, etc. --> déclaré en global dans les fonctions
	print_r($_POST);
	if(isset($_POST['valider']))
	{
		verificationRegex();
		$messageRattache = rattacheEquipe();
		
		if(($messageRattache == "verificationOKNOUVELLE")||($messageRattache == "verificationOKEXISTANTE"))
		{
			if (verification_champ_null())
			{
				//S'il n'y a pas conflit entre coureurs
				if (!concordanceSponsor())
				{
						//Toutes les vérifications sont passées, on peut ajouter le coureur dans la bdd.
						if($messageRattache == "verificationOKNOUVELLE")
						{
							$n_equipeFormulaire = creer_equipe();
							ajouterEquipeBDD($n_equipeFormulaire);
							$n_sponsorFormulaire = creer_sponsorAjouter($n_equipeFormulaire->get_n_equipe());
							ajouterSponsorBDD($n_sponsorFormulaire);
							unset($_POST);
							$message_confirmation = "Le sponsor ".$n_sponsorFormulaire->get_nom()." a été ajouté à la base de données.";
						}
						else if ($messageRattache == "verificationOKEXISTANTE")
						{
							$n_sponsorFormulaire = creer_sponsorAjouter($_POST['dernierSponsorEquipe']);
							ajouterSponsorBDD($n_sponsorFormulaire);
							unset($_POST);
							$message_confirmation = "Le sponsor ".$n_sponsorFormulaire->get_nom()." a été ajouté à la base de données.";
						}
				}
				else
				{
					$sponsorCompare = recupererSponsorCompare();
					$message_annulation = "Trop de concordances avec un autre sponsor existant : ".$sponsorCompare->get_nom()." de code ".$sponsorCompare->get_code_tdf();
				}
			}
			else
			{
				$message_annulation = "Le formulaire n'a pas été correctement rempli : chaque champ symbolisé par * doit être rempli.";
			}
		}
		else
		{
			$message_annulation = $messageRattache;
		}
	}
	
	else if(isset($_POST['maj']))
	{
		verificationRegex();
		
		if (verification_champ_null())
		{
			if (!concordanceSponsor())
			{
				//Toutes les vérifications sont passées, on peut ajouter le coureur dans la bdd.
				$n_sponsorFormulaire = creer_sponsorModifier();
				majSponsorBDD($n_sponsorFormulaire);
				unset($_POST);
				$message_confirmation = "Le sponsor ".$n_sponsorFormulaire->get_nom()." a été ajouté à la base de données.";
			}
			else
			{
				$sponsorCompare = recupererSponsorCompare();
				$message_annulation = "Trop de concordances avec un autre sponsor existant : ".$sponsorCompare->get_nom()." de code ".$sponsorCompare->get_code_tdf();
			}
		}	
		else
		{
			$message_annulation = "Le formulaire n'a pas été correctement rempli : chaque champ symbolisé par * doit être rempli.";
		}
	}
	else if (isset($_POST['supprimer']))
	{
		$sponsorFormulaire = creer_sponsorModifier();
		supprimerSponsorBDD($sponsorFormulaire);
		unset($_POST);
		$message_confirmation = "Le sponsor ".$sponsorFormulaire->get_nom()." a été supprimé de la base de données.";
	}
	else if (isset($_POST['reinitialiser']))
	{
		unset($_POST);
	}
}

/*
 *
* verification de l'existante d'une equipe quand on ajoute un sponsor
*/
function rattacheEquipe()
{
	if (isset($_POST['selectionEquipe']))
	{
		if($_POST['selectionEquipe'] == "equipeExistante")
		{
			if($_POST['dernierSponsorEquipe'] != "NULL")
			{
				return "verificationOKEXISTANTE";
			}
			else{
				return "Vous avez selectionné une equipe sans désigner le dernier sponsor en date";
			}
		}
		else if($_POST['selectionEquipe'] == "equipeNouvelle")
		{
			if($_POST['dateCreationEquipe'] != "NULL")
			{
				return "verificationOKNOUVELLE";
			}
			else
			{
				return "Vous devez sélectionné une date de création d'équipe.";
			}
		}
	}
	else
	{
		return "Vous devez indiqué si le nouveau sponsor dépend déjà d'une équipe (en sélectionnant un de ses sponsors) ";
	}
}


/*
 * Création d'un objet coureur en fonction des paramètres de $_POST.
*/

function creer_equipe()
{
	$equipe = new equipe(
		NULL,
		$_POST['dateCreationEquipe'],
		$_POST['dateDisparitionEquipe']
	);
	
	$bdd = new BDD();
	$equipe->set_n_equipe((int)$equipe->calculer_nequipe($bdd->getBDD()));
	
	return $equipe;
}

function creer_sponsorAjouter($n_equipe)
{
	$tab =explode("-",$n_equipe);	
	
	$sponsor = new sponsor(
		$tab[0],
		NULL,
		$_POST['nom'],
		$_POST['nom_abr'],
		$_POST['code_tdf'],
		$_POST['annee_sponsor']
	);
	
	$bdd = new BDD();
	$sponsor->set_n_sponsor((int)$sponsor->calculer_nsponsor($bdd->getBDD(),$n_equipe));
	
	
	return $sponsor;
}

function creer_sponsormodifier()
{
	$sponsor = new sponsor(
		$_POST['idEquipeRecherche'],
		$_POST['idSponsorRecherche'],
		$_POST['nom'],
		$_POST['nom_abr'],
		$_POST['code_tdf'],
		$_POST['annee_sponsor']
	);
	
	return $sponsor;
}

/*
 * Fonction de vérification des champs nullable.
* Retourn un booléen. True si les champs nullable ont été complétés, False dans le cas contraire.
*/
function verification_champ_null()
{
	$boolean = false;
		
	if($_POST['annee_sponsor'] =='NULL')
	{
		$_POST['annee_sponsor'] = "";
	}
	
	if($_POST['nom_abr'] =='NULL')
	{
		$_POST['nom_abr'] = "";
	}
	if((!empty($_POST['nom'])) && (($_POST['code_tdf'])!='NULL'))
	{
		$boolean = true;
	}
	
	return $boolean;
}

/*
 * Fonction de vérification de conflit entre coureur issu du formulaire et coureur de la bdd.
* Paramètres de vérification : nom, prenom et date de naissance.
* Retourne un booléen. True si conflit, False dans le cas contraire.
*/

function concordanceSponsor()
{
	global $idSponsor,$idEquipe;
		
	$bdd = new BDD();
	$requete = "select * from tdf_sponsor where nom like '".$_POST['nom']."'";
	//echo $requete;
	try
	{
		$data = $bdd->getBDD()->prepare($requete);
		$data->execute();
			
		while ($donnee = $data->fetch())
		{
			if (($donnee['NOM']==$_POST['nom'])&&
			($donnee['CODE_TDF']==$_POST['code_tdf']))
			{
				$idSponsor = $donnee['N_SPONSOR'];
				$idEquipe = $donnee['N_EQUIPE'];
				
				return true;
			}
			//echo false;
		}
		$data->closeCursor();
	}catch (Exception $e)
	{
		
	}
	
	return false;
}

/*
 * Rceupere un objet coureur pour comparer champ a champ ce qui a été inséré dans le formulaire.
*/
function recupererSponsorCompare()
{
	global $idSponsor,$idEquipe;
	$bdd = new BDD();
	$sponsorCompare = new sponsor();
	$sponsorCompare->readSponsorEquipe($bdd->getBDD(),$idSponsor,$idEquipe);
	
	return $sponsorCompare;
}

/*
 * Verification de l'ensemble des regex avant insertion en BDD (derniere etape de verification.
*/
function verificationRegex() 
{
	$_POST['nom'] = sponsor::e_traitement_regex_nom_sponsor($_POST['nom']);
	$_POST['nom_abr'] = sponsor::e_traitement_regex_nomabr_sponsor($_POST['nom_abr']);
}

/*
 * Ajoute un coureur en BDD
*/
function ajouterEquipeBDD($equipe) 
{
	$bdd = new BDD();
	$req = $equipe->create($bdd->getBDD());
	inserer_transaction($req, $equipe->get_attr());
}

/*
 * Ajoute un coureur en BDD
*/
function ajouterSponsorBDD($sponsor) 
{
	$bdd = new BDD();
	$req = $sponsor->create($bdd->getBDD());
	echo "ajouter terminé";
	inserer_transaction($req, $sponsor->get_attr());
	
}

/*
 * Modifie un coureur en BDD.
*/
function majSponsorBDD($sponsor)
{
	$bdd = new BDD();
	$req = $sponsor->update($bdd->getBDD());
	inserer_transaction($req, $sponsor->get_attr());
	
}

/*
 * Supprime un coureur en BDD.
*/
function supprimerSponsorBDD($sponsor)
{
	$bdd = new BDD();
	$req = $sponsor->delete($bdd->getBDD());
	inserer_transaction($req, $sponsor->get_attr());
	
}

function inserer_transaction($p_requete,$p_valeur)
{
	$transaction = new transaction($p_requete, $p_valeur);
	$transaction->ecrire_transaction();
}

include '../vue/formulaire_equipe.php';
?>