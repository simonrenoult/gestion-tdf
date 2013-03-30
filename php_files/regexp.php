<?php

	function contr_nom_coureur($chaine) {
		return (preg_match("/^[A-Z]{1}[A-Z\'\ \-]{0,20}+$/", $chaine) == 1);
	}
	
	function contr_prenom_coureur($chaine) {
		return (preg_match("/^[A-Z]{1}[a-z\-\ \é\è\à\ç\ù\ö\ï\ä\ë\ü\ê\â\û\î\ô]{0,19}+$/", $chaine) == 1);
	}
	
?>