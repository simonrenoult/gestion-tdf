<?php

class sponsor {
	//-------------------------------------//
	//--------------ATTRIBUTS--------------//
	//-------------------------------------//
	
	private $n_equipe;
	private $n_sponsor;
	private $nom;
	private $na_sponsor;
	private $code_tdf;	
	private $annee_sponsor;
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_n_equipe=null,$p_n_sponsor= null,
	$p_nom = null, $p_na_sponsor=null, $p_code_tdf=null, $p_annee_sponsor=null) {
			
		$this->n_equipe			= $p_n_equipe;
		$this->n_sponsor 		= $p_n_sponsor;
		$this->nom 				= $p_nom;
		$this->na_sponsor 		= $p_na_sponsor;
		$this->code_tdf			= $p_code_tdf;
		$this->annee_sponsor	= $p_annee_sponsor;
		
	}
	
	//-------------------------------------//
	//--------------GETTERS----------------//
	//-------------------------------------//
	
	public  function get_n_equipe(){
		return $this->n_equipe;
	}
	
	public  function get_n_sponsor(){
		return $this->n_sponsor;
	}
	
	public  function get_nom(){
		return $this->nom;
	}
	
	public  function get_na_sponsor(){
		return $this->na_sponsor;
	}
	
	public  function get_code_tdf(){
		return $this->code_tdf;
	}
	
	public function  get_annee_sponsor() {
		return $this->annee_sponsor;
	}
	
	//-------------------------------------//
	//--------------SETTERS----------------//
	//-------------------------------------//
	
	public  function set_n_equipe($p_n_equipe){
		$this->n_equipe = $p_n_equipe;
	}
	
	public  function set_n_sponsor($p_n_sponsor){
		$this->n_sponsor = $p_n_sponsor;
	}
	
	public  function set_nom($p_nom){
		$this->nom = $p_nom;
	}
	
	public  function set_na_sponsor($p_na_sponsor){
		$this->na_sponsor = $p_na_sponsor;
	}
	
	public  function set_code_tdf($p_code_tdf){
		$this->code_tdf = $p_code_tdf;
	}
	
	public  function set_annee_sponsor($p_annee_sponsor){
		$this->annee_sponsor = $p_annee_sponsor;
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
		 	 				INSERT INTO tdf_sponsor (n_equipe, n_sponsor, nom,
		 	 				na_sponsor, code_tdf, annee_sponsor)
		 	 				VALUES (:equipe, :sponsor, :nom, :na_sponsor, :code,
		 	 				:annee)
		 	 			');
	
		return $requete_preparee;
	}
	
	//READ
	public function read($pdo,$p_n_equipe) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_n_equipe);
		$res = $pdo->query($requete_preparee);
			
		foreach($res as $row) {
			$this->	n_equipe		= $row['N_EQUIPE'];
			$this->	n_sponsor		= $row['N_SPONSOR'];
			$this->	nom				= $row['NOM'];
			$this->	na_sponsor		= $row['NA_SPONSOR'];
			$this->	code_tdf		= $row['CODE_TDF'];
			$this->	annee_sponsor	= $row['ANNE_SPONSOR'];
				
		}
	}
	
	private function preparer_requete_read($pdo,$p_n_sponsor) {
		$requete_preparee = '
			 	 				SELECT * FROM tdf_sponsor
			 	 				WHERE n_sponsor = '.$p_n_sponsor.'	 	 				
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
		 	 				UPDATE tdf_sponsor
		 	 				SET n_equipe = :equipe, n_sponsor = :sponsor, 
		 	 				nom = :nom, na_sponsor = :na_sponsor, 
		 	 				code_tdf = :code, annee_sponsor = :annee
		 	 				WHERE n_sponsor = '.$this->n_sponsor.'	 	 				
		 	 				AND  n_equipe ='.$this->n_equipe);
		return $requete_preparee;
	}
	
	//DELETE
	public function delete($pdo) {
		$requete_preparee = $this->preparer_requete_delete($pdo);
		$requete_preparee->execute();
	}
	
	private function preparer_requete_delete($pdo) {
	
		$requete_preparee = $pdo->prepare('
			 	 				DELETE FROM tdf_sponsor
			 	 				WHERE n_sponsor = '.$this->n_sponsor.'	 	 				
			 	 				AND  n_equipe ='.$this->n_equipe);
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {
	
		$requete_preparee->execute(array(
			'equipe'		=> $this->n_equipe,
			'sponsor' 		=> $this->n_sponsor,
			'nom' 			=> $this->nom,
			'na_sponsor' 	=> $this->na_sponsor,
			'code' 			=> $this->code_tdf,
			'annee' 		=> $this->annee_sponsor,
		));
	}
	
	public function display() {
		echo '
					n_equipe : '.$this->n_equipe.'<br />
					n_sponsor : '.$this->n_sponsor.'<br />
					nom : '.$this->nom.'<br />	
					na_sponsor : '.$this->na_sponsor.'<br />	
					code_tdf : '.$this->code_tdf.'<br />	
					annee_sponsor : '.$this->annee_sponsor.'<br />	
		';
	}
	
	private function preparerRequeteSponsorEquipe($pdo,$p_n_sponsor,$p_n_equipe){
		$requete_preparee = '
					 	 				SELECT * FROM tdf_sponsor
					 	 				WHERE n_sponsor = '.$p_n_sponsor.'	 	 				
					 	 				AND n_equipe = '.$p_n_equipe.'';
		return $requete_preparee;
	}
	
	public function readSponsorEquipe($pdo,$p_n_sponsor,$p_n_equipe){
		$requete_preparee = $this->preparerRequeteSponsorEquipe($pdo,$p_n_sponsor,$p_n_equipe);
		$res = $pdo->query($requete_preparee);
			
		foreach($res as $row) {
			$this->	n_equipe		= $row['N_EQUIPE'];
			$this->	n_sponsor		= $row['N_SPONSOR'];
			$this->	nom				= $row['NOM'];
			$this->	na_sponsor		= $row['NA_SPONSOR'];
			$this->	code_tdf		= $row['CODE_TDF'];
			$this->	annee_sponsor	= $row['ANNEE_SPONSOR'];
		
		}
	}
		
	public function calculer_nsponsor($bdd,$n_equipe){
		echo $n_equipe;
		$req = $bdd->query("select max(n_sponsor)as idCalcul from tdf_sponsor where n_equipe = ".$n_equipe);
	
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
	
	public static function c_n_sponsor($subject) {
		return preg_match("/^[0-9]{2}+$/", $subject);
	}
	
	public static function c_nom($chaine) {
		
		$maj_accents = strtoupper('\á\é\í\ó\ú\ý\à\è\ì\ò\ù\ä\ë\ï\ö\ü\ÿ\â\ê\î\ô\û\å\ç\ã\ñ\õ');
		
		return preg_match('/^[A-Z]{1}[A-Z0-9'.$maj_accents.'\'\ \-]{1,19}+$/', $chaine);
	}
	
	public static function contr_na_sponsor($subject) {
		return preg_match("/^[A-Z0-9]{3}+$/", $subject);
	}
	
	public static function contr_annee_sponsor($subject) {
		return preg_match("/^[0-9]{4}+$/", $subject);
	}
	
	public static function c_pays($subject) {
		return preg_match("/^[A-Z]{2}+$/", $chaine);
	}
	
	public static function e_traitement_regex_nom_sponsor($chaine){
		
		
		//on enleve les espaces gauche et droite
		trim($chaine);
		
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		$chaine = preg_replace('/[^A-Za-z0-9\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\Ý\'\.\,\ \-\&]{0,19}/', '', $chaine);
		
		//On enleve les tirets, apostrophes, espaces, points, virgules et & au minimum en double.
		$chaine = preg_replace('/[\s]{1,}/', ' ', $chaine);// On enlève ou pas  ???
		$chaine = preg_replace('/[\-]{1,}/', '-', $chaine);
		$chaine = preg_replace('/[\']{1,}/', '\'', $chaine);
		$chaine = preg_replace('/[\.]{1,}/', '.', $chaine);
		$chaine = preg_replace('/[\&]{1,}/', '&', $chaine);
		$chaine = preg_replace('/[\,]{1,}/', ',', $chaine);
		
		//On enleve les cas particuliers.
		$chaine = preg_replace('/[\s]+[\']{1,}/', '', $chaine);
		$chaine = preg_replace('/[\s]+[\-]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\s]+[\.]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\s]+[\,]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\s]+[\&]{1,}/', '', $chaine);
		
		$chaine = preg_replace('/[\-]+[\']{1,}/', '', $chaine);
		$chaine = preg_replace('/[\-]+[\s]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\-]+[\.]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\-]+[\,]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\-]+[\&]{1,}/', '', $chaine);
		
		$chaine = preg_replace('/[\']+[\s]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\']+[\-]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\']+[\.]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\']+[\,]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\']+[\&]{1,}/', '', $chaine);
		
		$chaine = preg_replace('/[\.]+[\']{1,}/', '', $chaine);
		$chaine = preg_replace('/[\.]+[\-]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\.]+[\s]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\.]+[\,]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\.]+[\&]{1,}/', '', $chaine);
		
		$chaine = preg_replace('/[\&]+[\']{1,}/', '', $chaine);
		$chaine = preg_replace('/[\&]+[\-]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\&]+[\.]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\&]+[\,]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\&]+[\s]{1,}/', '', $chaine);
		
		$chaine = preg_replace('/[\,]+[\']{1,}/', '', $chaine);
		$chaine = preg_replace('/[\,]+[\-]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\,]+[\.]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\,]+[\s]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\,]+[\&]{1,}/', '', $chaine);
		
		//On enleve les tirets, apostrophes, espaces, points, virgules et & en début et fin.
		
		$chaine = preg_replace('/^[\']/', '', $chaine);
		$chaine = preg_replace('/^[\-]/', '', $chaine);
		$chaine = preg_replace('/[\']$/', '', $chaine);
		$chaine = preg_replace('/[\-]$/', '', $chaine);
		$chaine = preg_replace('/^[\.]/', '', $chaine);
		$chaine = preg_replace('/^[\,]/', '', $chaine);
		$chaine = preg_replace('/[\.]$/', '', $chaine);
		$chaine = preg_replace('/[\,]$/', '', $chaine);
		$chaine = preg_replace('/^[\&]/', '', $chaine);
		$chaine = preg_replace('/[\&]$/', '', $chaine);
		
		
		//On modifie les majuscules avec acvents en majuscules sans accents.
		$accentsMin = "àáâãäåòóôõöøèéêëçìíîïùúûüÿñ";
		$accentsMaj = "ÀÁÂÃÄÅÒÓÔÕÖØÈÉÊËÇÌÍÎÏÙÚÛÜYÑ";
		$chaine = strtr($chaine,$accentsMin,$accentsMaj);
		
		//On met tout en majuscule :
		$chaine = strtoupper($chaine);
		
		//On prend par défault une chaine de 30 lettres
		$chaine = substr($chaine,0,40);
		
		
		return $chaine;
	}
	
	public static function e_traitement_regex_nomabr_sponsor($chaine){
		
		//on enleve les espaces gauche et droite
		trim($chaine);
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		$chaine = preg_replace('/[^A-Za-z\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\Ý]/', '', $chaine);
		
		//On modifie les majuscules et minuscules avec accents en majuscules et minuscules sans accents.
		$accents = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
		$ssaccents = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
		$chaine = strtr($chaine,$accents,$ssaccents);
		
		//On met tout en majuscule :
		$chaine = strtoupper($chaine);
		
		//On prend par défault une chaine de 3 lettres
		$chaine = substr($chaine,0,3);
		
		return $chaine;
	}
	
	
}
?>