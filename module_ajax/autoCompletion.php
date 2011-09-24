<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--
	Include obligatoire afin de permettre l'initialisation des variables javascript avec la fonction " autoCompletion_init(...) "
-->
<?php include ("./autoCompletion_module/autoCompletion_config.php"); ?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title><?php echo $table; ?></title>
		
		<!--
			HEADER obligatoire pour le module d'autoCompletion
		-->
		<link rel="stylesheet" type="text/css" href="./autoCompletion_module/css/autoCompletion_style.css">
		<script type="text/javascript" src="./autoCompletion_module/js/autoCompletion_lib.js"></script>
		<script type="text/javascript">
			autoCompletion_init('<?php echo $border_no_foc ?>','<?php echo $border_foc ?>','<?php echo $background_color_no_foc ?>','<?php echo $background_color_foc ?>','<?php echo $file_ref ?>');
		</script>
		<!--
			FIN HEADER du module de l'autoCompletion
		-->
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="../css_files/coureur.css"  /> 	
	</head>
	<body>
	
		<div id="header">
			
			<h1>Base d'administration des tables du TDF 2011</h1>
			<h3><i><?php echo "Accueil > Administration > ". $table.", utilisateur : ".$login_base ?></i></h3>
				
		</div>
		
		<div id="listeTable">
			<p>Liste des Tables :
			 <ul>

	            <li><a href="formulaire.php?nom=coureur">TDF_COUREUR</a></li>
	            <li><a href="formulaire.php?nom=pays">TDF_PAYS</a></li>
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
							<input id="list0" type=text size=50 name="autoCompletion_input"  onMouseOver="give_focus_style(0,1);" onBlur="focus_off();" onFocus="focus_on();" onKeyUp="event_capture(this.value,event);">
						</div>
						<div id="autoCompletion_answer" onClick="focus_on();"></div>
					</form>
					<!--
						FIN de la partie BODY du module d'autoCompletion
					-->
					</center>
					<center>
					
					<?php
					echo "avant if";
					//print_r($_GET);
					include_once '../php_files/php_class/bdd.class.php';
					if ((isset($_GET['id'])) && (!empty($_GET['id']))){
					echo "dans if";
						
						//on recupere la ligne de la base de donnee correspondant à celui selectionné.
						if($table == 'TDF_COUREUR'){
							$req = "select * from ".$table." where ".$field_id." =".$_GET['id'];
						}
						
						if($table == 'TDF_PAYS'){
							$req = "select * from ".$table." where ".$field_id." LIKE '".$_GET['id']."'";
						}
						
						$bdd = new BDD();
						$query = $bdd->getBDD()->query($req);
						$data_bdd = array();
						while ($donnee = $query->fetch(PDO::FETCH_ASSOC)){
							$data_bdd = $donnee; 
						}
						$query->closeCursor();
						//print_r($data_bdd);
						//echo "<input type=\"hidden\" name=\"id\" value =".$_GET['id'].">";
					
						
					}
					echo "apres if";	
					?>
					
					</center>
				
			</div>	
		</fieldset>
		</div>	
		
		