<?php

	class BDD {
		
		//-------------------------------------//
		//--------------ATTRIBUTS--------------//
		//-------------------------------------//		
		
		private $connexion;
		private $usr;
		private $pwd;
		private $bdd;
		
		
		//-------------------------------------//
		//------------CONSTRUCTEURS------------//
		//-------------------------------------//
		
		/*public function __construct($p_connexion = "oci:dbname=//localhost:1521/xe"
		, $p_usr = "admin", $p_pwd = "admin"){*/
		public function __construct(){
			
			$this->connexion 	= connexion;
			$this->usr 			= usr;
			$this->pwd 			= pwd;
			$this->bdd 			= new PDO ($this->connexion,$this->usr,$this->pwd);
		}
		
		//-------------------------------------//
		//--------------GETTERS----------------//
		//-------------------------------------//
		
		public function getBDD() {
			return $this->bdd;
		}
		
		//-------------------------------------//
		//--------------METHODES---------------//
		//-------------------------------------//
				
			
	
	}
	
?>