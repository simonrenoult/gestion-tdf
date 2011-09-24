<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/coureur.class.php";
	
	$bdd = new bdd();
	$coureur = new coureur(1,"RENOULT","Simon","ALL");
	$coureur->create($bdd->get_bdd());
	
?>