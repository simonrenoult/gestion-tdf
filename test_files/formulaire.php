<?php

	include './regexp.php';
	
	if(isset($_POST['valider'])) {
		
		$txt	= $_POST['texte'];
		$nb 	= $_POST['nombre'];
		
		echo (majuscule($txt))? 'majuscule' : 'minuscule';
		
		
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
					Texte<br /><input name = "texte" type="text"/><br />
					Nombre<br /><input name="nombre" type="text"/><br />
					<input name = "valider" type="submit"/>
				</form>
			</body>
		</html>
		
		<?php 
	}

?>