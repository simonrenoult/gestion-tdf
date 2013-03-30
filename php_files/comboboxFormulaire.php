<?php

	
	function remplirComboboxSQL($bdd,$requete,$libelle,$valeur,$valeurSelected){
		try {
			$req =  $bdd->query($requete);
			echo "<option value=NULL>-</option>","\n";
			while ($donnee = $req->fetch())
			{
				if($donnee[$valeur] == $valeurSelected){
					echo "<option value=$donnee[$valeur] selected=\"selected\">$donnee[$libelle]</option>","\n";
				}else{
					echo "<option value=$donnee[$valeur]>$donnee[$libelle]</option>","\n";
				}
				
			}
			$req->closeCursor();
		}catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}	       		 
	}
	
	function remplirComboboxDate ($ecart,$valeurSelected){
		//$valeurSelected = (int)$valeurSelected;
		$date = date("Y");
		echo "<option value=NULL>-</option>","\n";
		for ( $i =(String)$date; $i>=(int)$date-$ecart; $i-- ) {
			if ($i == $valeurSelected){
				echo "<option value=$i selected=\"selected\">$i</option>","\n";
			}
			else{
				echo "<option value=$i>$i</option>","\n";
			}
			
		}
		       		 		
	}


?>