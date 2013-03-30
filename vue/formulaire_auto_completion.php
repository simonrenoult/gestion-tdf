<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title><?php echo $table; ?></title>
		<link rel="stylesheet" type="text/css" href="../vue/css/autoCompletion_style.css">
		<script type="text/javascript" src="../modele/autoCompletion_lib.js"></script>
		<script type="text/javascript">
			autoCompletion_init('<?php echo $border_no_foc ?>','<?php echo $border_foc ?>','<?php echo $background_color_no_foc ?>','<?php echo $background_color_foc ?>','<?php echo $file_ref ?>');
		</script>
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="../vue/css/style.css" />
	</head>
	
	<body>
		<div id="header">
			<img class="Ttdf_image" src="../vue/img/tour_de_france1.png" />
			<div class="menu">
				<ul>
					<li><a href="../controleur/gerer_cookies.php">Administration</a></li>
					<li><a href="../controleur/gerer_formulaire_requete_manuelle.php">SQL</a></li>
					<li><a href="../vue/journal_transaction.php">Journal des tansactions</a></li>
				</ul>
			</div>
		</div>
		
		<div id="subheader">
			<div class="bdd">
				<h3>Base d'administration des tables du TDF 2011</h3>
				<h5>
					<i><a href="../controleur/gerer_cookies.php"> Administration</a> 
					   <a><?php echo "> ".$table; ?></a> 
					</i>
				</h5>
			</div>
			<div class="usr">
				<h5>
					<i><?php echo "utilisateur : ".$_COOKIE['identifiant']; ?> </i>
				</h5>
				<a href="../index.php">Deconnexion</a>
			</div>
		</div>	
		
		<div id="corps">
			<div id="listeTable">
				<p>Liste des Tables :
				<ul>
					<li><a href="gerer_cookies.php?nom=coureur">TDF_COUREUR</a></li>
					<li><a href="traitement_formulaire_annee.php?nom=annee">TDF_ANNEE</a></li>
					<li><a href="traitement_formulaire_epreuve.php?nom=epreuve">TDF_EPREUVE</a></li>
					<li><a href="gerer_cookies.php?nom=pays">TDF_PAYS</a></li>
					<li><a href="traitement_formulaire_equipe.php?nom=equipe">TDF_EQUIPE/SPONSOR</a></li>
					<li><a href="gerer_cookies.php?nom=directeur">TDF_DIRECTEUR</a></li>
					<li><a href="traitement_formulaire_participation.php?nom=participation">TDF_PARTICIPATION</a></li>
					
				</ul>
			</div>
			
			<div id="left_side">
				<fieldset>
					<legend>Rechercher :</legend>
					<div id="recherche">
						<center>
							<!--
							DEBUT de la partie obligatoire a definir dans la partie BODY
									Ne modifiez surtout pas cette partie sinon cela ne fonctionnera plus...
							-->
							<form action="#" name="autoCompletion" onSubmit="return false;">
								<div id="autoCompletion_input">
									<input id="list0" type=text size=50 name="autoCompletion_input"
										onMouseOver="give_focus_style(0,1);" onBlur="focus_off();"
										onFocus="focus_on();"
										onKeyUp="event_capture(this.value,event);">
								</div>
								<div id="auto_completion_reponse" onClick="focus_on();"></div>
							</form>
							<!--
							FIN de la partie BODY du module d'autoCompletion
							-->
						</center>
						<center>

						<?php
						
						if ((isset($_GET['id'])) && (!empty($_GET['id']))){
							//print_r($_GET);
							$bdd = new BDD();
							//on recupere la ligne de la base de donnee correspondant à celui selectionné.
							if($table == 'TDF_COUREUR'){
								$coureur = new coureur();
								$coureur->read($bdd->getBDD(),$_GET['id']);
							}
							if($table == 'TDF_PAYS'){
								$pays = new pays();
								$pays->read($bdd->getBDD(),$_GET['id']);
							}
							if($table == 'TDF_DIRECTEUR'){
								$directeur = new directeur();
								$directeur->read($bdd->getBDD(),$_GET['id']);
							}
						}						
						?>
						</center>
					</div>
				</fieldset>
			</div>