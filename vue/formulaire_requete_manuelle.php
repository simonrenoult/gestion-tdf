<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Table coureur</title>
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="../vue/css/style.css"  /> 	
	</head>
	
	<body>
		<div id="header">
			<img class="Ttdf_image" src="../vue/img/tour_de_france1.png" />
			<div class="menu">
				<ul>
					<li><a href="../controleur/gerer_cookies.php">Administration</a></li>
					<li><a href="#">SQL</a></li>
					<li><a href="../vue/journal_transaction.php">Journal des tansactions</a></li>
				</ul>
			</div>
		</div>
		
		<div id="subheader">
			<div class="bdd">
				<h3>Base d'administration des tables du TDF 2011</h3>
				<h5><i>SQL</i></h5>
			</div>
			<div class="usr">
				<h5><i><?php echo "utilisateur : ".$_COOKIE['identifiant']; ?> </i></h5>
				<a href="../index.php">Deconnexion</a>
			</div>
		</div>
		
		<div id="scriptsql">
			<fieldset>
			<label>Votre requête SQL</label>
				<div id="zoneSQL">
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<div id="SQLarea">
						<textarea rows="10" cols="130" name="area"><?php 	if(isset($_POST['executer'])){echo trim($_POST['area']);}?></textarea>
					</div>				
						<input type="submit" name="executer" value="Executer"  />
					</form>				
					<div id = "tableauSQL">
						<?php remplirtab();?>
					</div>				
				</div>
			</fieldset>		
		</div>
			
		</div>
		<div id="footer">
		</div>
	</body>
</html>
	