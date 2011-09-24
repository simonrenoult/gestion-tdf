<?php

class coureur {

	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $n_coureur;
	private $nom;
	private $prenom;
	private	$annee_naissance;
	private $code_tdf;
	private	$annee_tdf;
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_n_coureur=null,$p_nom=null,$p_prenom=null,
	$p_code_tdf=null,$p_annee_naissance=null,$p_annee_tdf=null){
	 	$this->n_coureur	= $p_n_coureur;
	 	$this->nom 			= $p_nom;
	 	$this->prenom 		= $p_prenom;
	 	$this->annee_naissance = $p_annee_naissance;
	 	$this->code_tdf 	= $p_code_tdf;
	 	$this->annee_tdf 	= $p_annee_tdf;
	 }
	 
	 //-------------------------------------//
	 //--------------GETTERS----------------//
	 //-------------------------------------//

	 public  function get_n_coureur(){
	 return $this->n_coureur;
	 }
	 
	 public  function get_nom(){
	 return $this->nom;
	 }
	 
	 public  function get_prenom(){
	 return $this->prenom;
	 }
	 
	 public  function get_annee_naissance(){
	 return $this->annee_naissance;
	 }
	 public  function get_code_tdf(){
	 return $this->code_tdf;
	 }
	 
	 public  function get_annee_tdf(){
	 return $this->annee_tdf;
	 }
	 
	 //-------------------------------------//
	 //--------------SETTERS----------------//
	 //-------------------------------------//
	 
	 public  function set_n_coureur($p_n_coureur){
	 	$this->n_coureur = $p_n_coureur;
	 }
	 
	 public  function set_nom($p_nom){
	 	$this->nom = $p_nom;
	 }
	 
	 public  function set_prenom($p_prenom){
	 	$this->prenom = $p_prenom;
	 }
	 
	 public  function set_annee_naissance($p_annee_naissance){
	 	$this->annee_naissance = $p_annee_naissance;
	 }
	 public  function set_code_tdf($p_code_tdf){
	 	$this->code_tdf = $p_code_tdf;
	 }
	 
	 public  function set_annee_tdf($p_annee_tdf){
	 	$this->annee_tdf = $p_annee_tdf;
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
	 	 				INSERT INTO tdf_coureur (n_coureur, nom, prenom, annee_naissance, code_tdf, annee_tdf)
	 	 				VALUES (:num, :nom, :prenom, :naiss, :code, :annee_tdf)
	 	 			');
	 
	 	return $requete_preparee;
	 }
	 
	//READ
	public function read($pdo,$p_n_coureur) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_n_coureur);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row) {
			$this->	n_coureur		= $row['N_COUREUR'];
			$this->	nom				= $row['NOM'];
			$this->	prenom			= $row['PRENOM'];
			$this->	annee_naissance = $row['ANNEE_NAISSANCE'];
			$this->	code_tdf		= $row['CODE_TDF'];
			$this->	annee_tdf		= $row['ANNEE_TDF'];
		}
	}
	 
	private function preparer_requete_read($pdo,$p_n_coureur) {	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_coureur
		 	 				WHERE n_coureur = '.$p_n_coureur.'	 	 				
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
	 	 				UPDATE tdf_coureur
	 	 				SET n_coureur = :num, nom = :nom, prenom = :prenom, annee_naissance = :naiss, code_tdf = :code, annee_tdf = :annee_tdf
	 	 				WHERE n_coureur = '.$this->n_coureur.'	 	 				
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
		 	 				DELETE FROM tdf_coureur
		 	 				WHERE n_coureur = '.$this->n_coureur.'	 	 				
		 	 			');
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {

		//FIXME remove
		$this->display();
		
		$requete_preparee->execute(array(
		'num'		=> $this->n_coureur,
		'nom' 		=> $this->nom,
		'prenom' 	=> $this->prenom,
		'naiss'		=> $this->annee_naissance,
		'code'		=> $this->code_tdf,
		'annee_tdf'	=> $this->annee_tdf	 				
		));
	}
		
	public function display() {
		echo '
				n_coureur : '.$this->n_coureur.'<br />
				nom : '.$this->nom.'<br />
				prenom : '.$this->prenom.'<br />
				annee de naissance : '.$this->annee_naissance.'<br />
				code_tdf : '.$this->code_tdf.'<br />
				annee_tdf : '.$this->annee_tdf.'<br />	
			';
	}
	 
}

?>