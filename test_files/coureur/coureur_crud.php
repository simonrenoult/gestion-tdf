<?php

	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/coureur.class.php";
	
	echo '<h3>Connexion à la base de données...</h3>';
	$bdd = new bdd();
	print_r($bdd);
	
	echo'<h3>Creation d\'un coureur...</h3>';
	$coureur = new coureur(1,"RENOULT","Simon","ALL");
	print_r($coureur);
	
	echo '<h3>Upload en base de données...</h3>';
	$coureur->create($bdd->get_bdd());
	
	echo '<h3>Lecture d\'un coureur dans la base de données...</h3>';
	$coureur2 = new coureur();
	print_r($coureur2);
	$coureur2->read($bdd->get_bdd(), 1);
	print_r($coureur2);
	
	echo '<h3>Mise a jour d\'un coureur de la base de données...</h3>.';
	$coureur = new coureur(1,"RENOULT", "Simon","FRA");
	$coureur->update($bdd->get_bdd());
	
	echo '<h3>Suppression du coureur...</h3>';
	$coureur->delete($bdd->get_bdd());

?>