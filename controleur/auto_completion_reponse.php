<?php

	include "../config/auto_completion_config.php";
	include "../config/bdd_config.php";
	
	/**
	 *	Fonction permettant simplement d'etablir la connexion avec la base
	 */
	function dbConnect()
	{
		global $connexion, $usr, $pwd;
		
		try
		{
			$bdd  = new PDO ($connexion,$usr,$pwd);
		}
		catch(PDOException $e)
		{
		}
		
		return $bdd;
	}
	
	/**
	 *	Fonction permettant simplement de fermer la connexion avec la base
	 */
	function dbClose()
	{
		$bdd= NULL;
	}
	
	//-------------------------------------//
	//----------------REQUETE--------------//
	//-------------------------------------//
	
	$bdd = dbConnect();
	
	$req ="SELECT ".$field_id.",".$field_search." FROM ".$table." WHERE ".$field_search." LIKE  UPPER('".$_POST['post']."%') AND ROWNUM <=".$nbr_display." ORDER BY ".$order_by." ".$sort;
	$fp = fopen("text.txt","a+");
	fputs($fp, $req);
	$query = $bdd->prepare($req);
	$query->execute();
	
	//-------------------------------------//
	//--------------EXTRACTION-------------//
	//---------------REQUETE---------------//
	//-------------------------------------//
	
	$response = array();
	
	while ( $result = $query->fetch(PDO::FETCH_ASSOC) )
	{
		$response[] = array (
			$field_id => $result[$field_id],
			$field_search => $result[$field_search]
		);
	}
	
	//-------------------------------------//
	//---------------CREATION--------------//
	//----------------CHAINE---------------//
	//---------------RENVOYEE--------------//
	//-------------------------------------//
	
	$return = '';
	for($i=0;$i<count($response);$i++)
	{
		$return .= join('=>',$response[$i]);
		if ( $i != count($response)-1 )
		{
			$return .= '|||';
		}
	}
	
	//-------------------------------------//
	//----------------RENVOI---------------//
	//----------------CHAINE---------------//
	//----------------ENCODEE--------------//
	//-------------------------------------//
	
	echo utf8_encode($return);

?>