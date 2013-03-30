<?php

class bdd {

    //-------------------------------------//
    //---------------ATTRIBUTS-------------//    
    //-------------------------------------//
        
    private $bdd;
    
	private $login;
	private $mdp;
	private $instance;
		
    //-------------------------------------//
	//----------CONSTRUCTEURS--------------//    
	//-------------------------------------//

	public function __construct($p_login="g4llic4",$p_mdp="ueg7q7t",
		$p_instance = "//localhost:1521/xe") {
	    
	    $this->login 	= $p_login;
	    $this->mdp   	= $p_mdp;
	    $this->instance = $p_instance;
	    
	    $this->connexion();
	    
	}
		
	//------------------------------------//
	//--------------GETTERS---------------//    
	//------------------------------------//
	
	public function get_bdd() {
		return $this->bdd;
	}
	
	public function get_login() {
	    return $this->login;
	}
	
	public function get_mdp() {
	    return $this->mdp;
	}
	
    //-------------------------------------//
    //---------------SETTERS---------------//    
    //-------------------------------------//
    
	public function set_bdd($p_bdd) {
	    $this->bdd = $p_bdd;
	}
	
	public function set_login($p_login) {
	    $this->login = $p_login;
	}
	
	public function set_mdp($p_mdp) {
	    $this->mdp = $p_mdp;
	}
		
    //-------------------------------------//
    //---------------METHODS---------------//    
    //-------------------------------------//
    
	//----------------PUBLIC---------------//
	
	
	//---------------PRIVATE---------------//
	
	private function connexion() {
	    
	    try {
	    
	        $this->bdd = new PDO ("oci:dbname=".$this->instance, $this->login, $this->mdp);
	        	
	    }
	    catch (Exception $e) {
	        die('Erreur : ' . $e->getMessage());
	    }   
	}
}

?>
