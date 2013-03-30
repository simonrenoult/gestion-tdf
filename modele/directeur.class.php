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
	 	$requete_preparee = $pdo->prepare('INSERT INTO tdf_directeur (n_directeur, nom, prenom) 
	 										VALUES (:num, \':nom\', \':prenom\')');
	 
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

		$requete_preparee->execute(array(
		'num'		=> $this->n_directeur,
		'nom' 		=> $this->nom,
		'prenom' 	=> $this->prenom				
		));
	
	}
		
	public function display() {
		echo '
				n_directeur : '.$this->n_directeur.'<br />
				nom : '.$this->nom.'<br />
				prenom : '.$this->prenom.'<br />
			';
	}
	
	public function calculer_ndirecteur($bdd){
		$req = $bdd->query("select max(n_directeur)as idCalcul from tdf_directeur");
	
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
	//---------------REGEXP----------------//
	//-------------------------------------//

	public static function c_n_directeur($subject) {
		return preg_match("/^[0-9]{1,3}+$/", $subject);
	}
	
	public static function c_nom($subject) {
		return preg_match("/^[A-Z]{1}[A-Z\'\ \-]{0,19}+$/", $subject);
	}
	
	public static function c_prenom($subject) {
		return preg_match("/^[A-Z]{1}[a-z\-\ \à\â\ç\è\é\ê\î\ô\ù\û\ä\ë\ï\ö\ü]{1,19}+$/", $subject);
	}
	
	public static function d_traitement_regex_nom($chaine){
		//on enleve les espaces gauche et droite
		trim($chaine);
	
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
	
	public static function d_traitement_regex_prenom($chaine){
	
		//on enleve les espaces gauche et droite
		trim($chaine);
	
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
		$chaine = directeur:: ucwords_custom2($chaine,"-");
		$chaine = directeur:: ucwords_custom2($chaine," ");
	
		//On prend par défault une chaine de 20 lettres
		$chaine = substr($chaine,0,20);
	
		return $chaine;
	}
}

?>