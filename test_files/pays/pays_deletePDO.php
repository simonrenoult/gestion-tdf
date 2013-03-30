<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/pays.class.php";
	
	$bdd = new bdd();
	$pays = new pays("SIM");
	$pays->delete($bdd->get_bdd());

?>