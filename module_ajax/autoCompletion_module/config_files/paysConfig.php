<?php
/////////////////////////////////////  DEFINITION DES PARAMETRES ///////////////////////////////
/////////////// FILE REF ////////////////
$file_ref = "formulaire.php";

////////////////////////////////////////
/////////  PARAMETRES MYSQL //////////
$base_url = "localhost";
$login_base = "admin";
$pwd_base = "admin";
$database = "autocompletion";
////////////////////////////////////////
/// PARAMETRES MYSQL RECHERCHE /////
$table = "TDF_PAYS";	// table mysql dans laquelle se trouve les champs
$field_search = "NOM";  // nom du champ mysql sur lesuel va s'effectuer la comparaison
$field_id = "CODE_TDF";		// nom du champ comprenant l'id des lignes


$order_by = "NOM";		// nom du champ a partir duquel on veut ordonner notre liste
$sort = "ASC";			// sens de l'ordre ASC ou DESC
$nbr_display = 10;		// nombres d'elements affiches dynamiquement

///////////////////////////////////////
//////////// STYLE CONFIG ////////////
// Ligne non selectionnee
$background_color_no_foc = '#99CCCC';
$border_no_foc = '0';

// Ligne selectionnee
$background_color_foc = '#00FF00';
$border_foc = '1px solid';
//////////////////////////////////////
?>