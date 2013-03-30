<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Accueil</title>	
		<link rel="stylesheet" media="screen" type="text/css" title="Design"
			href="./vue/css/style.css" />
	</head>
	
	<body>
		<div id="header">
			<img class="Ttdf_image" src="./vue/img/tour_de_france1.png" />
		</div>			
		<div id="corps">					
			<div id="connexion">				
				<form action="./controleur/gerer_index.php" method="post">
					<fieldset>
					<legend> Identification </legend>
						<p><label for="utilisateur">Identifiant </label>
						<input type="text" name="utilisateur"/>
						</p>
						<p>
						<label for="mdp">Mot de passe </label>
						<input type="password" name="mdp"/>
						</p>
						<p>
						<input type="submit" name="confirmer" value="Connexion">
						</p>
					</fieldset>	
				</form>
			</div>
		</div>
		<div id="footer">
		</div>	
	</body>
</html>		