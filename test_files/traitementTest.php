<?php

error_reporting(E_ALL);
	
	//var_dump(isset($_POST['valider']));
	print_r($_POST);
	print_r($_FILES);
	if (isset($_POST['valider'])) {
		$nom = $_POST['nom'];
		$path = 'tmp/'.$_FILES['photo']['name'];
		echo $path;
		//echo $fichier;
		//echo $_FILES[$fichier]["name"];
		var_dump(move_uploaded_file($_FILES['photo']['tmp_name'],$path));
		//echo "==========================>Nom : $nom";
	}
	else { echo "Nom absent";}
	
	

?>