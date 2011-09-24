<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/pays.class.php";
	
	$bdd = new bdd();
	$pays = new pays("SIM", "ZZ", "lalalala");
	$pays->read($bdd->get_bdd(), "SIM");
	$pays->display();
?>