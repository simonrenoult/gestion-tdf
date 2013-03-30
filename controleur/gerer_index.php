<?php 

	if(isset($_POST['confirmer']))
	{
		if(($_POST['utilisateur'] == "admin") && ($_POST['mdp'] == "admin"))
		{
			setcookie('identifiant',$_POST['utilisateur'], time() + 365*24*3600,
			null, null, false, true);
			header('Location: ./gerer_cookies.php');
			
		}
		else
		{
			header('Location: ../index.php');
		}
	}
	else
	{
		echo "else";
	}
	
?>