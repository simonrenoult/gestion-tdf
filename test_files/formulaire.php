<?php

	include '../php_files/regexp.php';
	
	if(isset($_POST['valider'])) {
		
		$txt	= $_POST['texte'];
		
		echo (contr_prenom_coureur($txt))? 'oui' : 'non';
		
		header("Refresh:1;URL=./formulaire.php");
		
	}
	else {
		?>
		
		<html>
			<head>
				<title>Formulaire standard</title>
			</head>
			<body>
				<h3>Mon formulaire</h3>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
					Champ à tester : <br /><input name = "texte" type="text"/><br />
					<input name = "valider" type="submit"/>
				</form>
			</body>
		</html>
		
		<?php 
	}

?>