<?php
	include '../config/bdd_config.php';
	include '../modele/bdd.class.php';	
	

/*
 * Permet de construire le tableau à partir de la requête écrite sur la zone de texte.
 * 
 */
function remplirtab()
{
	if(isset($_POST['executer']))
	{
		$bdd = new BDD();
		$req = strtoupper($_POST['area']);
		try 
		{
			$query = $bdd->getBDD()->prepare($req);
			$query->execute();
			
			echo"<table width=\"100%\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\" >";
			
			//Creation des noms de colonnes (si compliqué !)
			$i=0;
			echo "<tr>\n";
			while ($donnee = $query->fetch(PDO::FETCH_ASSOC))
			{
				if ($i == 0)
				{
					foreach ($donnee as $key=>$valeur)
					{
						echo "<th>$key</th>\n";
					}
				}
				
				$i++;
			}
			echo "</tr>\n";
			
			//Creation de l'affichage du select
			$query->execute();
			while ($donnee = $query->fetch(PDO::FETCH_NUM))
			{
				echo "<tr>\n";
				for($i=0;$i<count($donnee);$i++)
				{
					echo "<td>".$donnee[$i]."</td>";
				}	
				echo"</tr>\n";
			}
			
			echo"</table>";	
			$query->closeCursor();
			
		}
		catch (Exception $e){}
	}
}

include '../vue/formulaire_requete_manuelle.php';

?>

