<?php 
	include '../config/equipe_annee_config.php';
	include_once '../config/bdd_config.php';
	include_once '../modele/bdd.class.php';
	include '../modele/equipe_annee.class.php';
	include_once '../modele/transaction.class.php';
	include './creer_liste_deroulante_formulaire.php';
	
	//traitement formulaire
	function inserer_transaction($p_requete,$p_valeur)
	{
		$transaction = new transaction($p_requete, $p_valeur);
		$transaction->ecrire_transaction();
	}
	
	include '../vue/formulaire_equipe_annee.php';
	
?>