<?php
	
class transaction
{	
	//-------------------------------------//
	//---------------ATTRIBUTS-------------//    
	//-------------------------------------//
	
	public static $fichier = "../vue/log";
	
	private $utilisateur;
	private $requete;
	private $valeurs;
	private $date_transaction;
	
	//-------------------------------------//
	//------------CONSTRUCTEUR-------------//
	//-------------------------------------//
	
	//FIXME admin
	public function __construct($p_requete, $p_valeur, $p_utilisateur="admin") 
	{
		$this->utilisateur	= $p_utilisateur;
		$this->requete		= $p_requete;
		$this->valeurs		= $p_valeur;
	}

	//-------------------------------------//
	//----------------GETTERS--------------//
	//-------------------------------------//
	
	public function get_utilisateur()
	{
		return $this->utilisateur;
	}
	
	public function get_requete()
	{
		return $this->requete;
	}
	
	public function get_data_transaction()
	{
		return $this->date_transaction;
	}
	
	//-------------------------------------//
	//----------------SETTERS--------------//
	//-------------------------------------//
	
	public function set_utilisateur($p_utilisateur)
	{
		$this->utilisateur = $p_utilisateur;
	}
	
	public function set_requete($p_requete)
	{
		$this->requete = $p_requete;
	}
	
	public function set_date_transaction($p_date_transaction)
	{
		$this->date_transaction = $p_date_transaction;
	}
	
	//-------------------------------------//
	//----------INITIALISATIONS------------//
	//-------------------------------------//
	
	private function init_format_date()
	{
		$this->date_transaction = date("[l d/m/Y - H:i]");
	}
	
	private function init_format_requete()
	{
		$this->requete = print_r($this->requete,true);
		//42 = nombre de caractères avant la chaine qui nous intéresse
		$this->requete = substr($this->requete, 42);
		//suppression parenthèse finale
		$this->requete = preg_replace('/[\)]$/','', $this->requete);
		//suppression tabulations
		$this->requete = preg_replace('/[\\t]/', "", $this->requete);
		//suppression espces inutiles
		$this->requete = trim($this->requete);
	}
	
	private function init_format_valeurs()
	{
		$i = 0;
		$tab = array();
		
		foreach ($this->valeurs as $key => $value)
		{
			$tab[$i] = $this->valeurs[$key];
			$i++;
		}
		
		$this->valeurs = $tab;
	}
	
	private function init_format_i_transaction()
	{	
		$this->init_format_valeurs();
		$this->init_format_date();
		$this->init_format_requete();
		
		return $this->date_transaction.' '.$this->utilisateur." :\n"
					.$this->requete."\n"
					."Valeurs saisies : "
					.implode("\t", $this->valeurs)."\n\n";
	}
	
	private static function init_format_o_transaction($chaine)
	{
		preg_replace("/[\:]/", ":<br />", $chaine);
		$chaine = $chaine.'<br />';
		
		return $chaine;
	}
	
	//-------------------------------------//
	//---------------METHODS---------------//
	//-------------------------------------//
	
	public function ecrire_transaction()
	{
		$log = $this->init_format_i_transaction();
		
		if ($fichier = fopen(transaction::$fichier, "a"))
		{
			fputs($fichier,$log);
		}
		else
		{
			echo "transaction.class.php > ecrire_transaction > erreur à l'ouverture du fichier";
		}
	}
	
	public static function lire_transactions()
	{
		if ($fichier = fopen(transaction::$fichier, "r"))
		{
			while( ($ligne = fgets($fichier)) != null)
			{
				$ligne = transaction::init_format_o_transaction($ligne);
				echo $ligne;
			}
		}
		else
		{
			echo "transaction.class.php > lire_transaction > erreur à l'ouverture du fichier";
		}
	}
}
?>
	
