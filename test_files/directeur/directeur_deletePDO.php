<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/coureur.class.php";
	
	$bdd = new bdd();
	$directeur = new directeur(1);	
	$directeur->delete($bdd->get_bdd());
	

?>