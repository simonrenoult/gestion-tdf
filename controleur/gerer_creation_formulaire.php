<?php

	//création des chemins relatifs aux fichiers concernés.
	$fichierConfig = '../config/'.$_GET['nom'].'_config.php';
	$fichierTraitement = './traitement_formulaire_'.$_GET['nom'].'.php';
	$fichierFormulaire = '../vue/formulaire_'.$_GET['nom'].'.php';
	$class = '../modele/'.$_GET['nom'].'.class.php';
	
	//inclusion de librairie
	include ('../config/bdd_config.php');
	include('../modele/bdd.class.php');
	copy($fichierConfig, "../config/auto_completion_config.php");
	include ("../config/auto_completion_config.php");
	include(''.$class.'');
	//include './regexp.php';
	
	
	//Création du formulaire
	include ''.$fichierTraitement.'';
	include '../controleur/creer_liste_deroulante_formulaire.php';
	include '../vue/formulaire_auto_completion.php';
	include ''.$fichierFormulaire.'';

?>