	//----------------------------------------//
	//-----------------VILLES-----------------//
	//----------------------------------------//
	
	function c_ville_epreuve(p_type_ville) 
	{
		var nom = $(':input[name="'+p_type_ville+'"]');
		
		nom.blur(function() 
		{
			
			$('.'+p_type_ville+'_js_green').remove();
			$('.'+p_type_ville+'_js_orange').remove();
			$('.'+p_type_ville+'_js_red').remove();
			
			var chaine_remplacee = w_ville_epreuve(p_type_ville);
			
			if(nom.val() == chaine_remplacee) 
			{
				ajouter_img_validation(nom, ''+p_type_ville+'_js_green');
			}
			else if(chaine_remplacee != "")
			{
				ajouter_img_correction(nom, ''+p_type_ville+'_js_orange', chaine_remplacee);
			}
			else
			{
				ajouter_img_invalidation(nom, ''+p_type_ville+'_js_red');
			}
		});
	}
	
	function w_ville_epreuve(p_type_ville)
	{
		var nom = $(':input[name="'+p_type_ville+'"]').val();
	
		//on enleve les espaces gauche et droite
		nom.trim();
		
		// On enleve tous les caractères n'appartenant pas à ceux ci dessous.
		var nom_regex = /[^A-Za-z0-9\À\Á\Â\Ã\Ä\Å\à\á\â\ã\ä\å\Ò\Ó\Ô\Õ\Ö\Ø\ò\ó\ô\õ\ö\ø\È\É\Ê\Ë\è\é\ê\ë\Ç\ç\Ì\Í\Î\Ï\ì\í\î\ï\Ù\Ú\Û\Ü\ù\ú\û\ü\ÿ\Ñ\ñ\Ý\ \-]{0,19}/g;
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
	
		return nom.substr(0,25);
	}
	
	//----------------------------------------//
	//---------------NOMBRES------------------//
	//----------------------------------------//
	
	function c_nombre_epreuve(p_type_nombre,entier,decimale)
	{
		var nb = $(':input[name="'+p_type_nombre+'"]');
		
		nb.blur(function()
		{
			$('.'+p_type_nombre+'_js_green').remove();
			$('.'+p_type_nombre+'_js_orange').remove();
			$('.'+p_type_nombre+'_js_red').remove();
			
			var chaine_remplacee = w_nombre_epreuve(p_type_nombre,entier,decimale) ;
			
			if(nb.val().match(regex_prenom) ) 
			{
				ajouter_img_validation(nb, ''+p_type_nombre+'_js_green');
			}
			else if(chaine_remplacee != "")
			{
				ajouter_img_correction(nb, ''+p_type_nombre+'_js_orange', chaine_remplacee);
			}
			else
			{
				ajouter_img_invalidation(nb, ''+p_type_nombre+'_js_red');
			}
		});
	}
	
	function w_nombre_epreuve(p_type_nombre,entier,decimale)
	{
		var nb = $(':input[name="'+p_type_nombre+'"]').val();
		
		var nb_regex = /[^0-9\,]/g;
		nb = nb.replace(nb_regex, '');
		
		nb.trim();
		
		nb = nb.replace(/[\,]{1,}/g, ',');
		nb = nb.replace(/[\s]{1,}/g,'');
		
		var tab = nb.split(',');
		var cpt = 0;
		var nb_entier="";
		var nb_decimal="";
		
		for(var i = 0 ; i < tab.length ; i++)
		{
			if(cpt == 0)
			{
				nb_entier = tab[i];
				cpt++;
			}
			else
			{
				nb_decimal = nb_decimal+tab[i];
			}
		}
		
		var decalage_decimales = nb_entier.substr(entier,nb_entier);
		nb_entier = nb_entier.substr(0,entier);
		nb_decimal = decalage_decimales+nb_decimal;
		nb_decimal = nb_decimal.substring(0, decimale);
	
		if (nb_decimal != "")
		{
			tab[0]=nb_entier;
			tab[1]=nb_decimal;
			nb = nb.join(',');
		}
		else
		{
			nb=nb_entier;
		}
		
		return nb;
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