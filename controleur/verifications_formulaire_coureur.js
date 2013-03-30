	//----------------------------------------//
	//------------------NOMS------------------//
	//----------------------------------------//
	
	function c_nom_coureur() 
	{
		var nom = $(':input[name="nom"]');
		
		nom.blur(function() 
		{
			
			$('.nom_js_green').remove();
			$('.nom_js_orange').remove();
			$('.nom_js_red').remove();
			
			var chaine_remplacee = w_nom_coureur();
			
			if(nom.val() == chaine_remplacee) 
			{
				ajouter_img_validation(nom, 'nom_js_green');
			}
			else if(chaine_remplacee != "")
			{
				ajouter_img_correction(nom, 'nom_js_orange', chaine_remplacee);
			}
			else
			{
				ajouter_img_invalidation(nom, 'nom_js_red');
			}
		});
	}
	
	function w_nom_coureur()
	{
		var nom = $(':input[name="nom"]').val();
	
		//on enleve les espaces gauche et droite
		nom.trim();
		
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		var nom_regex = /[^A-Za-z\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\Ý\'\ \-]{0,19}/g;
		nom = nom.replace(nom_regex, '');
	
		//On enleve les tirets, apostrophes et espace au minimum en double.
		nom = nom.replace(/[\s]{1,}/g, ' ');
		nom = nom.replace(/[\-]{1,}/g, '-');
		nom = nom.replace(/[\']{1,}/g, '\'');
	
		//On enleve les cas particuliers.
		nom = nom.replace(/[\s]+[\']{1,}/g, '');
		nom = nom.replace(/[\']+[\s]{1,}/g, '');
		nom = nom.replace(/[\-]+[\']{1,}/g, '');
		nom = nom.replace(/[\']+[\-]{1,}/g, '');
		nom = nom.replace(/[\-]+[\s]{1,}/g, '');
		nom = nom.replace(/[\s]+[\-]{1,}/g, '');
	
		//On enleve les tirets, apostrophes en début et fin.
		nom = nom.replace(/^[\']/g, '');
		nom = nom.replace(/^[\-]/g, '');
		nom = nom.replace(/[\']$/g, '');
		nom = nom.replace(/[\-]$/g, '');
	
		nom = nom.toUpperCase();
	
		//On modifie les majuscules avec acvents en majuscules sans accents.
		nom = enlever_accents(nom);
	
		return nom.substr(0,20);
	}
	
	//----------------------------------------//
	//---------------PRENOMS------------------//
	//----------------------------------------//
	
	function c_prenom_coureur()
	{
		var prenom = $(':input[name="prenom"]');
		
		prenom.blur(function()
		{
			
			
			$('.prenom_js_green').remove();
			$('.prenom_js_orange').remove();
			$('.prenom_js_red').remove();
			
			var chaine_remplacee = w_prenom_coureur() ;
			
			if(prenom.val()== chaine_remplacee) 
			{
				ajouter_img_validation(prenom, 'prenom_js_green');
			}
			else if(chaine_remplacee != "")
			{
				ajouter_img_correction(prenom, 'prenom_js_orange', chaine_remplacee);
			}
			else
			{
				ajouter_img_invalidation(prenom, 'prenom_js_red');
			}
		});
	}
	
	function w_prenom_coureur()
	{
		var prenom = $(':input[name="prenom"]').val();
		
		var prenom_regex = /[^A-Za-z\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\Ý\ \-]{1,19}/g;
		prenom = prenom.replace(prenom_regex, '');
		
		prenom.trim();
		
		//On enleve les tirets, apostrophes et espace au minimum en double.
		prenom = prenom.replace(/[\s]{1,}/g, ' ');
		prenom = prenom.replace(/-{2,}/g,'-');
		
		//On enleve les cas particuliers.
		prenom = prenom.replace(/[\-]+[\s]{1,}/g, '');
		prenom = prenom.replace(/[\s]+[\-]{1,}/g, '');
		
		//On enleve les tirets en début et fin de prenom.
		prenom = prenom.replace(/^[\-]/, '');
		prenom = prenom.replace(/[\-]$/, '');
	
		//On met en majuscule les premieres lettres de chaque mot
		prenom = prenom.toLowerCase();
		
		prenom = capitalize(prenom, "-");
		prenom = capitalize(prenom, " ");
	
		return prenom.substr(0,20);
	}
		
	//----------------------------------------//
	//-------CODE_TDF & DATE_NAISSANCE--------//
	//----------------------------------------//

	function c_code_tdf_date_naissance()
	{
		$('#annee_tdf').blur(function()
		{
			var annee_tdf = parseInt($('select[name="annee_tdf"]>option:selected').val());
			var date_naissance = parseInt($('select[name="date_naissance"]>option:selected').val());
			
			if(date_naissance+15 > annee_tdf)
				alert("Attention aux dates (" +$('select[name="annee_tdf"]>option:selected').val()
					+ " et "+ $('select[name="date_naissance"]>option:selected').val() + ") ! Un coureur " +
					"doit être né pour courir !");
		});
	}	
	
	//----------------------------------------//
	//---------------FONCTIONS----------------//
	//----------------------------------------//
	
	//Met la premiere lettre de chaque mot en majuscule.
	function capitalize(chaine, caractere_sep)
	{
		var tableau_mots = chaine.split(caractere_sep);
		
		for(var mot = 0 ; mot < tableau_mots.length ; mot++)
		{
			var p_lettre = tableau_mots[mot].substr(0,1);
			p_lettre = enlever_accents(p_lettre);
			p_lettre = p_lettre.toUpperCase();
			
			var reste = tableau_mots[mot].substr(1,tableau_mots[mot].length);
			
			tableau_mots[mot] = p_lettre+reste;
		}
		
		return tableau_mots.join(caractere_sep);
	}
	
	//Remplace les caractères accentués.
	function enlever_accents(str)
	{
		var norm = new Array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë',
		'Ì','Í','Î','Ï', 'Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý',
		'Þ','ß', 'à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î',
		'ï','ð','ñ', 'ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ý','þ','ÿ');
			
		var spec = new Array('A','A','A','A','A','A','A','C','E','E','E','E',
		'I','I','I','I', 'D','N','O','O','O','0','O','O','U','U','U','U','Y',
		'b','s', 'a','a','a','a','a','a','a','c','e','e','e','e','i','i','i',
		'i','d','n', 'o','o','o','o','o','o','u','u','u','u','y','y','b','y');
			
		for (var i = 0; i < spec.length; i++)
			str = replaceAll(str, norm[i], spec[i]);
		
		return str;
	}
	
	//Remplace toutes les occurences d'une chaine.
	function replaceAll(str, search, repl)
	{
		while (str.indexOf(search) != -1)
			str = str.replace(search, repl);
		
		return str;
	}

	
	//----------------------------------------//
	//--------------AJOUT IMAGES--------------//
	//----------------------------------------//
	
	function ajouter_img_validation(champ,nom_img)
	{
		champ.after(" <img class=\""+nom_img+"\" src = \"./../vue/img/check_16.png\"/>" +
		 "<span class=\""+nom_img+"\" style=\"color:green\"> Format correct.</span>");
	}

	function ajouter_img_correction(champ,nom_img,chaine)
	{
		champ.after(" <img class=\""+nom_img+"\" src = \"./../vue/img/warn_16.png\"/>" +
		 "<span class=\""+nom_img+"\" style=\"color:orange\"> Remplac&eacute par : "+chaine+"</span>");
	}
	
	function ajouter_img_invalidation(champ,nom_img)
	{
		champ.after(" <img class=\""+nom_img+"\" src = \"./../vue/img/cross_16.png\"/>" +
		 "<span class=\""+nom_img+"\" style=\"color:red\"> Format inconnu.</span>");
	}