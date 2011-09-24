<?php

//inclusion du code de traitement.

if(isset($_COOKIE['nom'])){//si un cookie a été créé (premier accès au formulaire).

	if (isset($_GET['nom']))//si il connait 'nom'
		{
			setcookie('nom',$_GET['nom'], time() + 365*24*3600);
			chargerFormulaire();
	}else {
			$_GET['nom'] = $_COOKIE['nom'];
			chargerFormulaire();
		}
		
}
else{//on créé juste un cookie.
	setcookie('nom',"coureur", time() + 365*24*3600);
	include 'autoCompletion.php';
	echo "</body>";
	echo "</html>";
}		
		

	function chargerFormulaire(){
		echo './autoCompletion_module/config_files/'.$_GET['nom'].'Config.php',"<br>";
		echo '../php_files/Formulaire_'.$_GET['nom'].'.php',"<br>";
		$fichierConfig = './autoCompletion_module/config_files/'.$_GET['nom'].'Config.php';
		$fichierFormulaire = '../php_files/Formulaire_'.$_GET['nom'].'.php';
		
		copy($fichierConfig, "./autoCompletion_module/autoCompletion_config.php");
		include 'autoCompletion.php';
		include ''.$fichierFormulaire.'';
	}

?>