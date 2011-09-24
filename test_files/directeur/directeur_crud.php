<?php

	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/directeur.class.php";
	
	echo '<h3>Connexion à la base de données...</h3>';
	$bdd = new bdd();
	print_r($bdd);
	
	echo'<h3>Creation d\'un directeur...</h3>';
	$directeur = new directeur(1,"RENOULT","Simon");
	$directeur->display();
		
	echo '<h3>Upload en base de données...</h3>';
	$directeur->create($bdd->get_bdd());	
	
	echo '<h3>Lecture d\'un coureur dans la base de données...</h3>';
	$directeur2 = new directeur();
	$directeur2->display();
	$directeur2->read($bdd->get_bdd(), 1);
	$directeur2->display();
	
	echo '<h3>Mise a jour d\'un coureur de la base de données...</h3>.';
	$directeur = new directeur(1,"RENO", "Simon");
	$directeur->update($bdd->get_bdd());
		
	echo '<h3>Suppression du coureur...</h3>';
	$directeur->delete($bdd->get_bdd());

?>