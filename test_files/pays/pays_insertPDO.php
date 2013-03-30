<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/pays.class.php";
	
	$bdd = new bdd();
	$pays = new pays("SIM", "IM", "SIMON");
	$pays->create($bdd->get_bdd());
?>