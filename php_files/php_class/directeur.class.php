<?php

class directeur {

	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $n_directeur;
	private $nom;
	private $prenom;
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_n_directeur=null,$p_nom=null,$p_prenom=null){
	 	$this->n_directeur	= $p_n_directeur;
	 	$this->nom 			= $p_nom;
	 	$this->prenom 		= $p_prenom;
	 }
	 
	 //-------------------------------------//
	 //--------------GETTERS----------------//
	 //-------------------------------------//

	 public  function get_n_directeur(){
	 	return $this->n_directeur;
	 }
	 
	 public  function get_nom(){
		 return $this->nom;
	 }
	 
	 public  function get_prenom(){
	 	return $this->prenom;
	 }
	 
	 //-------------------------------------//
	 //--------------SETTERS----------------//
	 //-------------------------------------//
	 
	 public  function set_n_directeur($p_n_directeur){
	 	$this->n_directeur = $p_n_directeur;
	 }
	 
	 public  function set_nom($p_nom){
	 	$this->nom = $p_nom;
	 }
	 
	 public  function set_prenom($p_prenom){
	 	$this->prenom = $p_prenom;
	 }
	 
	//-------------------------------------//
	//--------------METHODES---------------//
	//-------------------------------------//
	
	//CREATE
	public function create($pdo) {	 
	 	$requete_preparee = $this->preparer_requete_create($pdo);
	 	$this->executer_requete($requete_preparee);
	 }	 

	 private function preparer_requete_create($pdo) {
	 	$requete_preparee = $pdo->prepare('
	 	 				INSERT INTO tdf_directeur (n_directeur, nom, prenom)
	 	 				VALUES (:num, :nom, :prenom);
	 	 			');
	 
	 	return $requete_preparee;
	 }
	 
	//READ
	public function read($pdo,$p_n_directeur) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_n_directeur);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row) {
			$this->	n_directeur		= $row['N_DIRECTEUR'];
			$this->	nom				= $row['NOM'];
			$this->	prenom			= $row['PRENOM'];
		}
	}
	 
	private function preparer_requete_read($pdo,$p_n_directeur) {	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_directeur
		 	 				WHERE n_directeur = '.$p_n_directeur.'	 	 				
		 	 				';
		return $requete_preparee;
	}
	
	//UPDATE
	public function update($pdo) {
	 	$requete_preparee = $this->preparer_requete_update($pdo);
	 	$this->executer_requete($requete_preparee);
	}
	 
	private function preparer_requete_update($pdo) {
		
	 	$requete_preparee = $pdo->prepare('
	 	 				UPDATE tdf_directeur
	 	 				SET n_coureur = :num, nom = :nom, prenom = :prenom
	 	 				WHERE n_directeur = '.$this->n_directeur.'	 	 				
	 	 			');
	 	return $requete_preparee;
	}
	
	//DELETE
	public function delete($pdo) {		
		$requete_preparee = $this->preparer_requete_delete($pdo);
		$requete_preparee->execute();
	}
	
	private function preparer_requete_delete($pdo) {
	
		$requete_preparee = $pdo->prepare('
		 	 				DELETE FROM tdf_directeur
		 	 				WHERE n_directeur = '.$this->n_directeur.'	 	 				
		 	 			');
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {

		//FIXME remove
		$this->display();
		
		$requete_preparee->execute(array(
		'num'		=> $this->n_directeur,
		'nom' 		=> $this->nom,
		'prenom' 	=> $this->prenom, 				
		));
	}
		
	public function display() {
		echo '
				n_directeur : '.$this->n_directeur.'<br />
				nom : '.$this->nom.'<br />
				prenom : '.$this->prenom.'<br />
			';
	}
	 
}

?>