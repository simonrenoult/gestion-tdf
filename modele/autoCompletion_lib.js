
		var focus = false;
		var current_id_focus = 0;
		var current_search = '';
		var current_nbr = 0;
		var search_id = new Array('-1');
		var border_no_foc = '';
		var background_color_no_foc = '';
		var background_color_foc = '';
		var border_foc = '';
		var file_ref;
		
		/**
		  *		Permet d'initialiser les variables de config javascript
		  *		Cf. config.php  pour les significations des variables
		  *
		  */
		function autoCompletion_init(border_no_foc,border_foc,background_color_no_foc,background_color_foc,file_ref)
		{
			this.border_no_foc = border_no_foc;
			this.border_foc = border_foc;
			this.background_color_no_foc = background_color_no_foc;
			this.background_color_foc = background_color_foc;
			this.file_ref = file_ref;
		}
		
		
		/**
		  *		Fonction controlant les actions a faire en fonction de la valeur du code de l'event "KeyUp"
		  *		Permet la navigation clavier dans la liste dynamique
		  *		
		  *		@ param : value => valeur du champ de texte principal
		  *			       event => l'evenement associe au KeyUp
		  */
		function event_capture(value,event)
		{
			this.current_search = document.autoCompletion.autoCompletion_input.value;
			/*
				Normalement le " event.keyCode " n'est utilise que par IE et pas par Mozilla et Firefox qui eux utilisent "which"
				Mais a ma grande stupefaction apres un test sous firefox .... cela marche ossi... alors pourquoi aller mettre du code en plus...
			*/
			switch (event.keyCode)
			{
				// TOUCHE " FLECHE BAS "
				case 40 :
								if ( current_id_focus > 0 && current_id_focus < current_nbr) loose_focus_style(current_id_focus);
								if ( current_id_focus < current_nbr )
								{
									give_focus_style(current_id_focus+1);
									current_id_focus++;
								}
								break;
								
				// TOUCHE " FLECHE HAUT "
				case 38 :
								if ( current_id_focus >= 1 )
								{
									loose_focus_style(current_id_focus);
									if ( current_id_focus >= 2 ) give_focus_style(current_id_focus-1);
									this.current_id_focus--;
								}
								break;
								
				// TOUCHES " FLECHE GAUCHE " et " FLECHE DROITE " desactivees
				case 37 : 		break;
				case 39 : 		break;
				
				// TOUCHE " ENTRER "
				case 13 :		if ( value != '' ) redirect();
				
				// TOUTES LES AUTRES TOUCHES
				default :
								if ( value == '' )
								{
									current_id_focus = 0;
									current_nbr = 0;
									hide_list();
								}
								else AJAX(value);
								break;
			}
		}
		
		/**
		  *		Permet la redirection apres un click ou l'appui sur "entrer"
		  *		 - si on click sur un element de la liste ou que l'on appui sur "entrer" sur un des elements => mode fiche => id en parametre ( id=X )
		  *		 - si on appui sur "entrer" dans le champ texte principal => mode recherche => valeur de la recherche en parametre ( search=xxx )
		  */
		function redirect()
		{
			window.location.href = current_id_focus != 0 ? 
															file_ref+'?id='+search_id[current_id_focus]
														:
															file_ref+'?search='+current_search;
		}
		
		/**
		  *		Permet avec l'outil ajax d'effectuer dynamiquement des requetes
		  *
		  *		@ param value : valeur de la recherche courante
		  *
		  */
		function AJAX(value)
		{
			this.current_id_focus = 0;
			
			// On cree l'objet AJAX
			if(document.all)
			{
				//Internet Explorer
				var AJAX = new ActiveXObject("Microsoft.XMLHTTP");
			}
			else
			{
			    //Mozilla
				var AJAX = new XMLHttpRequest();
			}
			
			// On defini le fichier appele lors de l'envoie
			AJAX.open("POST", '../controleur/auto_completion_reponse.php',true);
				
			//Fonction appelee automatiquement lors de la fin des transferts asynchrones
			// C'est ici que l'on dit ce qu'il va se passer apres le renvoie
			AJAX.onreadystatechange = function()
			{
				if (AJAX.readyState == 4 && AJAX.status == 200) 
				{
					/* 
						ici j'ai choisi une structure simple.
						Par exemple pour un dictionnaire : si on tape "abc"
						la reponse sera par exemple pour un affichage de 5 elements : 
							X=>abcisse|||X=>abcisses|||X=>abcede|||X=>abcedent|||X=>abces
						X signifie l'id du mot dans la table =>  permet lors d'un click ou de l'appui sur la touche "entree" sur
												une recherche d'envoyer l'id par exemple ici pour aller a la 
												page de la definition de ce mot
					*/
					// Enlever le commentaire de l'alert pour voir dans une fenetre la reponse AJAX
					//alert(AJAX.responseText);
					
					// On appelle la fonction d'ecriture des input avec la reponse d'ajax en parametre
					write_div(AJAX.responseText);
				}
			}
			
			// On declare le type des donnees echangees => ici du texte
			// On pourait utiliser du XML mais ici cela est très peu utile par le petite quantite de donnee echangee
			AJAX.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			AJAX.send('post='+value);
		}
		
		/**
		  *		Permet d'ecrire le code html de la div de recherche rapide
		  *
		  *		@ param : fields => chaine de caractere de la reponse ajax
		  *		@ return : //
		  */
		function write_div(fields)
		{
			var div = document.getElementById('auto_completion_reponse'); // Block d'affichage
			
			// On extrait la reponse ajax, on enregistre le nombre de resultats
			var tmp = fields.split('|||');
			var tmp_length = tmp.length == 1 && tmp[0] == '' ? 0 : tmp.length;
			current_nbr = tmp_length;
			
			// On cree le code html que l'on va inserer dans la div
			var output = '';
			for(var i=0;i<tmp_length;i++)
			{
				var id = i + 1;
				tmp2 = tmp[i].split('=>');
				this.search_id[id] = tmp2[0];
				output += '<input style=\"background-color:'+background_color_no_foc+';border:'+border_no_foc+';\" onBlur=\"focus_off();\" onClick="redirect();" onMouseOver=\"give_focus_style('+id+',1);\"  readonly=\"readonly\" type=text id=\"list'+id+'\" value="'+tmp2[1]+'">';
			}
			// Ajouter
			//output += '<div class=\"signature\" onClick=\"document.autoCompletion.autoCompletion_input.focus();\" onBlur=\"focus_off();\"><p class=\"p2\">Ajouter un coureur</p></div>';
			
			
			// Si la reponse ajax n'est pas vide on affiche, sinon on efface
			if ( fields != '' )
			{
				div.innerHTML = output;
				div.style.display = 'block';
			}
			else hide_list();
		}
	
		/**
		  *		Permet de controler que l'on est dans une recherche
		  *		Cela permet de ne pa effacer la liste si un 
		  *		click est porte au niveau de la liste, alors qu'elle sera effacee si on click ailleur
		  *		C'est un systeme de bidouille... mais j'ai trouve que ca pour palier ce probleme sans intercepter
		  *		tous les evenements souris de javascript ce qui serait beaucoup plus lourd en code
		  */
		function focus_on()
		{
			focus = true;
		}
		function focus_off()
		{
			focus = false;
		}
		document.onclick = function ()
						   {
								if ( focus == false ) hide_list();
						   };
		function hide_list()
		{
			document.getElementById('auto_completion_reponse').style.display='none';
		}
		
		
		
		/**
		  *		Permet de changer le style des inputs
		  *		
		  *		Changement de style par javascript car en css :hover sur <input> ou <div> ne fonctionne pas sous IE
		  *		Puis pour les changements de focus par entree clavier necessite du javascript
		  *
		  *		@ param : id => id de l'input text a changer le style
		  *			       control => permet suivant les cas l'activation de certaines operations
		  *
		  */
		function give_focus_style(id,control)
		{
			if ( id != 0 && id != current_id_focus)
			{
				var input_hidden = document.getElementById('list'+id);
				input_hidden.style.backgroundColor = background_color_foc;
				input_hidden.style.border = border_foc;
				input_hidden.style.cursor = 'pointer'; // Pour IE qui ne prend pas en compte les :hover sur les div en CSS
			}
			if ( control == 1 && id != current_id_focus)
			{
				loose_focus_style(current_id_focus);
				current_id_focus = id;
			}
		}		
		
		/**
		  *		Permet d'enlever le style focus et de remettre le style normal
		  *		Fonction appelee depuis " give_focus_style " avant de mettre le style focus au nouveau input courant
		  *
		  *		@ param : id => id de l'input text a desactiver le style focus
		  */
		function loose_focus_style(id)
		{
			if ( current_id_focus != 0 )
			{
				var input_hidden = document.getElementById('list'+id);
				input_hidden.style.backgroundColor = background_color_no_foc;
				input_hidden.style.border = border_no_foc;
			}
		}
//
//	Librairie by The Rubik's Man
//		    © 2005-2006
//