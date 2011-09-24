<?php
//echo "autoCompletion_answer.php chargé","<br>";
//
//	Librairie by The Rubik's Man
//		    © 2005-2006
//

// Include des parametres
include ("../autoCompletion_config.php");

/**
  *	Fonction permettant simplement d'etablir la connexion avec la base
  */
function dbConnect()
{
	global $base_url,$login_base,$pwd_base,$database;
	
	try {
				$bdd = new PDO ("oci:dbname=//localhost:1521/xe", "admin", "admin");
				//printf("Connexion Ok");
				//echo "<br>";
			}
			catch(PDOException $e) {
				//printf("Echec de la connexion");
				//printf("ERREUR : %s", $e->getMessage());
			}
	return $bdd;
	//$etat = mysql_connect($base_url,$login_base,$pwd_base);
	//mysql_select_db($database);
	//return $etat;
}
/**
  *	Fonction permettant simplement de fermer la connexion avec la base
  */
function dbClose()
{
	$bdd= NULL;
	//mysql_close();
}

// On decode les parametres envoyes par ajax ( utf8_decode tres utile pour les problemes avec des accents => utf8_encode()   puis utf8_decode() )
//$_POST['post'] = utf8_decode($_POST['post']);


/////////////////////////////////////////////// REQUETE MYSQL ////////////////////////////////////////////////////
$bdd = dbConnect();
	
	//$req ="SELECT ".$field_id.",".$field_search." FROM ".$table." WHERE ".$field_search." LIKE '".$_POST['post']."%' ORDER BY ".$order_by." ".$sort." AND ROWNUM <=".$nbr_display;
	//$req ="SELECT ".$field_id.",".$field_search." FROM ".$table." WHERE ".$field_search." LIKE 'AR%' AND ROWNUM <=".$nbr_display." ORDER BY ".$order_by." ".$sort;
	$req ="SELECT ".$field_id.",".$field_search." FROM ".$table." WHERE ".$field_search." LIKE  UPPER('".$_POST['post']."%') AND ROWNUM <=".$nbr_display." ORDER BY ".$order_by." ".$sort;

	//echo $req;
	//$query = $bdd->query($req);
	$query = $bdd->prepare($req);
	$query->execute();
	
/*$query = MYSQL_QUERY("
							SELECT
										".$field_id.",
										".$field_search."
							FROM
										".$table."
							WHERE
										".$field_search." LIKE '".$_POST['post']."%'
							ORDER BY
										".$order_by." ".$sort."
							LIMIT
										".$nbr_display."
					")
					or die(mysql_error());*/
							
//dbClose();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////EXTRACTION DE LA REQUETE ///////////////////////////////////////////
$response = array();

while ( $result = $query->fetch(PDO::FETCH_ASSOC) ){
		//print_r($result);
		
		//$chaine = "".$result[$field_search]."	".$result[field_search_option]."";
		//echo $chaine;
		$response[] = array (
							$field_id => $result[$field_id],
							$field_search => $result[$field_search],
							//$field_search_option => $result[field_search_option]
						);
}

//print_r($response);


/*while ( $result = MYSQL_FETCH_ARRAY($query,MYSQL_ASSOC) )
{
	$response[] = array (
							$field_id => $result[$field_id],
							$field_search => $result[$field_search]								
						);
}*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// CREATION DE LA CHAINE DE CARACTERES ENVOYEE ////////////////////////////////////



$return = '';
for($i=0;$i<count($response);$i++)
{
	$return .= join('=>',$response[$i]);
	if ( $i != count($response)-1 ) $return .= '|||';
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// RENVOIE DE LA CHAINE ENCODEE ///////////////////////////////////////////
echo utf8_encode($return);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//	Librairie by The Rubik's Man
//		    © 2005-2006
//
?>