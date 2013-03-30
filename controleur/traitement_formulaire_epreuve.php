<?php 
include '../config/epreuve_config.php';
include_once '../config/bdd_config.php';
include_once '../modele/bdd.class.php';
include '../modele/epreuve.class.php';
include './creer_liste_deroulante_formulaire.php';
include_once '../modele/transaction.class.php';


if (isset($_POST['executer'])&&($_POST['annee_epreuve']!='NULL')
&&($_POST['num_epreuve']!='NULL'))
{
	$bdd = new BDD();
	 
	$requete = "select * from tdf_epreuve where annee = ".
	$_POST['annee_epreuve']." and n_epreuve = ".$_POST['num_epreuve'];
		
	try
	{
		$query=$bdd->getBDD()->query($requete);
		$data_bdd = array();
		while ($donnee = $query->fetch(PDO::FETCH_ASSOC))
		{
			$data_bdd = $donnee;
		}
		$query->closeCursor();
	
		if (!empty($data_bdd))
		{
			$epreuve = new epreuve(
				$data_bdd['ANNEE'],
				$data_bdd['N_EPREUVE'],
				$data_bdd['CODE_TDF_D'],
				$data_bdd['CODE_TDF_A'],
				$data_bdd['VILLE_D'],
				$data_bdd['VILLE_A'],
				$data_bdd['DISTANCE'],
				$data_bdd['MOYENNE'],
				$data_bdd['JOUR'],
				$data_bdd['CAT_CODE']
			);
			
			$epreuve->decomposerDate();
			$epreuve->creerAnneeDate();
			$messageFiltre = "";
		}
		else
		{
			$messageFiltre = "Aucun résultat trouvé";
		}
	}
	catch (Exception $e)
	{
		echo "probleme de requete";
	}
}

if((isset($_POST['valider']))||(isset($_POST['maj']))||
(isset($_POST['supprimer']))||(isset($_POST['reinitialiser'])))
{
	$idAnnee;
	$idNepreuve;//permet de savoir sur quel coureur on compare, travaille, etc. --> déclaré en global dans les fonctions
	
	if(isset($_POST['valider']))
	{
		verificationRegex();
		
		if (verification_champ_null())
		{
			$date = creerDateBDD();
			$doublonEpreuveDate = verification_doublon_date($date);
			if($doublonEpreuveDate == -1)
			{
			//S'il n'y a pas conflit entre coureurs
				if (!concordanceEpreuve())
				{
					//Toutes les vérifications sont passées, on peut ajouter le coureur dans la bdd.
					$date = creerDateBDD();
					$epreuveFormulaire = creer_epreuve($date);
					ajouterEpreuveBDD($epreuveFormulaire);
					unset($_POST);
					$message_confirmation = "L'épreuve ".$epreuveFormulaire->get_n_epreuve().
						" du tour de france ".$epreuveFormulaire->get_annee(). 
						"a été ajouté à la base de données.";
				}
				else
				{
						$epreuveCompare = recupererEpreuveCompare();
						$message_annulation = "Trop de concordances avec une autre épreuve : épreuve ".$epreuveCompare->get_n_epreuve().
							" du tour de france ".$epreuveCompare->get_annee()." à la date ".$epreuveCompare->get_jour();
				}
			}
			else
			{
				$message_annulation = "La date saisie est déjà attribuée à l'épreuve ".$doublonEpreuveDate;
			}
		}
		else
		{
			$message_annulation = "Le formulaire n'a pas été correctement rempli : chaque champ symbolisé par * doit être rempli.";
		}
	}
	else if(isset($_POST['maj']))
	{
		verificationRegex();
		
		if (verification_champ_null())
		{
			$date = creerDateBDD();
			$doublonEpreuveDate = verification_doublon_date($date);
			if($doublonEpreuveDate == -1)
			{
				$epreuveFormulaire = creer_epreuve($date);
				majEpreuveBDD($epreuveFormulaire);
				unset($_POST);
				$message_confirmation = "L'épreuve ".$epreuveFormulaire->get_n_epreuve().
					" du tour de france ".$epreuveFormulaire->get_annee(). 
					"a été ajouté à la base de donnée.";
			}
			else
			{
				$message_annulation = "La date saisie est déjà attribuée à l'épreuve ".$doublonEpreuveDate;
			}
		}
		else
		{
			$message_annulation = "Le formulaire n'a pas été correctement rempli : chaque champ symbolisé par * doit être rempli.";
		}
	}
	else if (isset($_POST['supprimer']))
	{
		$date = creerDateBDD();
		$epreuveFormulaire = creer_epreuve($date);
		supprimerEpreuveBDD($epreuveFormulaire);
		unset($_POST);
		$message_confirmation = "L'épreuve ".$epreuveFormulaire->get_n_epreuve().
			" du tour de france ".$epreuveFormulaire->get_annee(). 
			"a été supprimé de la base de données.";
	}
	else if (isset($_POST['reinitialiser']))
	{
		unset($_POST);
	}
}

