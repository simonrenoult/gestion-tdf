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
				<legend>Rechercher une épreuve :</legend>
					<div id="recherche">
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<?php  $bdd = new BDD(); ?>

						<p><label for='annee_epreuve'>Année de l'épreuve :</label> 
							<select name="annee_epreuve">
							<?php remplirComboboxSQL($bdd->getBDD(),"Select distinct ANNEE from tdf_epreuve order by ANNEE asc","ANNEE","ANNEE",-1,0);?>
							</select>
						</p>
						
						<p><label for='num_epreuve'>Numéro de l'épeuve :</label> 
							<select name="num_epreuve">
							<?php remplirComboboxSQL($bdd->getBDD(),"Select distinct n_epreuve from tdf_epreuve order by N_EPREUVE asc","N_EPREUVE","N_EPREUVE",-1,0);?>
							</select>
						</p>

						<input type="submit" name="executer" value="Exécuter la recheche" />
						<div id='messageRetour' style="color:red;">
						<p>
						<?php if(empty($data_bdd) && isset($messageFiltre)){
							echo $messageFiltre;
						} ?>
						</p>
						</div>
						
					</form>

				</div>
			</fieldset>
		</div>
		<div id="formulaire">
			<fieldset>
				<legend> Gestion d'une épreuve </legend><br>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

					<?php if ((isset($_POST['valider']))|| (isset($_POST['supprimer']))|| (isset($_POST['reinitialiser']))|| (empty($_POST))){ ?>
						<p>
							<label for="annee">Année de l'épreuve* : </label>
							<select name="annee">
							<?php if(isset($epreuve)){
								remplirComboboxDate(50,$epreuve->get_annee());
							}if(isset($_POST['annee'])){
								remplirComboboxDate(50,$_POST['annee']);
							}else{remplirComboboxDate(20,0);
							} ?>
							</select>
						</p>
						
						<p>
							<label for="n_epreuve">Numéro de l'épreuve* : </label>
							<select name="n_epreuve">
							<?php if(isset($epreuve)){
								remplirComboboxNombre(0,21,$epreuve->get_n_epreuve());
							}if(isset($_POST['n_epreuve'])){
								remplirComboboxNombre(0,21,$_POST['n_epreuve']);
							}else{remplirComboboxNombre(0,21,22);
							} ?>
							</select>
						</p>
					
					<?php }
					else{
						if (isset($epreuve)){
							echo "<label>épreuve ".$epreuve->get_n_epreuve()." du TDF  ".$epreuve->get_annee()."</label>";
							echo "<input type=\"hidden\" name=\"annee\" value =".$epreuve->get_annee().">";
							echo "<input type=\"hidden\" name=\"n_epreuve\" value =".$epreuve->get_n_epreuve().">";
						}
						else if  (isset($idAnnee)){
							echo "<label>épreuve ".$idNepreuve." du TDF  ".$idAnnee."</label>";
							echo "<input type=\"hidden\" name=\"annee\" value =".$idAnnee.">";
							echo "<input type=\"hidden\" name=\"n_epreuve\" value =".$idNepreuve.">";
						}
					}
					?>
						
					<p><label for="code_tdf_d">Pays de départ* : </label>
					<select name="code_tdf_d" > 
				  		 <?php
						   if(isset($epreuve)){
						  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$epreuve->get_code_tdf_d());
						   }else if(isset($_POST['code_tdf_d'])){
						  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$_POST['code_tdf_d']);
						   }else{
						   	remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',"");
						   }
				  		 ?>
			   		</select>
					</p>
					
					<p>
					<label for='ville_d'>Ville de départ* :</label> <input type='text'name="ville_d" 
					value="<?php if (isset($epreuve)){echo $epreuve->get_ville_d();} 
					 	 		else if (isset($_POST['ville_d'])){echo$_POST['ville_d'];}else{echo "";}
					?>" />
					</p>
					
					
					<p><label for="code_tdf_a">Pays d'arrivée* : </label>
						<select name="code_tdf_a" > 
				  		 <?php
						   if(isset($epreuve)){
						  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$epreuve->get_code_tdf_a());
						  }if(isset($_POST['code_tdf_a'])){
						  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$_POST['code_tdf_a']);
						   }else{
						   	remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',"");
						   }
				  		 ?>
				   		</select>
					</p>
					
					<p>
						<label for='ville_a'>Ville d'arrivée* :</label>
						<input type='text'name="ville_a" 
						value="<?php if (isset($epreuve)){echo $epreuve->get_ville_a();}  
						 	 		 else if (isset($_POST['ville_a'])){echo$_POST['ville_a'];}else{echo "";}
						?>" />
					</p>

					<p>
						<label for='distance'>Distance* :</label>
						<input type='text'name="distance" 
						value="<?php if (isset($epreuve)){echo $epreuve->get_distance();} 
						 	 		 else if (isset($_POST['distance'])){echo$_POST['distance'];}else{echo "";}
						?>" />
					</p>
					
					<p>
						<label for='moyenne'>Moyenne :</label>
						<input type='text'name="moyenne" 
						value="<?php if (isset($epreuve)){echo $epreuve->get_moyenne();} 
						 	 		else if (isset($_POST['moyenne'])){echo$_POST['moyenne'];}else{echo "";}
						?>" />
					</p>
					
					
					<p>
						<label for="jour">Jour* : </label>
						<select name="date_jour">
						<?php if(isset($epreuve)){
								remplirComboboxNombre(1,31,$epreuve->get_date_jour());
							}else if(isset($_POST['date_jour'])){
							remplirComboboxNombre(1,31,$_POST['date_jour']);
							}else{remplirComboboxNombre(1,31,32);
						} ?>
						</select>
						<label for="jour"> / </label>
						<select name="date_mois">
						<?php if(isset($epreuve)){
								remplirComboboxNombre(1,12,$epreuve->get_date_mois());
							}else if(isset($_POST['date_mois'])){
								remplirComboboxNombre(1,12,$_POST['date_mois']);
							}else{remplirComboboxNombre(1,12,13);
						} ?>
						</select>
						<label for="jour"> / </label>
						<select name="date_annee">
						<?php if(isset($epreuve)){
								remplirComboboxDate(20,$epreuve->get_date_annee());
							}else if(isset($_POST['date_annee'])){
								remplirComboboxDate(20,$_POST['date_annee']);
							}else{remplirComboboxDate(20,0);
						} ?>
						</select>
					</p>
					
					<p>
					<label for="cat_code">catégorie * : </label>
					<select name="cat_code" > 
				  		 <?php
						   if(isset($epreuve)){
						  		remplirComboboxSQL($bdd->getBDD(),'Select distinct cat_code from tdf_epreuve order by cat_code asc', 'CAT_CODE', 'CAT_CODE',$epreuve->get_cat_code());
						   }else if(isset($_POST['cat_code'])){
						  		remplirComboboxSQL($bdd->getBDD(),'Select distinct cat_code from tdf_epreuve order by cat_code asc', 'CAT_CODE', 'CAT_CODE',$_POST['cat_code']);
						   }else{
						   	remplirComboboxSQL($bdd->getBDD(),'Select distinct cat_code from tdf_epreuve order by cat_code asc', 'CAT_CODE', 'CAT_CODE',"");
						   }
				  		 ?>
			   		</select>
					</p>

					<br /><br />
					<?php 
						if (isset($epreuve)){
		         		 	echo "<input type=\"hidden\" name=\"idAnnee\" value =".$epreuve->get_annee().">";
		         		 	echo "<input type=\"hidden\" name=\"idNepreuve\" value =".$epreuve->get_n_epreuve().">";
		         		 	echo "<input type=\"submit\" name=\"valider\" value=\"Ajouter\"  onclick=\"return attention();\" disabled/>";
		     				echo "<input type=\"submit\" name=\"maj\" value=\"Mettre à jour\" onclick=\"return attention();\" />";
		         		 	echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" onclick=\"return attention();\"  />";
		         		 	echo "<input type=\"submit\"   name=\"reinitialiser\" value=\"Réinitialiser\"/>";
		         		 }
		         		 else if (isset($_POST['idAnnee'])){
		         		 	echo "<input type=\"hidden\" name=\"idAnnee\" value =".$_POST['idAnnee'].">";
		         		 	echo "<input type=\"hidden\" name=\"idNepreuve\" value =".$_POST['idNepreuve'].">";
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
					<p>
					<?php if(isset($message_annulation)){echo $message_annulation;} ?>
					</p>
				</div>
			</div>
		</div>
		<div id="footer">
			<script type="text/javascript" src="../controleur/confirmation_avant_crud.js"></script>
			<script type="text/javascript" src="../modele/jquery_lib.js"></script>
			<script type="text/javascript" src="../controleur/verifications_formulaire_epreuve.js"></script>
			<script type="text/javascript">
			<!--
				c_ville_epreuve('ville_d');
				c_ville_epreuve('ville_a');
				c_nombre_epreuve('distance',3,1);
				c_nombre_epreuve('moyenne',2,3);
			//-->
    </script>
		</div>

</body>
</html>


