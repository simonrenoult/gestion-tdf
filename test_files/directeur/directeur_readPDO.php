<?php

	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/coureur.class.php";
	
	$bdd = new bdd();
	$directeur = new directeur();
	$directeur2->read($bdd->get_bdd(), 1);
	print_r($directeur2);
	
?>