function verification_doublon_date($date)
{
	$requete = "select * from tdf_epreuve where annee = ".$_POST['annee'].' and jour =\''.$date.'\'';
	
	try
	{
			$bdd=new BDD();
			$query=$bdd->getBDD()->query($requete);
			$data_bdd = array();
			while ($donnee = $query->fetch(PDO::FETCH_ASSOC))
			{
				$data_bdd = $donnee;
			}
			$query->closeCursor();
			if(!empty($data_bdd))
			{
				if ($data_bdd['JOUR'] == $date)
				{
					return -1;
				}
				else
				{
					return $data_bdd['N_EPREUVE'];
				}
			}
		}
		catch (Exception $e)
		{
			echo "probleme de requete";
		}
		
		return -1;
}

function creerDateBDD()
{
	if( $_POST['date_jour'] < 10)
	{
		$tab[0] = "0".$_POST['date_jour'];
	}
	else
	{
		$tab[0] = $_POST['date_jour'];
	}
	
	if( $_POST['date_mois'] < 10)
	{
		$tab[1] = "0".$_POST['date_mois'];
	}
	else
	{
		$tab[1] = $_POST['date_mois'];
	}

	$tab[2] = substr($_POST['date_annee'],2,4);
	
	$date = implode('/',$tab);
	
	return $date;
}

/*
 * Création d'un objet coureur en fonction des paramètres de $_POST.
 */
function creer_epreuve($jour)
{
	if(isset($_POST['valider']))
	{
		$epreuve = new epreuve(
			$_POST['annee'],
			$_POST['n_epreuve'],
			$_POST['code_tdf_d'],
			$_POST['code_tdf_a'],
			$_POST['ville_d'],
			$_POST['ville_a'],
			$_POST['distance'],
			$_POST['moyenne'],
			$jour,
			$_POST['cat_code']
		);
	}
	else
	{
		$epreuve = new epreuve(
			$_POST['annee'],
			$_POST['n_epreuve'],
			$_POST['code_tdf_d'],
			$_POST['code_tdf_a'],
			$_POST['ville_d'],
			$_POST['ville_a'],
			$_POST['distance'],
			$_POST['moyenne'],
			$jour,
			$_POST['cat_code']
		);
	}
		
	return $epreuve;
}

