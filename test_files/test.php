<?php 

/*
	$array1 = explode(" ","les tests marchent !");
	print_r($array1);
	echo "</br>";

	$array = array("alexis","le","plus","fort");
	print_r($array);
	echo "</br>";
	
	$chaine = implode($array," ");
	echo $chaine;
	
	$tab = range("a","z");
	print_r($tab);
	echo "</br>";
		
	array_push($array1, "2");
	print_r($array1);
	echo "</br>";
	
	//$array3 = new $arrayObject();
	//$array3->
	
	//ex8
		$tab = array(
		
			'chretienne'=>array(
								'prenom'=>'alexis',
								'dateN'=>'1990'),
			'Lecannuet'=>array('anais','1991')
		);
					

		
		echo $tab['chretienne']['prenom'],"</br>";
		echo $tab['Lecannuet'][1];
		
		*/

	//formulaire.
	?>
	
	<?php 
	
	//bonne solution : le code PHP ci après est mis dans un fichier.php auquel on fera un include.
	include 'traitementTest.php';
	?>
	
	
	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post' enctype="multipart/form-data">
	
		<p><label for = 'nom' >Nom :</label><input type='text' name='nom' value=
		<?php if (isset($_POST['valider'])){echo "$nom"; }else {echo "'votre nom'";} ?>
		/></p>
		
		<p><label for = 'photo'>Parcourir : </label><input type="file" name='photo' /></p>
		
		
		<p><input type='submit' name='valider' value = 'valider' /></p>

	</form>
	
	
	
	
	
	
	