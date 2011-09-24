<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/directeur.class.php";
	
	$bdd = new bdd();
	$directeur = new directeur(1,"RENOULT","Simon");
	$directeur->create($bdd->get_bdd());
	
?>