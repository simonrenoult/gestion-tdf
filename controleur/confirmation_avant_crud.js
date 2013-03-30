function attention()
	{
		resultat=window.confirm('Attention, vous êtes sur le point de modifier les demandes sélectionnées, voulez-vous continuer ?');
		if (resultat==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}