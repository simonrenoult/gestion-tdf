<?php

class equipe {

	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $n_equipe;
	private $annee_creation;
	private $annee_disparition;
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_n_equipe=null,$p_annee_creation= null,
		$p_annee_disparition = null) {
			 	
		$this->n_equipe				= $p_n_equipe;
	 	$this->annee_creation 		= $p_annee_creation;
	 	$this->annee_disparition 	= $p_annee_disparition;
	 }
	 
	 //-------------------------------------//
	 //--------------GETTERS----------------//
	 //-------------------------------------//

	 public  function get_n_equipe(){
		 return $this->n_equipe;
	 }
	 
	 public  function get_annee_creation(){
	 	return $this->annee_creation;
	 }
	 
	 public  function get_annee_disparition(){
		 return $this->annee_disparition;
	 }

	 //-------------------------------------//
	 //--------------SETTERS----------------//
	 //-------------------------------------//
	 
	 public  function set_n_equipe($p_n_equipe){
	 	$this->n_equipe = $p_n_equipe;
	 }
	 
	 public  function set_annee_creation($p_annee_creation){
	 	$this->annee_creation = $p_annee_creation;
	 }
	 
	 public  function set_annee_disparition($p_annee_disparition){
	 	$this->annee_disparition = $p_annee_disparition;
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
	 	 				INSERT INTO tdf_equipe (n_equipe, annee_creation, annee_disparition)
	 	 				VALUES (:equipe, :crea, :dispa)
	 	 			');
	 
	 	return $requete_preparee;
	 }
	 
	//READ
	public function read($pdo,$p_n_equipe) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_n_equipe);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row) {
			$this->	n_equipe			= $row['N_EQUIPE'];
			$this->	annee_creation		= $row['ANNEE_CREATION'];
			$this->	annee_disparitionee	= $row['ANNEE_DISPARITION'];
		}
	}
	 
	private function preparer_requete_read($pdo,$p_n_equipe) {	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_equipe
		 	 				WHERE n_equipe = '.$p_n_equipe.'	 	 				
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
	 	 				UPDATE tdf_equipe
	 	 				SET n_equipe = :equipe, annee_creation = :crea, annee_disparition = :dispa
	 	 				WHERE n_equipe = '.$this->n_equipe.'	 	 				
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
		 	 				DELETE FROM tdf_equipe
		 	 				WHERE n_equipe = '.$this->n_equipe.'	 	 				
		 	 			');
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {
		
		$requete_preparee->execute(array(
		'equipe'	=> $this->n_equipe,
		'crea' 		=> $this->annee_creation,
		'dispa' 	=> $this->annee_disparition	 				
		));
	}
		
	private function display() {
		echo '
				n_equipe : '.$this->n_equipe.'<br />
				annee_creation : '.$this->annee_creation.'<br />
				annee_disparition : '.$this->annee_disparition.'<br />	
			';
	}
	 
	public function calculer_nequipe($bdd){
		$req = $bdd->query("select max(n_equipe)as idCalcul from tdf_equipe");
	
		while ($donnee = $req->fetch()){
			$max = $donnee['IDCALCUL'];
		}
	
		return $max+1;
	}
	
	public function get_attr()
	{
		return get_object_vars($this);
	}

	//-------------------------------------//
	//----------------REGEXP---------------//
	//-------------------------------------//
	
	public static function c_n_equipe($subject) {
		return preg_match("/^[0-9]{3}+$/", $subject);
	}
	
	public static function c_annee_creation($subject) {
		return preg_match("/^[0-9]{4}+$/", $subject);
	}
	
	public static function c_annee_disparition($subject) {
		return preg_match("/^[0-9]{4}+$/", $subject);
	}
}

?>