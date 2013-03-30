<div id="formulaire">
	<fieldset>
	<legend> Gestion d'un coureur </legend>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<?php $bdd = new BDD(); ?>
			<p>
				<label for="nom">Nom* : </label><input type="text" name="nom"
					value="<?php if (isset($coureur)){echo $coureur->get_nom();}
								 else if (isset($_POST['nom'])){echo$_POST['nom'];}else{echo "";}
							?>" />
			</p>
			<p>
				<label for="prenom">Prenom* : </label><input type="text"
					name="prenom"
					value="<?php if (isset($coureur)){echo $coureur->get_prenom();} 
								 else if (isset($_POST['prenom'])){echo$_POST['prenom'];}else{echo "";}
							?>" />
			</p>
			
			<p>
				<label for="date_naissance">Date de Naissance : </label> <select
					name="date_naissance" id="date_naissance">
					<?php if(isset($coureur)){remplirComboboxDate(50,$coureur->get_annee_naissance());}
						  else if(isset($_POST['date_naissance'])){remplirComboboxDate(50,$_POST['date_naissance']);}else{remplirComboboxDate(50,0);} ?>
				</select>
			</p>
			
			<p>
				<label for="annee_tdf">Annee du premier tour de France : </label>
				<select name="annee_tdf" id="annee_tdf">
					<?php if(isset($coureur)){remplirComboboxDate(50,$coureur->get_annee_tdf());}
						  else if(isset($_POST['annee_tdf'])){remplirComboboxDate(50,$_POST['annee_tdf']);}else{remplirComboboxDate(50,0);}
					 ?>
				</select>
			</p>

			<p>
			<label for="pays_origine">Pays d'origine* : </label>
				<select name="pays_origine" id="pays_origine"> 
				   <?php
					   if(isset($coureur)){
					  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$coureur->get_code_tdf());
					   }
					  else if(isset($_POST['pays_origine'])){
					  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$_POST['pays_origine']);
					   }else{
					   	remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',"");
						}
					?>
				</select>
			</p>
			<?php 
				 if (isset($coureur)){
         		 	echo "<input type=\"hidden\" name=\"id\" value =".$coureur->get_n_coureur().">";
         		 	echo "<input type=\"submit\" name=\"valider\" value=\"Ajouter\"  onclick=\"return attention();\" disabled/>";
     				echo "<input type=\"submit\" name=\"maj\" value=\"Mettre à jour\" onclick=\"return attention();\" />";
         		 	echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" onclick=\"return attention();\"  />";
         		 	echo "<input type=\"submit\"   name=\"reinitialiser\" value=\"Réinitialiser\"/>";
         		 }
         		 else if (isset($_POST['id'])){
         		 	echo "<input type=\"hidden\" name=\"id\" value =".$_POST['id'].">";
         		 	 
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

