<?php

	function majuscule($chaine) {
		return (preg_match("/^[A-Z]/", $chaine) > 0);
	}
?>