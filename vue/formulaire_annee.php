<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo $table; ?></title>
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="../vue/css/style.css" />
	</head>
	
	<body>
		<div id="header">
			<img class="Ttdf_image" src="../vue/img/tour_de_france1.png" />
			<div class="menu">
				<ul>
					<li><a href="../controleur/gerer_cookies.php">Administration</a></li>
					<li><a href="../controleur/gerer_formulaire_requete_manuelle.php">SQL</a></li>
					<li><a href="../vue/journal_transaction.php">Journal des tansactions</a></li>
				</ul>
			</div>
		</div>

		<div id="subheader">
			<div class="bdd">
				<h3>Base d'administration des tables du TDF 2011</h3>
				<h5>
					<i><a href="../controleur/gerer_cookies.php"> Administration</a> 
						   <a><?php echo "> ".$table; ?></a> 
					</i>
			</h5>
			</div>
			<div class="usr">
				<h5>
					<i><?php echo "utilisateur : ".$_COOKIE['identifiant']; ?> </i>
				</h5>
				<a href="../index.php">Deconnexion</a>
			</div>
		</div>
	
		<div id="corps">
			<div id="listeTable">
				<p>Liste des Tables :
				<ul>
					<li><a href="gerer_cookies.php?nom=coureur">TDF_COUREUR</a></li>
					<li><a href="traitement_formulaire_annee.php?nom=annee">TDF_ANNEE</a></li>
					<li><a href="traitement_formulaire_epreuve.php?nom=epreuve">TDF_EPREUVE</a></li>
					<li><a href="gerer_cookies.php?nom=pays">TDF_PAYS</a></li>
					<li><a href="traitement_formulaire_equipe.php?nom=equipe">TDF_EQUIPE/SPONSOR</a></li>
					<li><a href="gerer_cookies.php?nom=directeur">TDF_DIRECTEUR</a></li>
					<li><a href="traitement_formulaire_participation.php?nom=participation">TDF_PARTICIPATION</a></li>
					
				</ul>
			</div>

		<div id="left_side">
			<fieldset>
			<legend>Rechercher un sponsor :</legend>
			<div id="recherche">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<?php  $bdd = new BDD(); ?>
						<p>
						<label for='anneeR'>Année de recherche :</label> 
							<select name="anneeR">
								<?php remplirComboboxSQL($bdd->getBDD(),"Select * from tdf_annee order by annee desc","ANNEE","ANNEE",-1,0);?>
							</select>
						</p>
						<input type="submit" name="executer" value="Exécuter la recheche" />
						<p>
							<?php if(empty($data_bdd)){ echo "Aucun résultat trouvé"; } ?>
						</p>
				</form>
			</div>
			</fieldset>
		</div>

		<div id="formulaire">
			<fieldset>
			<legend> Gestion du nombre de jour de repos </legend>
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<?php $bdd = new BDD(); ?>
				<p>
					<label for="annee">Année* : </label> 
					<select name="annee" >
						<?php if(isset($anneeJR)){remplirComboboxDate(15,$anneeJR->get_annee());}
							   else if(isset($_POST['annee'])){remplirComboboxDate(15,$_POST['annee']);}
							   else{remplirComboboxDate(15,0);} ?>
					</select>
				</p>
					
				<p>
					<label for="jour_repos">Nombre de jour de repos* : </label> 
					<select name="jour_repos" >
						<?php if(isset($anneeJR)){remplirComboboxNombre(0,9,$anneeJR->get_jour_repos());}
							  else if(isset($_POST['jour_repos'])){remplirComboboxNombre(0,9,$_POST['jour_repos']);}
							  else{remplirComboboxNombre(0,9,10);} ?>
					</select>
				</p>
					
				<?php 
		         		 if (isset($anneeJR)){
		         		 	echo "<input type=\"hidden\" name=\"id\" value =".$anneeJR->get_annee().">";
		         		 	echo "<input type=\"submit\" name=\"valider\" value=\"Ajouter\"  onclick=\"return attention();\" disabled/>";
		     				echo "<input type=\"submit\" name=\"maj\" value=\"Mettre à jour\" onclick=\"return attention();\" />";
		         		 	echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" onclick=\"return attention();\"  />";
		         		 	echo "<input type=\"submit\"   name=\"reinitialiser\" value=\"Réinitialiser\"/>";
		         		 }
		         		 else if (isset($_POST['id'])){
		         		 	echo "<input type=\"hidden\" name=\"id\" value =".$_POST['annee'].">";
		         		 	echo "<input type=\"submit\" name=\"valider\" value=\"Ajouter\"  onclick=\"return attention();\"disabled/>";
		         		 	echo "<input type=\"submit\" name=\"maj\" value=\"Mettre à jour\" onclick=\"return attention();\" />";
		         		 	echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" onclick=\"return attention();\"  />";
		         		 	echo "<input type=\"submit\"   name=\"reinitialiser\" value=\"Réinitialiser\"/>";
		         		 }
		         		 else{
		         		 	echo "<input type=\"submit\" name=\"valider\" value=\"Ajouter\"  onclick=\"return attention();\"/>";
		         		 	echo "<input type=\"submit\" name=\"maj\" value=\"Mettre à jour\" onclick=\"return attention();\" disabled/>";
		         		 	echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" onclick=\"return attention();\"  disabled/>";
		         		 	echo "<input type=\"submit\"   name=\"reinitialiser\" value=\"Réinitialiser\"/>";
		         		 }
		          ?>
		   	</form>
		</fieldset>
		<p>*Champ obligatoirement rempli</p>
		
		<div id='messageRetour' style="color :green;" >
			<p><?php if(isset($message_confirmation)){echo $message_confirmation;} ?></p>
		</div>
		<div id='messagRetour' style="color :red;" >
			<p><?php if(isset($message_annulation)){echo $message_annulation;} ?></p>
		</div>
	</div>
	</div>
	<div id="footer"></div>
		<script type="text/javascript" src="../controleur/confirmation_avant_crud.js"></script>
		<script type="text/javascript" src="../modele/jquery_lib.js"></script>
		<script type="text/javascript" src="../controleur/verifications_formulaire_coureur.js"></script>
		<script type="text/javascript">
			<!--
				c_nom_coureur();
				c_prenom_coureur();
				c_code_tdf_date_naissance();
			//-->
	    </script>
	</body>
</html>

