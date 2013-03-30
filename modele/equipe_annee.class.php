<?php

class equipe_annee {

	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $annee;
	private $n_equipe;
	private $n_sponsor;
	private	$n_pre_directeur;
	private $n_co_directeur;
	
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_annee=null,$p_n_equipe=null,$p_n_sponsor=null,
	$p_n_co_directeur=null,$p_n_pre_directeur=null){
	 	$this->annee			= $p_annee;
	 	$this->n_equipe 		= $p_n_equipe;
	 	$this->n_sponsor 		= $p_n_sponsor;
	 	$this->n_pre_directeur 	= $p_n_pre_directeur;
	 	$this->n_co_directeur 	= $p_n_co_directeur;
	 	
	 }
	 
	 //-------------------------------------//
	 //--------------GETTERS----------------//
	 //-------------------------------------//

	 public  function get_annee(){
	 return $this->annee;
	 }
	 
	 public  function get_n_equipe(){
	 return $this->n_equipe;
	 }
	 
	 public  function get_n_sponsor(){
	 return $this->n_sponsor;
	 }
	 
	 public  function get_n_pre_directeur(){
	 	return $this->n_pre_directeur;
	 }
	 
	 public  function get_n_co_directeur(){
	 return $this->n_co_directeur;
	 }
	 
	 //-------------------------------------//
	 //--------------SETTERS----------------//
	 //-------------------------------------//
	 
	 public  function set_annee($p_annee){
	 	$this->annee = $p_annee;
	 }
	 
	 public  function set_n_equipe($p_n_equipe){
	 	$this->n_equipe = $p_n_equipe;
	 }
	 
	 public  function set_n_sponsor($p_n_sponsor){
	 	$this->n_sponsor = $p_n_sponsor;
	 }
	 
	 public  function set_n_pre_directeur($p_n_pre_directeur){
	 	$this->n_pre_directeur = $p_n_pre_directeur;
	 }
	 
	 public  function set_n_co_directeur($p_n_co_directeur){
	 	$this->n_co_directeur = $p_n_co_directeur;
	 }
	
	//-------------------------------------//
	//--------------METHODES---------------//
	//-------------------------------------//
	
	//CREATE
	public function create($pdo) {	 
	 	$requete_preparee = $this->preparer_requete_create($pdo);
	 	$this->executer_requete($requete_preparee);

		return $requete_preparee;
	}	 

	 private function preparer_requete_create($pdo) {
	 	$requete_preparee = $pdo->prepare('
	 	 				INSERT INTO tdf_equipe_annee (annee, n_equipe, n_sponsor, n_pre_directeur, n_co_directeur)
	 	 				VALUES (:annee, :n_equipe, :n_sponsor, :n_pre_directeur, :n_co_directeur)
	 	 			');
	 
	 	return $requete_preparee;
	 }
	 
	//READ
	public function read($pdo,$p_annee,$p_n_equipe,$p_n_sponsor) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_annee,$p_n_equipe,$p_n_sponsor);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row) {
			$this->	annee			= $row['ANNEE'];
			$this->	n_equipe		= $row['N_EQUIPE'];
			$this->	n_sponsor		= $row['N_SPONSOR'];
			$this->	n_pre_directeur = $row['N_PRE_DIRECTEUR'];
			$this->	n_co_directeur	= $row['N_CO_DIRECTEUR'];
			
		}
		
		return $requete_preparee;
	}
	 
	private function preparer_requete_read($pdo,$p_annee,$p_n_equipe,$p_n_sponsor) {	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_equipe_annee
		 	 				WHERE annee = '.$p_annee.'
		 	 				AND n_equipe = '.$p_n_equipe.'
		 	 				AND n_sponsor = '.$p_n_sponsor.'	 	 				
		 	 				';
		return $requete_preparee;
	}
	
	//UPDATE
	public function update($pdo) {
	 	$requete_preparee = $this->preparer_requete_update($pdo);
	 	$this->executer_requete($requete_preparee);
	 	
	 	return $requete_preparee;
	}
	 
	private function preparer_requete_update($pdo) {
		
	 	$requete_preparee = $pdo->prepare('
	 	 				UPDATE tdf_equipe_annee
	 	 				SET annee = :annee, n_equipe = :n_equipe, n_sponsor = :n_sponsor, n_pre_directeur = :n_pre_directeur, n_co_directeur = :n_co_directeur
	 	 				WHERE annee = '.$this->annee.'
		 	 			AND n_equipe = '.$this->n_equipe.'
		 	 			AND n_sponsor = '.$this->n_sponsor.'	 	 				
		 	 		');
	 	return $requete_preparee;
	}
	
	//DELETE
	public function delete($pdo) {		
		$requete_preparee = $this->preparer_requete_delete($pdo);
		$requete_preparee->execute();
		
		return $requete_preparee;
	}
	
	private function preparer_requete_delete($pdo) {
	
		$requete_preparee = $pdo->prepare('
		 	 				DELETE FROM tdf_equipe_annee
		 	 				WHERE annee = '.$this->annee.'
		 	 				AND n_equipe = '.$this->n_equipe.'
		 	 				AND n_sponsor = '.$this->n_sponsor.'	 	 				
		 	 			');
		
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {
		
		$requete_preparee->execute(array(
		'annee'				=> $this->annee,
		'n_equipe' 			=> $this->n_equipe,
		'n_sponsor' 		=> $this->n_sponsor,
		'n_pre_directeur'	=> $this->n_pre_directeur,
		'n_co_directeur'	=> $this->n_co_directeur,
					
		));

	}
	
	//AUTRES
	public function display() {
		echo '
				annee : '.$this->annee.'<br />
				n_equipe : '.$this->n_equipe.'<br />
				n_sponsor : '.$this->n_sponsor.'<br />
				n_pre_directeur : '.$this->n_pre_directeur.'<br />
				n_co_directeur : '.$this->n_co_directeur.'<br />
			';
	}
	
	public function get_attr()
	{
		return get_object_vars($this);
	}

	//-------------------------------------//
	//---------------REGEXP----------------//
	//-------------------------------------//
	
	public static function ea_n_equipe($subject) {
		return preg_match("/^[0-9]{3}+$/", $subject);
	}
	
	public static function ea_n_sponsor($subject) {
		return preg_match("/^[0-9]{2}+$/", $subject);
	}
	
	public static function ea_annee($subject) {
		return preg_match("/^[0-9]{4}+$/", $subject);
	}
	
	public static function ea_n_pre_directeur($subject) {
		return preg_match("/^[0-9]{3}+$/", $subject);
	}
	
	public static function ea_n_co_directeur($subject) {
		return preg_match("/^[0-9]{3}+$/", $subject);
	}
}

?>