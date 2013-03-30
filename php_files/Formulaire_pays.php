 <?php 
	include'comboboxFormulaire.php';
  ?>

<div id="formulaire">
			
		
	
	<fieldset>
	<legend> Gestion d'un Pays </legend>	
	
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
		
			
		   <p><label for="nom">Nom* : </label><input type="text" name="nom" value ="<?php if (isset($data_bdd)){echo $data_bdd['NOM'];}else{echo "";} ?>"/></p>
		   <p><label for="code_pays">Code (pays)* : </label><input type="text" name="code_pays" value ="<?php if (isset($data_bdd)){echo $data_bdd['C_PAYS'];}else{echo "";} ?>"/></p>
		   <p><label for="code_tdf">Nom (tdf)* : </label><input type="text" name="code_tdf" value ="<?php if (isset($data_bdd)){echo $data_bdd['CODE_TDF'];}else{echo "";} ?>"/></p>
		   
	       
		 
	       	 <?php 
	         		 if (isset($data_bdd)){
	         		 	echo "<input type=\"hidden\" name=\"id\" value =".$data_bdd['CODE_TDF'].">";
	         		 }	
	         ?>
	         <br><br>
				
				<input type="submit" name="valider" value="Ajouter"  />
				<input type="submit" name="maj" value="Mettre à jour" />
				<input type="submit" name="supprimer" value="Supprimer" />
				<input type="submit"   name="reinitialiser" value="Réinitialiser"/>
				
	</form>
	</fieldset>
	<p>*Champ obligatoirement rempli</p>
	
	
	
</div>	
				
	</body>
</html>
	
	
	
	
	<!-- onSubmit = "return maFonctionJs();" , on clique et on renvoi sur une fonction javascript  -->
