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

		return $requete_preparee;
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
		
		return $requete_preparee;
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
	 	
	 	return $requete_preparee;
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
		
		return $requete_preparee;
	}
	
	private function preparer_requete_delete($pdo) {
	
		$requete_preparee = $pdo->prepare('
		 	 				DELETE FROM tdf_coureur
		 	 				WHERE n_coureur = '.$this->n_coureur.'	 	 				
		 	 			');
		
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {
		
		$requete_preparee->execute(array(
		'num'		=> $this->n_coureur,
		'nom' 		=> $this->nom,
		'prenom' 	=> $this->prenom,
		'naiss'		=> $this->annee_naissance,
		'code'		=> $this->code_tdf,
		'annee_tdf'	=> $this->annee_tdf	 				
		));

	}
	
	//AUTRES
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
	
	public function calculer_ncoureur($bdd){
		$req = $bdd->query("select max(n_coureur)as idCalcul from tdf_coureur");
		
		while ($donnee = $req->fetch()){
			$max = $donnee['IDCALCUL'];
		}
		
		return $max + 5;
	}
	
	public function display_requete_insert(){
		return 'INSERT INTO tdf_coureur (n_coureur, nom, prenom, annee_naissance, code_tdf, annee_tdf)
			VALUES ('.
		$this->n_coureur.','.
		$this->nom.','.
		$this->prenom.','.
		$this->annee_naissance.','.
		$this->code_tdf.','.
		$this->annee_tdf.')';
	
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

	public static function c_nom($chaine) {
		return preg_match("/^[A-Z]{1}[A-Z\'\ \-]{0,19}+$/", $chaine);
	}
	
	public static function c_prenom($chaine) {
		return preg_match("/^[A-Z]{1}[a-z\-\ \à\â\ç\è\é\ê\î\ô\ù\û\ä\ë\ï\ö\ü]{1,19}+$/", $chaine);
	}	

	public static function c_annee_naissance($subject) {
		return preg_match("/^[0-9]{4}+$/", $subject);
	}
	
	public static function c_code_tdf($subject) {
		return preg_match("/^[A-Z]{3}+$/", $subject);
	}
	
	public static function c_annee_tdf($subject) {
		return preg_match("/^[0-9]{4}+$/", $subject);
	}
	
	
	
	public static function c_traitement_regex_nom($chaine){
		//on enleve les espaces gauche et droite
		$chaine =  trim($chaine);
	
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		$chaine = preg_replace('/[^A-Za-z\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\İ\'\ \-]{0,19}/', '', $chaine);
	
		//On enleve les tirets, apostrophes et espace au minimum en double.
		$chaine = preg_replace('/[\s]{1,}/', ' ', $chaine);// On enlève ou pas  ???
		$chaine = preg_replace('/[\-]{1,}/', '-', $chaine);
		$chaine = preg_replace('/[\']{1,}/', '\'', $chaine);
	
		//On enleve les cas particuliers.
		$chaine = preg_replace('/[\s]+[\']{1,}/', '', $chaine);
		$chaine = preg_replace('/[\']+[\s]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\-]+[\']{1,}/', '', $chaine);
		$chaine = preg_replace('/[\']+[\-]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\-]+[\s]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\s]+[\-]{1,}/', '', $chaine);
	
		//On enleve les tirets, apostrophes en début et fin.
		$chaine = preg_replace('/^[\']/', '', $chaine);
		$chaine = preg_replace('/^[\-]/', '', $chaine);
		$chaine = preg_replace('/[\']$/', '', $chaine);
		$chaine = preg_replace('/[\-]$/', '', $chaine);
	
		//On modifie les majuscules avec acvents en majuscules sans accents.
		$accents = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
		$ssaccents = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
		$chaine = strtr($chaine,$accents,$ssaccents);
	
		//On met tout en majuscule :
		$chaine = strtoupper($chaine);
	
		//On prend par défault une chaine de 20 lettres
		$chaine = substr($chaine,0,20);
	
		return $chaine;
	}
	
	public static function ucwords_custom2($str, $sep){
		$accentsMaj = "àáâãäåòóôõöèéêëçìíîïùúûüñÀÁÂÃÄÅÒÓÔÕÖÈÉÊËÇÌÍÎÏÙÚÛÜÑ";
		$ssaccentsMaj = "AAAAAA00000EEEECIIIIUUUUNAAAAAA00000EEEECIIIIUUUUN";
		$prenom = explode($sep, $str);
		for ($i = 0; $i<count($prenom); $i++){
			$lettre = substr($prenom[$i], 0 , 1);
			$nouveauPrenom = substr($prenom[$i], 1 , strlen($prenom[$i]));
			$lettre = strtr($lettre,$accentsMaj,$ssaccentsMaj);
			$prenom[$i] = $lettre.$nouveauPrenom;
		}
	
		return implode($sep, array_map('ucfirst',$prenom));
	}
	
	public static function c_traitement_regex_prenom($chaine){
	
		//on enleve les espaces gauche et droite
		$chaine = trim($chaine);
	
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		$chaine = preg_replace('/[^A-Za-z\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\İ\ \-]{1,19}/', '', $chaine);
	
		//On enleve les tirets, apostrophes et espace au minimum en double.
		$chaine = preg_replace('/[\s]{1,}/', ' ', $chaine);// On enlève ou pas  ???
		$chaine = preg_replace('/[\-]{1,}/', '-', $chaine);
	
		//On enleve les cas particuliers.
		$chaine = preg_replace('/[\-]+[\s]{1,}/', '', $chaine);
		$chaine = preg_replace('/[\s]+[\-]{1,}/', '', $chaine);
	
		//On enleve les tirets en début et fin de chaine.
		$chaine = preg_replace('/^[\-]/', '', $chaine);
		$chaine = preg_replace('/[\-]$/', '', $chaine);
	
		//On modifie les majuscules avec accents en minuscules avec accents.
		$accentsMaj = "ÀÁÂÃÄÅÒÓÔÕÖØÈÉÊËÇÌÍÎÏÙÚÛÜÑ";
		$ssaccentsMin = "àáâãäåòóôõöøèéêëçìíîïùúûüñ";
		$chaine = strtr($chaine,$accentsMaj,$ssaccentsMin);
	
	
	
		//On met tout en minucule sauf les premières lettres de chaque prénom
		$chaine = strtolower($chaine);
		$chaine = coureur:: ucwords_custom2($chaine,"-");
		$chaine = coureur:: ucwords_custom2($chaine," ");
	
		//On prend par défault une chaine de 20 lettres
		$chaine = substr($chaine,0,20);
	
		return $chaine;
	}
	
	
	 
}

?>