<?php

	function est_premiere_lettre_majuscule($chaine) {
		return (preg_match("/^[A-Z]/", $chaine) == 1);
	}
	
	function est_alphabetique($chaine) {
		return (preg_match("/^[A-Za-z]+$/", $chaine) == 1);
	}
	
	function est_alphanumerique($chaine) {
		return (preg_match("/^[A-Za-z0-9]+$/", $chaine) == 1);
	}
	
	function est_majuscule($chaine){
		return(preg_match("/^[A-Z]+$/", $chaine) ==1);
	}	
		
?>