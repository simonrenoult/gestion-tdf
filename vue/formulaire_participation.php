
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--
	Include obligatoire afin de permettre l'initialisation des variables javascript avec la fonction " autoCompletion_init(...) "
-->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title><?php echo $table; ?></title>
		
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="../vue/css/style.css"  /> 	
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
			
			<?php /*
			<div id="left_side">
				<fieldset>
				<legend>Rechercher :</legend>
				
				<div id="recherche">
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<p><label for='annee'>Année de participation</label>
						<select name="annee">
						<?php remplirComboboxDate(20,0,0); ?>
						</select></p>
						
						<?php  $bdd = new BDD(); ?>
						
						<p><label for='coureur'>Nom du coureur</label>
						<select name="coureur">
						<?php remplirComboboxSQL($bdd->getBDD(),"Select distinct nom,n_coureur from tdf_participation join tdf_coureur using (n_coureur) where n_equipe in (select n_equipe from tdf_equipe WHERE annee_disparition is null) order by nom asc","NOM","N_COUREUR",-1,0);?>
						</select></p>
						
						<p><label for='equipe'>Nom de l'équipe</label>
						<select name="equipe">
						<?php remplirComboboxSQLEquipeSponsor($bdd->getBDD(),"Select distinct nom ,n_equipe,n_sponsor from tdf_participation join tdf_sponsor using (n_equipe,n_sponsor) where n_equipe in (select n_equipe from tdf_equipe WHERE annee_disparition is null) order by nom asc","NOM","NOM",-1,0);?>
						</select></p>
						
						<input type="submit" name="executer" value="Exécuter la recheche"  />
						<p>
						<?php if(empty($data_bdd) && isset($messageFiltre)){
							echo $messageFiltre;
						} ?>
						</p>
					</form>	
					
				</div>	
			</fieldset>
			</div>	
			*/?>
			<div id="formulaire">
			<fieldset>
			<legend> Gestion d'une participation </legend>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<p><label for='annee'>Année de participation* :</label>
					<select name="annee">
					<?php if (isset($participation)){ remplirComboboxDate(20,$participation->get_annee(),1);}
						  else if (isset($_POST['annee'])){ remplirComboboxDate(20,$_POST['annee'],1);}
						  else{remplirComboboxDate(20,0,1);}  ?>
					</select></p>
					
					<?php  $bdd = new BDD(); ?>
					
					<p><label for='coureur'>Nom du coureur* :</label>
					<select name="coureur">
					<?php if (isset($participation)){remplirComboboxSQL($bdd->getBDD(),"Select * from tdf_coureur order by nom asc","NOM","N_COUREUR",$participation->get_n_coureur(),1);}
						  else if (isset($_POST['coureur'])){remplirComboboxSQL($bdd->getBDD(),"Select * from tdf_coureur order by nom asc","NOM","N_COUREUR",$_POST['coureur'],1);}
						  else{remplirComboboxSQL($bdd->getBDD(),"Select * from tdf_coureur order by nom asc","NOM","N_COUREUR",-1,1);}
					?>
					
					</select></p>
					
					<p><label for='equipe'>Nom de l'équipe* :</label>
					<select name="equipe">
					<?php 
							//on selectionne les plus récents sponsors ayant déjà partcipés.
							$req = "Select distinct nom ,n_equipe,n_sponsor from tdf_participation ".
									"join tdf_sponsor using (n_equipe,n_sponsor)".
									" where n_equipe in (select n_equipe from tdf_equipe WHERE annee_disparition is null)".
									" AND (n_equipe,n_sponsor) in ( SELECT n_equipe, max(n_sponsor)FROM tdf_sponsor GROUP BY n_equipe )ORDER BY nom asc";
					
						  if (isset($participation)){remplirComboboxSQLEquipeSponsor($bdd->getBDD(),$req,"NOM","NOM",$participation->get_n_equipe(),1);}
						  else if (isset($_POST['equipe'])){remplirComboboxSQLEquipeSponsor($bdd->getBDD(),$req,"NOM","NOM",$_POST['equipe'],1);}
						  else{remplirComboboxSQLEquipeSponsor($bdd->getBDD(),$req,"NOM","NOM",0,1);}
					?>
					
					</select></p>
					
					<p><label for='dossard'>Numero de dossard* :</label>
					<select name="dossard">
					<?php if (isset($participation)){remplirComboboxNombre(1,300,$participation->get_n_dossard());}
						  else if (isset($_POST['N_DOSSARD'])){remplirComboboxNombre(1,300,$_POST['N_DOSSARD']);}
						  else{remplirComboboxNombre(1,300,0);}
					?>	
					</select></p>
					
					
					<p><label for='jeune'>jeune (-25 ans) :</label>
					<input type="radio" name='jeune' value="o" /><label for='jeune'>oui</label>
					<input type="radio" name='jeune' value="" checked="checked" /><label for='jeune'>non</label>
					</p>

						
						<br><br>
					<?php 
		         		 if (isset($participation)){
		         		 	//echo "<input type=\"hidden\" name=\"id\" value =".$participation->get_n_coureur().">";
		         		 	
		         		 	echo "<input type=\"submit\" name=\"valider\" value=\"Ajouter\"  onclick=\"return attention();\" disabled/>";
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
		         		 if (isset($_POST['id'])){
		         		 	//echo "<input type=\"hidden\" name=\"id\" value =".$_POST['id'].">";
		         		 	
		         		 	echo "<input type=\"submit\" name=\"valider\" value=\"Ajouter\"  onclick=\"return attention();\"disabled/>";
		         		 	echo "<input type=\"submit\" name=\"maj\" value=\"Mettre à jour\" onclick=\"return attention();\" />";
		         		 	echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" onclick=\"return attention();\"  />";
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
		
		
	</body>
</html>

