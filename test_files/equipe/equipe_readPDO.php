<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/equipe.class.php";
		
	$bdd = new bdd();
	$eq = new equipe();
	$eq->read($bdd->get_bdd(), 1);
	print_r($eq);
	
?>