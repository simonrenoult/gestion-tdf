<?php

	include '../php_files/regexp.php';
	
	if(isset($_POST['valider'])) {
		
		$txt	= $_POST['texte'];
		$nb 	= $_POST['nombre'];
		
		echo (est_majuscule($txt))? 'oui' : 'non';
		
		
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