<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/pays.class.php";
	
	$bdd = new bdd();
	$pays = new pays("SIM", "IM", "Somin");
	$pays->update($bdd->get_bdd());
	
?>