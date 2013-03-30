<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
				<h5><i><a href="../controleur/gerer_cookies.php"> Administration</a> 
					   <a><?php echo "> ".$table; ?></a> 
					</i>
				</h5>
			</div>
			<div class="usr">
				<h5><i><?php echo "utilisateur : ".$_COOKIE['identifiant']; ?> </i></h5>
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
			<legend>Rechercher  le dernier sponsor existant d'une équipe :</legend>
				


			<div id="recherche">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<?php  $bdd = new BDD(); ?>
					<p>
						<label for='sponsor'>Nom du sponsor</label> 
							<select name="sponsor">
								<?php remplirComboboxSQLEquipeSponsor($bdd->getBDD(),
								"SELECT nom,n_equipe,n_sponsor FROM tdf_equipe JOIN tdf_sponsor USING (n_equipe)WHERE annee_disparition is null AND (n_equipe,n_sponsor) in ( SELECT n_equipe, max(n_sponsor)FROM tdf_sponsor GROUP BY n_equipe )ORDER BY nom asc","NOM","NOM",-1,0);?>
							</select>
					</p>

					<input type="submit" name="executer" value="Exécuter la recheche" />
						
					<p>
						<?php if( empty($data_bdd)){echo "Aucun résultat trouvé";} ?>
					</p>
						
				</form>
			</div>
			</fieldset>
		</div>
		<div id="formulaire">
			<fieldset>
			<legend> Gestion d'une équipe </legend><br>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<fieldset>
					<legend> sponsor </legend>
						<p>
							<label for='nom'>Nom du sponsor* :</label> <input type='text'name="nom" 
							value="<?php if (isset($sponsor)){echo $sponsor->get_nom();}else{echo "";}  
							 	 		 if (isset($_POST['nom'])){echo$_POST['nom'];}else{echo "";}
							?>" />
						</p>
						<p>
							<label for='nom_abr'>Nom abrégé du sponsor :</label> <input type='text' name="nom_abr" 
							value="<?php if (isset($sponsor)){echo $sponsor->get_na_sponsor();}else{echo "";}  
							 	 		 if (isset($_POST['nom_abr'])){echo$_POST['nom_abr'];}else{echo "";}
							?>" />
						</p>
						<?php $bdd = new BDD(); ?>
						<p>
							<label for="code_tdf">Pays d'origine* : </label>
							<select name="code_tdf" > 
					  		 <?php
							   if(isset($sponsor)){
							  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$sponsor->get_code_tdf());
							   }else{
							   	remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',"");
							   }
					   		?>
					   		<?php
							   if(isset($_POST['code_tdf'])){
							  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$_POST['code_tdf']);
							   }else{
							   	remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',"");
							   }
					  		 ?>
					   		</select>
						</p>
						<p>
							<label for="annee_sponsor">Date de Creation du sponsor : </label> 
							<select name="annee_sponsor" >
								<?php if(isset($sponsor)){remplirComboboxDate(50,$sponsor->get_annee_sponsor());}else{remplirComboboxDate(50,0);}
									  if(isset($_POST['annee_sponsor'])){remplirComboboxDate(50,$_POST['annee_sponsor']);}else{remplirComboboxDate(50,0);} ?>
							</select>
						</p>
					</fieldset>

					<br />
					<?php if (!isset($_POST['executer'])){ ?>
					<fieldset>
					<legend>Renseignement d'une équipe </legend>
						<p>
							<input type="radio" name='selectionEquipe' value="equipeExistante"/>
							<label for='dernierSponsorEquipe'>Equipe existante :</label> 
							<select name="dernierSponsorEquipe">
								<?php remplirComboboxSQLEquipeSponsor($bdd->getBDD(),"SELECT nom,n_equipe,n_sponsor FROM tdf_equipe JOIN tdf_sponsor USING (n_equipe)WHERE annee_disparition is null AND (n_equipe,n_sponsor) in ( SELECT n_equipe, max(n_sponsor)FROM tdf_sponsor GROUP BY n_equipe )ORDER BY nom asc","NOM","N_EQUIPE",-1,0);?>
							</select> 
						</p>
						
						<p>
							<input type="radio" name='selectionEquipe' value="equipeNouvelle" />
							<label for='nouvelleEquipe'>Nouvelle équipe :</label>
						</p>
						<p>
							<label for="dateCreationEquipe">Date de création de l'équipe* : </label>
							<select name="dateCreationEquipe">
							<?php if(isset($coureur)){
								remplirComboboxDate(50,$coureur->get_annee_naissance());
							}else{remplirComboboxDate(50,0);
							}
							if(isset($_POST['annee_sponsor'])){
								remplirComboboxDate(50,$_POST['date_naissance']);
							}else{remplirComboboxDate(50,0);
							} ?>
							</select>
						</p>

						<p>
							<label for="dateDisparitionEquipe">Date de disparition de
								l'équipe : </label> <select name="dateDisparitionEquipe">
								<?php if(isset($coureur)){
									remplirComboboxDate(50,$coureur->get_annee_naissance());
								}else{remplirComboboxDate(50,0);
								}
								if(isset($_POST['annee_sponsor'])){
									remplirComboboxDate(50,$_POST['date_naissance']);
								}else{remplirComboboxDate(50,0);
								} ?>
							</select>
						</p>
					</fieldset>
					<?php } ?>	
					<br /><br />
					<?php 
						if (isset($sponsor)){
		         		 	echo "<input type=\"hidden\" name=\"idEquipeRecherche\" value =".$sponsor->get_n_equipe().">";
		         		 	echo "<input type=\"hidden\" name=\"idSponsorRecherche\" value =".$sponsor->get_n_sponsor().">";
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
		         		
		         	?>	 
				</form>
			</fieldset>
			<p>*Champ obligatoirement rempli</p>

			<div id='messageRetour' style="color: green;">
				<p>
					<?php if(isset($message_confirmation)){echo $message_confirmation;} ?>
				</p>
			</div>
			<div id='messagRetour' style="color: red;">
				<p><?php if(isset($message_annulation)){echo $message_annulation;} ?></p>
			</div>
		</div>
	</div>
	<div id="footer">
		<script type="text/javascript"
			src="../controleur/confirmation_avant_crud.js"></script>
	</div>

</body>
</html>


