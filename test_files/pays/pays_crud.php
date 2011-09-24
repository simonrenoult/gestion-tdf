<?php

	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/pays.class.php";
	
	echo '<h3>Connexion à la base de données...</h3>';
	$bdd = new bdd();
	print_r($bdd);
	
	echo'<h3>Creation d\'un pays...</h3>';
	$pays = new pays("SIM", "IM", "SIMON");
	$pays->display();
		
	echo '<h3>Upload en base de données...</h3>';
	$pays->create($bdd->get_bdd());
	unset($pays);
	
	echo '<h3>Lecture d\'un pays dans la base de données...</h3>';
	$pays = new pays();
	$pays->read($bdd->get_bdd(), "SIM");
	$pays->display();
	
	echo '<h3>Mise a jour d\'un pays de la base de données...</h3>.';
	$pays = new pays("SIM", "IM", "Somin");
	$pays->update($bdd->get_bdd());
	$pays->display();
		
	echo '<h3>Suppression du pays...</h3>';
	$pays->delete($bdd->get_bdd());

?>