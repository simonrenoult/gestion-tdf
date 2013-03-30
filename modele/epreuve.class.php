<?php

class epreuve {

	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $annee;
	private $n_epreuve;
	private $code_tdf_d;
	private $code_tdf_a;
	private $ville_d;
	private $ville_a;
	private $distance;
	private $moyenne;
	private $jour;
	private $cat_code;
	
	private $date_jour;
	private $date_mois;
	private $date_annee;
	
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_annee=null,$p_n_epreuve=null,$p_code_tdf_d=null,$p_code_tdf_a=null,
									$p_ville_d=null,$p_ville_a=null,$p_distance=null,$p_moyenne=null,$p_jour=null,
										$p_cat_code=null){
	 	$this->annee		= $p_annee;
	 	$this->n_epreuve 	= $p_n_epreuve;
	 	$this->code_tdf_d 	= $p_code_tdf_d;
	 	$this->code_tdf_a 	= $p_code_tdf_a;
	 	$this->ville_d 		= $p_ville_d;
	 	$this->ville_a 		= $p_ville_a;
	 	$this->distance 	= $p_distance;
	 	$this->moyenne 		= $p_moyenne;
	 	$this->jour 		= $p_jour;
	 	$this->cat_code 	= $p_cat_code;
	 	
	 }
	 
	 //-------------------------------------//
	 //--------------GETTERS----------------//
	 //-------------------------------------//

	 public  function get_annee(){
	 	return $this->annee;
	 }
	 
	 public  function get_n_epreuve(){
		 return $this->n_epreuve;
	 }
	 
	 public  function get_code_tdf_d(){
	 	return $this->code_tdf_d;
	 }
	 
	 public  function get_code_tdf_a(){
	 	return $this->code_tdf_a;
	 }
	 
	 public  function get_ville_d(){
	 	return $this->ville_d;
	 }
	 
	 public  function get_ville_a(){
	 	return $this->ville_a;
	 }
	 
	 public  function get_distance(){
	 	return $this->distance;
	 }
	 
	 public  function get_moyenne(){
	 	return $this->moyenne;
	 }
	 
	 public  function get_jour(){
	 	return $this->jour;
	 }
	 
	 public  function get_cat_code(){
	 	return $this->cat_code;
	 }
	 
	 public  function get_date_jour(){
	 	return $this->date_jour;
	 }
	 
	 public  function get_date_mois(){
	 	return $this->date_mois;
	 }
	 
	 public  function get_date_annee(){
	 	return $this->date_annee;
	 }
	 //-------------------------------------//
	 //--------------SETTERS----------------//
	 //-------------------------------------//
	 
	 public  function set_annee($p_annee){
	 	$this->annee = $p_annee;
	 }
	 
	 public  function set_n_epreuve($p_n_epreuve){
	 	$this->n_epreuve = $p_n_epreuve;
	 }
	 
	 public  function set_code_tdf_d($p_code_tdf_d){
	 	$this->code_tdf_d = $p_code_tdf_d;
	 }
	 
	 public  function set_code_tdf_a($p_code_tdf_a){
	 	$this->code_tdf_a = $p_code_tdf_a;
	 }
	 
	 public  function set_ville_d($p_ville_d){
	 	$this->ville_d = $p_ville_d;
	 }
	 
	 public  function set_ville_a($p_ville_a){
	 	$this->ville_a = $p_ville_a;
	 }
	 
	 public  function set_distance($p_distance){
	 	$this->distance = $p_distance;
	 }
	 
	 public  function set_moyenne($p_moyenne){
	 	$this->moyenne = $p_moyenne;
	 }
	 
	 public  function set_jour($p_jour){
	 	$this->jour = $p_jour;
	 }
	 
	 public  function set_cat_code($p_cat_code){
	 	$this->cat_code = $p_cat_code;
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
	 	 				INSERT INTO tdf_epreuve (annee, n_epreuve,ville_d,ville_a,distance,moyenne,code_tdf_d,code_tdf_a,
	 	 				jour,cat_code)
	 	 				VALUES (:annee, :n_epreuve,:ville_d,:ville_a,:distance,:moyenne, :code_tdf_d,:code_tdf_a,
	 	 				:jour,:cat_code)
	 	 			');
	 
	 	return $requete_preparee;
	 }
	 /*
	 INSERT INTO tdf_epreuve (annee, n_epreuve,ville_d,ville_a,distance,moyenne,code_tdf_d,code_tdf_a,jour,cat_code)VALUES (2011,24,'AAA','AAAAAAAA',9,9,'FRA','FRA','05/07/12','PRO')
	 */
	//READ
	public function read($pdo,$p_annee,$p_n_epreuve) {
		$requete_preparee = $this->preparer_requete_read($pdo,$p_annee,$p_n_epreuve);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row) {
			$this->	annee				= $row['ANNEE'];
			$this->	n_epreuve			= $row['N_EPREUVE'];
			$this->	code_tdf_d			= $row['CODE_TDF_D'];
			$this->	code_tdf_a			= $row['CODE_TDF_A'];
			$this->	ville_d				= $row['VILLE_D'];
			$this->	ville_a				= $row['VILLE_A'];
			$this->	distance			= $row['DISTANCE'];
			$this->	moyenne				= $row['MOYENNE'];
			$this->	jour				= $row['JOUR'];
			$this->	cat_code			= $row['CAT_CODE'];
		}
	}
	 
	private function preparer_requete_read($pdo,$p_annee,$p_n_epreuve) {	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_epreuve
		 	 				WHERE annee = '.$p_annee.'	 	 				
		 	 				AND n_epreuve = '.$p_n_epreuve.'';
		return $requete_preparee;
	}
	
	//UPDATE
	public function update($pdo) {
	 	$requete_preparee = $this->preparer_requete_update($pdo);
	 	$this->executer_requete($requete_preparee);
	}
	 
	private function preparer_requete_update($pdo) {
		
	 	$requete_preparee = $pdo->prepare('
	 	 				UPDATE tdf_epreuve
	 	 				SET annee = :annee, n_epreuve = :n_epreuve, code_tdf_d = :code_tdf_d,
	 	 				code_tdf_a= :code_tdf_a, ville_d = :ville_d, ville_a = :ville_a, distance = :distance,
	 	 				moyenne = :moyenne, jour = :jour, cat_code = :cat_code
	 	 				WHERE annee = '.$this->annee.'	 	 				
	 	 				AND n_epreuve = '.$this->n_epreuve);
	 	return $requete_preparee;
	}
	
	//DELETE
	public function delete($pdo) {		
		$requete_preparee = $this->preparer_requete_delete($pdo);
		$requete_preparee->execute();
	}
	
	private function preparer_requete_delete($pdo) {
	
		$requete_preparee = $pdo->prepare('
		 	 				DELETE FROM tdf_epreuve
		 	 				WHERE annee = '.$this->annee.'	 	 				
	 	 					AND n_epreuve = '.$this->n_epreuve.''	 	 				
		 	 			);
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee) {

		$requete_preparee->execute(array(
		'annee'			=> $this->annee,
		'n_epreuve' 	=> $this->n_epreuve,
		'ville_d' 		=> $this->ville_d,
		'ville_a' 		=> $this->ville_a,
		'distance' 		=> $this->distance,
		'moyenne' 		=> $this->moyenne,
		'code_tdf_d' 	=> $this->code_tdf_d,
		'code_tdf_a' 	=> $this->code_tdf_a,
		'jour' 			=> $this->jour,
		'cat_code' 		=> $this->cat_code
		));
		
	}
		
	public function display() {
		echo '
				annee : '.$this->annee.'<br />
				n_epreuve : '.$this->n_epreuve.'<br />
				code_tdf_d : '.$this->code_tdf_d.'<br />
				code_tdf_a : '.$this->code_tdf_a.'<br />
				ville_d : '.$this->ville_d.'<br />
				ville_a : '.$this->ville_a.'<br />
				distance : '.$this->distance.'<br />
				moyenne : '.$this->moyenne.'<br />
				jour : '.$this->jour.'<br />
				cat_code : '.$this->cat_code.'<br />
				
			';
	}

	public function displayR(){
		
		echo 'INSERT INTO tdf_epreuve (annee, n_epreuve,ville_d,ville_a,distance,moyenne,code_tdf_d,code_tdf_a,jour,cat_code)';
	 	echo'VALUES ('.$this->annee.','.$this->n_epreuve.','.$this->ville_d.','.$this->ville_a.','.$this->distance.','.$this->distance.','.$this->code_tdf_d.','.$this->code_tdf_a.',to_date('.$this->jour.',\'DD/MM/YY\'),'.$this->cat_code.')';
	}
	
	public function calculer_nepreuve($bdd){
		$req = $bdd->query("select max(n_epreuve)as idCalcul from tdf_epreuve where annee = ".$this->annee."");
	
		while ($donnee = $req->fetch()){
			$max = $donnee['IDCALCUL'];
		}
	
		return $max+1;
	}
	
	public function decomposerDate(){
		$tab = explode('/',$this->jour);
		$this->date_jour = $tab[0];
		$this->date_mois = $tab[1];
		$this->date_annee = $tab[2];
	}
	
	public function composerDate(){
	
		$tab[0] = $this->date_jour;
		$tab[1] = $this->date_mois;
		$tab[2] = $this->date_annee;
		$this->jour = implode('/',$tab);
	}
	
	public function creerAnneeDate(){
		if ($this->date_annee < 15){
			$this->date_annee = '20'.$this->date_annee;
		}
		else{
			$this->date_annee = '19'.$this->date_annee;
		}
	}
	
	public function EnleverAnneeDate(){
			$this->date_annee = substr($this->date_annee,2,4);
		
	}
	
	public function displayDate(){
		echo 'jour : '.$this->date_jour.'<br />
			  mois :'.$this->date_mois.'<br />
			  annee : '.$this->date_annee.'<br />
			 '; 
	}
	
	public function get_attr()
	{
		return get_object_vars($this);
	}
	
	 
	//-------------------------------------//
	//---------------REGEXP----------------//
	//-------------------------------------//

	public static function e_traitement_regex_ville($chaine){
		
		//on enleve les espaces gauche et droite
		trim($chaine);
		
		
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		$chaine = preg_replace('/[^A-Za-z0-9\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\İ\ \-]{0,19}/', '', $chaine);
		
		
		//On enleve les tirets et espace au minimum en double.
		$chaine = preg_replace('/[\s]{1,}/', ' ', $chaine);// On enlève ou pas  ???
		$chaine = preg_replace('/[\-]{1,}/', '-', $chaine);
		$chaine = preg_replace('/[\']{1,}/', '-', $chaine);
		
		
		
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
		
		
		//On modifie les majuscules et minuscules avec accents en majuscules et minuscules sans accents.
		$accents = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
		$ssaccents = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
		$chaine = strtr($chaine,$accents,$ssaccents);
		
		
		//On met tout en majuscule :
		$chaine = strtoupper($chaine);
		
		
		//On prend par défault une chaine de 30 lettres
		$chaine = substr($chaine,0,25);
		
		return $chaine;
	}

	public static function e_traitement_regex_nombre($chaine,$entier,$decimal){
		
	//on enleve les espaces gauche et droite
		trim($chaine);
	
		
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		$chaine = preg_replace('/[^0-9\,]/', '', $chaine);
		
		
		//On enleve les tirets et espace au minimum en double.
		$chaine = preg_replace('/[\,]{1,}/', ",", $chaine);// On enlève ou pas  ???
		$chaine = preg_replace('/[\s]{1,}/', '', $chaine);// On enlève ou pas  ???
		
		
		//on se met au format exigé.
		
		$tab = explode(',', $chaine);
		
		
		$cpt = 0;
		$nombreEntier="";
		$nombreDecimal="";
		for ($i = 0; $i<count($tab); $i++){
			
			if ($tab[$i] != "")
			{
				if($cpt == 0)
				{
					$nombreEntier = $tab[$i];//on définit l'entier comme premiere case du tableau non vide
					$cpt++;//on indique qur tout autre case du tableau créera les décimals.
				}
				else{
					$nombreDecimal = $nombreDecimal. $tab[$i];
				}	
			}
			
		}
		
		// si l'entier est supérieur à 2 chiffres, ceux d'aprés sont les premières décimals.
		$decalageDecimal = substr($nombreEntier,$entier);
		// On définit l'entier à deux décimals.
		$nombreEntier = substr($nombreEntier,0,$entier);
		// On définit les décimals.
		$nombreDecimal= substr($decalageDecimal.$nombreDecimal,0,$decimal);
		
		//si les decimals existent
		if ($nombreDecimal != ""){
			$nombre[0]=$nombreEntier;
			$nombre[1]=$nombreDecimal;
			$chaine = implode(',', $nombre);
		}
		else{
			$chaine=$nombreEntier;
		}
		
		
		return $chaine;
		
	}
	
	
	
}

?>