<?php include '../modele/transaction.class.php';
		transaction::$fichier='../vue/log';
?>
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
					<li><a href="../controleur/gerer_formulaire_requete_manuelle.php">SQL</a></li>
					<li><a href="#">Journal des tansactions SQL</a></li>
				</ul>
			</div>
		</div>
		
		<div id="subheader">
			<div class="bdd">
				<h3>Base d'administration des tables du TDF 2011</h3>
				<h5><i>Journal des transactions SQL</i></h5>
			</div>
			<div class="usr">
				
				<a href="../index.php">Deconnexion</a>
			</div>
		</div>
		
		<div id="transaction">
		<?php 
			transaction::lire_transactions();
		?>
		</div>
			
		</div>
		<div id="footer">
		</div>
	</body>
</html>
	