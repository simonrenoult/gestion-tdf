<?php

class annee
{
	//-------------------------------------//
	//--------------ATTRIBUTS--------------//	
	//-------------------------------------//
	
	private $annee;
	private $jour_repos;
		
	//-------------------------------------//
	//------------CONSTRUCTEURS------------//
	//-------------------------------------//
	
	public function __CONSTRUCT ($p_annee=null,$p_jour_repos=null)
	{
	 	$this->annee			= $p_annee;
	 	$this->jour_repos 		= $p_jour_repos;
	 	
	}
	 
	//-------------------------------------//
	//--------------GETTERS----------------//
	//-------------------------------------//

	public  function get_annee()
	{
		return $this->annee;
	}
	 
	public  function get_jour_repos()
	{
		return $this->jour_repos;
	}	
	 
	//-------------------------------------//
	//--------------SETTERS----------------//
	//-------------------------------------//
	 
	public  function set_annee($p_annee)
	{
	 	$this->annee = $p_annee;
	}
	 
	public  function set_jour_repos($p_jour_repos)
	{
	 	$this->jour_repos = $p_jour_repos;
	}
	 
	//-------------------------------------//
	//--------------METHODES---------------//
	//-------------------------------------//
	
	//CREATE
	public function create($pdo)
	{
	 	$requete_preparee = $this->preparer_requete_create($pdo);
	 	$this->executer_requete($requete_preparee);

	 	return $requete_preparee;
	}	 

	private function preparer_requete_create($pdo)
	{
		$requete_preparee = $pdo->prepare('
	 	 				INSERT INTO tdf_annee (annee, jour_repos)
	 	 				VALUES (:annee, :jour_repos)
	 	 			');
	 	
	 	return $requete_preparee;
	}
	 
	//READ
	public function read($pdo,$p_annee)
	{
		$requete_preparee = $this->preparer_requete_read($pdo,$p_annee);
		$res = $pdo->query($requete_preparee);
		 
		foreach($res as $row)
		{
			$this->	annee			= $row['ANNEE'];
			$this->	jour_repos		= $row['JOUR_REPOS'];
			
		}
		
		return $requete_preparee;
	}
	 
	private function preparer_requete_read($pdo,$p_annee)
	{	 
		 $requete_preparee = '
		 	 				SELECT * FROM tdf_annee
		 	 				WHERE annee = '.$p_annee.'	 	 				
		 	 				';

		return $requete_preparee;
	}
	
	//UPDATE
	public function update($pdo)
	{
	 	$requete_preparee = $this->preparer_requete_update($pdo);
	 	$this->executer_requete($requete_preparee);
	 	
	 	return $requete_preparee;
	}
	 
	private function preparer_requete_update($pdo)
	{		
		$requete_preparee = $pdo->prepare('
		 				UPDATE tdf_annee
		 				SET annee = :annee, jour_repos = :jour_repos
		 				WHERE annee = '.$this->annee.'	 	 				
		 			');
	
		return $requete_preparee;
	}
	
	//DELETE
	public function delete($pdo)
	{
		$requete_preparee = $this->preparer_requete_delete($pdo);
		$requete_preparee->execute();
		
		return $requete_preparee;
	}
	
	private function preparer_requete_delete($pdo)
	{	
		$requete_preparee = $pdo->prepare('
		 	 				DELETE FROM tdf_annee
		 	 				WHERE annee = '.$this->annee.'	 	 				
		 	 			');
		
		return $requete_preparee;
	}
	
	private function executer_requete($requete_preparee)
	{		
		$requete_preparee->execute(array(
		'annee'			=> $this->annee,
		'jour_repos' 	=> $this->jour_repos,
		));
	}
	
	//AUTRES
	public function display()
	{
		echo '
				annee : '.$this->annee.'<br />
				jour_repos : '.$this->jour_repos.'<br />
			';
	}
	
	public function calculer_annee($bdd)
	{
		$req = $bdd->query("select max(annee)as idCalcul from tdf_annee");
		
		while ($donnee = $req->fetch())
		{
			$max = $donnee['IDCALCUL'];
		}
		
		return $max + 1;
	}
	
	public function display_requete_insert()
	{
		return 'INSERT INTO tdf_annee(annee, jour_repos)
			VALUES ('.
			$this->annee.','.
			$this->jour_repos.')';	
	}

	public function get_attr()
	{
		return get_object_vars($this);
	}
	
	//-------------------------------------//
	//---------------REGEXP----------------//
	//-------------------------------------//
	
	public static function a_annee($subject)
	{
		return preg_match("/^[0-9]{1,4}+$/", $subject);
	}

	public static function a_jour_repos($chaine)
	{
		return preg_match("/^[0-9]{1}+$/", $chaine);
	} 
}
?>