/*
* Fonction de vérification des champs nullable.
* Retourn un booléen. True si les champs nullable ont été complétés, False dans le cas contraire.
*/
function verification_champ_null()
{
	$boolean = false;
	
	if (isset($_POST['valider']))
	{
		if($_POST['annee'] =='NULL')
		{
			$_POST['annee'] ="";
		}
		if($_POST['n_epreuve'] =='NULL')
		{
			$_POST['n_epreuve'] = "";
		}
	}
	else
	{
		$_POST['annee'] =$_POST['idAnnee'] ;
		$_POST['n_epreuve'] = $_POST['idNepreuve'] ;
	}
	
	if($_POST['code_tdf_d'] =='NULL')
	{
		$_POST['code_tdf_d'] = "";
	}
	if($_POST['code_tdf_a'] =='NULL')
	{
		$_POST['code_tdf_a'] = "";
	}
	if($_POST['cat_code'] =='NULL')
	{
		$_POST['cat_code'] = "";
	}
	if($_POST['date_jour'] =='NULL')
	{
		$_POST['date_jour'] = "";
	}
	if($_POST['date_mois'] =='NULL')
	{
		$_POST['date_mois'] = "";
	}
	if($_POST['date_annee'] =='NULL')
	{
		$_POST['date_annee'] = "";
	}
	
	
	if((!empty($_POST['annee'])) &&(!empty($_POST['n_epreuve'])) &&
	(!empty($_POST['code_tdf_d'])) && (!empty($_POST['code_tdf_a'])) &&
	(!empty($_POST['cat_code'])) && (!empty($_POST['ville_d'])) &&
	(!empty($_POST['ville_a'])) && (!empty($_POST['distance'])) &&
	(!empty($_POST['date_jour'])) && (!empty($_POST['date_mois'])) &&
	(!empty($_POST['date_jour'])))
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
function concordanceEpreuve()
{
	global $idAnnee,$idNepreuve;
	
	$tab[0] = $_POST['date_jour'];
	$tab[1] = $_POST['date_mois'];
	$tab[2] = substr($_POST['date_annee'],2,4);
	$date = implode('/',$tab);
	
	$bdd = new BDD();
	$requete = "select * from tdf_epreuve where annee = ".
	$_POST['annee']." and n_epreuve = ".$_POST['n_epreuve'];
	
	$data = $bdd->getBDD()->prepare($requete);
	$data->execute();
	
	while ($donnee = $data->fetch())
	{
		if (($donnee['ANNEE']==$_POST['annee'])&&
		($donnee['N_EPREUVE']==$_POST['n_epreuve']))
		{
			$idAnnee = $donnee['ANNEE'];
			$idNepreuve = $donnee['N_EPREUVE'];
			
			return true;
		}
	}
	
	$data->closeCursor();
	
	return false;
}

/*
 * Rceupere un objet coureur pour comparer champ a champ ce qui a été inséré dans le formulaire.
*/
function recupererEpreuveCompare()
{
	global $idAnnee,$idNepreuve;
	$bdd = new BDD();
	$epreuveCompare = new epreuve();
	$epreuveCompare->read($bdd->getBDD(),$idAnnee,$idNepreuve);
	
	return $epreuveCompare;
}


/*
* Verification de l'ensemble des regex avant insertion en BDD (derniere etape de verification.
*/
function verificationRegex()
{
	$_POST['ville_d'] = epreuve:: e_traitement_regex_ville($_POST['ville_d']);
	$_POST['ville_a'] = epreuve:: e_traitement_regex_ville($_POST['ville_a']);
	$_POST['distance'] = epreuve:: e_traitement_regex_nombre($_POST['distance'],3,1);
	$_POST['moyenne'] = epreuve:: e_traitement_regex_nombre($_POST['moyenne'],2,3);
}	


function ajouterEpreuveBDD($epreuve) 
{
	$bdd = new BDD();
	$req = $epreuve->create($bdd->getBDD());
	inserer_transaction($req, $epreuve->get_attr());
	
}

/*
* Modifie un coureur en BDD.
*/
function majEpreuveBDD($epreuve)
{
	$bdd = new BDD();
	$req = $epreuve->update($bdd->getBDD());
	inserer_transaction($req, $epreuve->get_attr());
}

/*
* Supprime un coureur en BDD.
*/
function supprimerEpreuveBDD($epreuve)
{
	$bdd = new BDD();
	$req = $epreuve->delete($bdd->getBDD());
	inserer_transaction($req, $epreuve->get_attr());
}

function inserer_transaction($p_requete,$p_valeur)
{
	$transaction = new transaction($p_requete, $p_valeur);
	$transaction->ecrire_transaction();
}

include '../vue/formulaire_epreuve.php';
?>