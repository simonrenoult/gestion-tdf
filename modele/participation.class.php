<?php

class participation {

	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $n_coureur;
	private $n_equipe;
	private $n_sponsor;
	private	$annee;
	private $n_dossard;
	private	$jeune;
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_n_coureur=null,$p_n_equipe=null,$p_n_sponsor=null,
	$p_annee=null,$p_n_dossard=null,$p_jeune=null){
	 	$this->n_coureur	= $p_n_coureur;
	 	$this->n_equipe 	= $p_n_equipe;
	 	$this->n_sponsor 	= $p_n_sponsor;
	 	$this->annee	 	= $p_annee;
	 	$this->n_dossard 	= $p_n_dossard;
	 	$this->jeune 		= $p_jeune;
	 }
	 
	 //-------------------------------------//
	 //--------------GETTERS----------------//
	 //-------------------------------------//

	 public  function get_n_coureur(){
	 return $this->n_coureur;
	 }
	 
	 public  function get_n_equipe(){
	 return $this->n_equipe;
	 }
	 
	 public  function get_n_sponsor(){
	 return $this->n_sponsor;
	 }
	 
	 public  function get_annee(){
	 	return $this->annee;
	 }
	 
	 public  function get_n_dossard(){
	 return $this->n_dossard;
	 }
	 
	 public  function get_jeune(){
	 return $this->jeune;
	 }
	 
	 //-------------------------------------//
	 //--------------SETTERS----------------//
	 //-------------------------------------//
	 
	 public  function set_n_coureur($p_n_coureur){
	 	$this->n_coureur = $p_n_coureur;
	 }
	 
	 public  function set_n_equipe($p_n_equipe){
	 	$this->n_equipe = $p_n_equipe;
	 }
	 
	 public  function set_n_sponsor($p_n_sponsor){
	 	$this->n_sponsor = $p_n_sponsor;
	 }
	 
	 public  function set_annee($p_annee){
	 	$this->annee = $p_annee;
	 }
	 
	 public  function set_n_dossard($p_n_dossard){
	 	$this->n_dossard = $p_n_dossard;
	 }
	 
	 public  function set_jeune($p_jeune){
	 	$this->jeune = $p_n_dossard;
	 }
	 
	//-------------------------------------//
	//--------------METHODES---------------//
	//-------------------------------------//
	
	//CREATE
	public function create($pdo) {	 
	 	$requete_preparee = $this->preparer_requete_create($pdo);
	 	 echo $this->executer_requete($requete_preparee);
		
		return $requete_preparee;
	}	 

	 private function preparer_requete_create($pdo) {
	 	$requete_preparee = $pdo->prepare('
	 	 				INSERT INTO tdf_participation (n_coureur, n_equipe, n_sponsor,annee, n_dossard,jeune)
	 	 				VALUES (:ncoureur, :nequipe, :nsponsor,:annee,  :ndossard, \':jeune\')
	 	 			');
	 
	 	return $requete_preparee;
	 }
	 
	//READ
	public function read($pdo,$p_annee,$p_n_coureur,$p_n_equipe,$p_n_sponsor) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_annee,$p_n_coureur,$p_n_equipe,$p_n_sponsor);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row) {
			$this->n_coureur	= $row['N_COUREUR'];
			$this->n_equipe 	= $row['N_EQUIPE'];
			$this->n_sponsor 	= $row['N_SPONSOR'];
			$this->annee	 	= $row['ANNEE'];
			$this->n_dossard 	= $row['N_DOSSARD'];;
			$this->jeune		= $row['JEUNE'];
			
		}
		
		return $requete_preparee;
	}
	 
	private function preparer_requete_read($pdo,$p_annee,$p_n_coureur,$p_n_equipe,$p_n_sponsor) {	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_participation
		 	 				WHERE n_coureur = '.$p_n_coureur.'	 	 				
		 	 				AND annee = '.$p_annee.'
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
	 	 				UPDATE tdf_participation
	 	 				SET annee = :annee, n_coureur = :num, n_equipe = :nequipe, n_sponsor = :nsponsor, n_dossard = :ndossard, jeune = :jeune
	 	 				WHERE n_coureur = '.$this->n_coureur.'
	 	 				AND annee = '.$this->annee.'
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
		 	 				DELETE FROM tdf_coureur
		 	 				WHERE n_coureur = '.$this->n_coureur.'
	 	 					AND annee = '.$this->annee.'
	 	 					AND n_equipe = '.$this->n_equipe.'	 
	 	 					AND n_sponsor = '.$this->n_sponsor.'				
	 	 				');
		
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {
		
		
		$requete_preparee->execute(array(
		
		'num'			=> $this->n_coureur,
		'nequipe' 		=> $this->n_equipe,
		'nsponsor' 		=> $this->n_sponsor,
		'annee'			 => $this->annee,
		'ndossard'		=> $this->n_dossard,
		'jeune'			=> $this->jeune	
		));

	}
	
	//AUTRES
	public function display() {
		 
		echo '
				n_coureur : '.$this->n_coureur.'<br />
				n_equipe : '.$this->n_equipe.'<br />
				n_sponsor : '.$this->n_sponsor.'<br />
				annee : '.$this->annee.'<br />
				n_dossard : '.$this->n_dossard.'<br />
				jeune : '.$this->jeune.'<br />
			';
	}
	
	public function get_attr()
	{
		return get_object_vars($this);
	}
	//-------------------------------------//
	//---------------REGEXP----------------//
	//-------------------------------------//
	
	public static function c_n_coureur($subject) {
		return preg_match("/^[0-9]{1,4}+$/", $subject);
	}
	
	public static function p_n_equipe($subject) {
		return preg_match("/^[0-9]{3}+$/", $subject);
	}
	
	public static function p_n_sponsor($subject) {
		return preg_match("/^[0-9]{2}+$/", $subject);
	}
	
	public static function p_annee($subject) {
		return preg_match("/^[0-9]{4}+$/", $subject);
	}
	
	public static function p_n_dossard($subject) {
		return preg_match("/^[0-9]{3}+$/", $subject);
	}
	
	public static function p_jeune($subject) {
		return preg_match("/^[o]+$/", $subject);
	}
	
}

?>