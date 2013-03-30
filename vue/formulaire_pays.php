<div id="formulaire">
	<fieldset>
	<legend> Gestion d'un Pays </legend>	
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
			<?php $bdd = new BDD();?>
			<p>
				<label for="nom">Nom* : </label>
			    <input type="text" name="nom" 
			   	value="<?php if (isset($pays)){echo $pays->get_nom();} 
							 else if (isset($_POST['nom'])){echo$_POST['nom'];}else{echo "";}
						?>" />
			</p>
		  
		   <p>
			   <label for="code_pays">Code (pays)* : </label>
			   <input type="text" name="code_pays" 
			   	 value="<?php if (isset($pays)){echo $pays->get_c_pays();}  
							  else if (isset($_POST['code_pays'])){echo$_POST['code_pays'];}else{echo "";}
						?>" />
			</p>
		   
		   
		   <?php if ((!isset($pays)) && !isset($_POST['id'])) {  ?> 
			   <p>
				   <label for="code_tdf">Code (tdf)* : </label>
				   <input type="text" name="code_tdf" 
				    value="<?php if (isset($pays)){echo $pays->get_code_tdf();}  
								 else if (isset($_POST['code_tdf'])){echo$_POST['code_tdf'];}else{echo "";}
							?>" />
				</p>
		  <?php } ?>
		

	  		<?php 
				if (isset($pays)){
         		 	echo "<input type=\"hidden\" name=\"id\" value =".$pays->get_code_tdf().">";
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
	         <br><br>
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
<div id="footer">
		<script type="text/javascript" src="../controleur/confirmation_avant_crud.js"></script>
</div>

</body>
</html>


