<?php

class pays {

	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $code_tdf;
	private $c_pays;
	private $nom;
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __construct ($p_code_tdf=null,$p_c_pays=null,$p_nom=null) {
	 	$this->code_tdf	= $p_code_tdf;
	 	$this->c_pays	=$p_c_pays;
		$this->nom 		= $p_nom;
	}
	 
	 //-------------------------------------//
	 //--------------GETTERS----------------//
	 //-------------------------------------//

	public  function get_code_tdf(){
		 return $this->code_tdf;
	}
	 
	public  function get_c_pays(){
		return $this->c_pays;
	}
	
	public function get_nom() {
		return $this->nom;
	}
	
    //-------------------------------------//
    //--------------SETTERS----------------//
	//-------------------------------------//
	 
	 public  function set_code_tdf($p_code_tdf){
	 	$this->code_tdf = $p_code_tdf;
	 }
	 
	 public function set_c_pays($p_c_pays) {
	 	$this->c_pays = $p_c_pays;
	 }
	 
	 public  function set_nom($p_nom){
	 	$this->nom = $p_nom;
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
	 	 				INSERT INTO tdf_pays (code_tdf, c_pays, nom)
	 	 				VALUES (:code, :pays, :nom)
	 	 			');
	 
	 	return $requete_preparee;
	 }
	 
	//READ
	public function read($pdo,$p_n_coureur) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_n_coureur);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row) {
			$this->	c_pays	    = $row['C_PAYS'];
			$this->	code_tdf	= $row['CODE_TDF'];
			$this->	nom			= $row['NOM'];
		}
	}
	 
	private function preparer_requete_read($pdo,$p_code_tdf) {	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_pays
		 	 				WHERE code_tdf = \''.$p_code_tdf.'\'	 	 				
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
	 	 				UPDATE tdf_pays
	 	 				SET code_tdf = :code, c_pays= :pays, nom = :nom
	 	 				WHERE code_tdf = \''.$this->code_tdf.'\'	 	 				
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
		 	 				DELETE FROM tdf_pays
		 	 				WHERE code_tdf = \''.$this->code_tdf.'\' 	 				
		 	 			');
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {
		$requete_preparee->execute(array(
		'code'	=> $this->code_tdf,
		'pays' 	=> $this->c_pays,
		'nom' 	=> $this->nom	 				
		));
	}
		
	public function display() {
		echo	'
				code_tdf : ' .$this->code_tdf.'<br />
				c_pays : '   .$this->c_pays.'<br />
				nom : '      .$this->nom.'<br />
				';
	}
	 
}

?>