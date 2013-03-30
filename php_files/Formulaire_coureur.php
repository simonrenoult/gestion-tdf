<div id="formulaire">
			
		
	
	<fieldset>
	<legend> Gestion d'un coureur </legend>	
	
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
		
		
			
		
		   <?php 
		        include'comboboxFormulaire.php';
		       //

		        //include './php_class/bdd.class.php';
		        $bdd = new BDD();
		      
		    ?>
		    
		   <p><label for="nom">Nom* : </label><input type="text" name="nom" value ="<?php if (isset($data_bdd)){echo $data_bdd['NOM'];}else{echo "";} ?>"/></p>
	       <p><label for="prenom">Prenom* : </label><input type="text" name="prenom" value ="<?php if (isset($data_bdd)){echo $data_bdd['PRENOM'];}else{echo "";} ?>"/></p>  
	       <p><label for="date_naissance">Date de Naissance : </label>
	       	<select name="date_naissance" id="date_naissance">
	       	<?php if(isset($data_bdd)){remplirComboboxDate(50,$data_bdd['ANNEE_NAISSANCE']);}else{remplirComboboxDate(50,0);} ?>
	       	</select>
	        </p>  
	        
	       <p><label for="pays_origine">Pays d'origine* : </label> 
	       <select name="pays_origine" id="pays_origine"> 
		   <?php 
		   if(isset($data_bdd)){
		  		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',$data_bdd['CODE_TDF']);
		   }else{
		   		remplirComboboxSQL($bdd->getBDD(),'Select * from tdf_pays order by nom asc', 'NOM', 'CODE_TDF',"");
		   }	
		   	?>   
		   	
		   </select>
		   </p>  
	        
	       	    
		     <p><label for="annee_tdf">Annee de votre premier tour de france : </label>
	         <select name="annee_tdf" id="annee_tdf">
	       	 <?php if(isset($data_bdd)){remplirComboboxDate(50,$data_bdd['ANNEE_TDF']);}else{remplirComboboxDate(50,0);} ?>
	         </select>
	         </p>  
	         
	         
	         <?php 
	         		 if (isset($data_bdd)){
	         		 	echo "<input type=\"hidden\" name=\"id\" value =".$data_bdd['N_COUREUR'].">";
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
