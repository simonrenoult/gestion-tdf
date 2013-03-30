<?php
	
	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/coureur.class.php";
	
	$bdd = new bdd();
	$directeur = new directeur(1,"RENOULT", "Simon");
	$directeur->update($bdd->get_bdd());

?>