<?php

include_once '../modele/transaction.class.php';


if((isset($_POST['valider']))||(isset($_POST['maj']))||
(isset($_POST['supprimer']))||(isset($_POST['reinitialiser'])))
{
	$id;//permet de savoir sur quel coureur on compare, travaille, etc. --> déclaré en global dans les fonctions
	
	if(isset($_POST['valider']))
	{
		verificationRegex();
		if (verification_champ_null())
		{
			//S'il n'y a pas conflit entre coureurs
			if (!concordanceDirecteur())
			{
					//Toutes les vérifications sont passées, on peut ajouter le coureur dans la bdd.
					$directeurFormulaire = creer_directeur();
					ajouterDirecteurBDD($directeurFormulaire);
					unset($_POST);
					$message_confirmation = "Le directeur ".
					$directeurFormulaire->get_prenom()." ".
					$directeurFormulaire->get_nom().
					" a été ajouté à la base de donnée.";
			}
			else
			{
				$directeurCompare = recupererDirecteurCompare();
				$message_annulation = "Trop de concordances avec un autre directeur : ".$directeurCompare->get_prenom().
					" ".$directeurCompare->get_nom().".";
			}
		}
		else
		{
			$message_annulation = "Le formulaire n'a pas été correctement rempli : chaque champ symbolisé par * doit être rempli.";
		}
	}
	else if(isset($_POST['maj']))
	{
		if(isset($_POST['id']))
		{
			verificationRegex();
			
			if (verification_champ_null())
			{
				if (!concordanceDirecteur())
				{
					//Toutes les vérifications sont passées, on peut ajouter le coureur dans la bdd.
					$directeurFormulaire = creer_directeur();
					majDirecteurBDD($directeurFormulaire);
					unset($_POST);
					$message_confirmation = "Le directeur ".$directeurFormulaire->get_prenom()." ".$directeurFormulaire->get_nom().
																			" a été modifié dans la base de données.";
				}
				else
				{
					$directeurCompare = recupererDirecteurCompare();
					$message_annulation = "Trop de concordances avec un autre directeur : ".$directeurCompare->get_prenom().
						" ".$directeurCompare->get_nom().".";
				}
			}
			else
			{
				$message_annulation = "Le formulaire n'a pas été correctement rempli : chaque champ symbolisé par * doit être rempli.";
			}
		}
		else
		{
			$message_annulation = "Vous ne pouvez pas modifier un directeur sans l'avoir ajouté préalablement !";
		}	
	}
	else if (isset($_POST['supprimer']))
	{
		$directeurFormulaire = creer_directeur();
		supprimerDirecteurBDD($directeurFormulaire);
		unset($_POST);
		$message_confirmation = "Le directeur ".$directeurFormulaire->get_prenom()." ".$directeurFormulaire->get_nom().
			" a été supprimé de la base de données.";
	}
	else if (isset($_POST['reinitialiser']))
	{
		unset($_POST);
	}
}

/*
 * Création d'un objet directeur en fonction des paramètres de $_POST.
 */	
function creer_directeur()
{
	if(isset($_POST['valider']))
	{
		$directeur = new directeur(
			NULL,
			$_POST['nom'],
			$_POST['prenom']
		);
		
		$bdd = new BDD();
		$directeur->set_n_directeur((int)$directeur->calculer_ndirecteur($bdd->getBDD()));
	}
	else
	{
		$directeur = new directeur(
			$_POST['id'],
			$_POST['nom'],
			$_POST['prenom']
		);
	}
		
	return $directeur;
}

/*
* Fonction de vérification des champs nullable.
* Retourn un booléen. True si les champs nullable ont été complétés, False dans le cas contraire.
*/
function verification_champ_null()
{
	$boolean = false;
	
	if((!empty($_POST['nom'])) &&(!empty($_POST['prenom'])))
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

function concordanceDirecteur()
{
	global $id;
	$bdd = new BDD();
	$requete = "select * from tdf_directeur where nom like '".$_POST['nom']."'";
	
	$data = $bdd->getBDD()->prepare($requete);
	$data->execute();
	
	while ($donnee = $data->fetch())
	{
		if (($donnee['NOM']==$_POST['nom'])&&
		($donnee['PRENOM']==$_POST['prenom']))
		{
			$id = $donnee['N_DIRECTEUR'];
			
			return true;
		}
	}
	
	$data->closeCursor();
	
	return false;
}

/*
 * Rceupere un objet coureur pour comparer champ a champ ce qui a été inséré dans le formulaire.
*/
function recupererDirecteurCompare()
{
	global $id;
	$bdd = new BDD();
	$directeurCompare = new directeur();
	$directeurCompare->read($bdd->getBDD(),$id);

	return $directeurCompare;
}

/*
* Verification de l'ensemble des regex avant insertion en BDD (derniere etape de verification.
*/
function verificationRegex()
{
	$_POST['nom'] = directeur:: d_traitement_regex_nom($_POST['nom']);
	$_POST['prenom'] = directeur:: d_traitement_regex_prenom($_POST['prenom']);
}

/*
* Ajoute un coureur en BDD
*/
function ajouterDirecteurBDD($directeur)
{
	$bdd = new BDD();
	$req = $directeur->create($bdd->getBDD());
	inserer_transaction($req, $directeur->get_attr());
}

/*
* Modifie un coureur en BDD.
*/
function majDirecteurBDD($directeur)
{
	$bdd = new BDD();
	$req = $directeur->update($bdd->getBDD());
	inserer_transaction($req, $directeur->get_attr());
}

/*
* Supprime un coureur en BDD.
*/
function supprimerDirecteurBDD($directeur)
{
	$bdd = new BDD();
	$req = $directeur->delete($bdd->getBDD());
	inserer_transaction($req, $directeur->get_attr());
}

function inserer_transaction($p_requete,$p_valeur)
{
	$transaction = new transaction($p_requete, $p_valeur);
	$transaction->ecrire_transaction();
}

?>