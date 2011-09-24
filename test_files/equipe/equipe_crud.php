<?php

	include "../../php_files/php_class/bdd.class.php";
	include "../../php_files/php_class/equipe.class.php";
	
	echo '<h3>Connexion à la base de données...</h3>';
	$bdd = new bdd();
	print_r($bdd);
	
	echo'<h3>Creation d\'une équipe...</h3>';
	$eq = new equipe(666, 1995, 2011);
	print_r($eq);
	
	echo '<h3>Upload en base de données...</h3>';
	$eq->create($bdd->get_bdd());
	
	echo '<h3>Lecture d\'une equipe dans la base de données...</h3>';
	$eq = new equipe();
	print_r($eq);
	$eq->read($bdd->get_bdd(), 666);
	print_r($eq);
	
	echo '<h3>Mise a jour d\'une equipe de la base de données...</h3>.';
	$eq = new equipe(666, 1995, 2012);
	$eq->update($bdd->get_bdd());
	
	echo '<h3>Suppression de l\'equipe...</h3>';
	$eq->delete($bdd->get_bdd());
?>