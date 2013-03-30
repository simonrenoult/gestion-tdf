<?php

	if(isset($_COOKIE['nom']))
	{
		if (isset($_GET['nom']))
		{
			setcookie('nom',$_GET['nom'], time() + 365*24*3600);
			include '../controleur/gerer_creation_formulaire.php';		
		}
		else
		{
			$_GET['nom'] = $_COOKIE['nom'];
			include '../controleur/gerer_creation_formulaire.php';	
		}
	}
	else
	{
		setcookie('nom',"coureur", time() + 365*24*3600);
		header('Location: gerer_cookies.php');
	}

?>