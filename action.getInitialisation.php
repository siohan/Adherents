<?php
if(!isset($gCms)) exit;
if(!$this->CheckPermission('Adherents use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('adherents');
}
//debug_display($params, 'Parameters');
//les différents statuts possibles : 
	//Undefined Par défaut
	//Ko l'install a échouée.
	//Ok l'install a réussie.
	

$service = new Servicen();

//Ceci teste la connexion puis si succès envoie vers l'onglet configuration sinon retour onglet Compte
	
		
$initialisation = $service->initialisationAPI();
//var_dump($initialisation);
//on instancie un message de sortie
$message = '';
$ops = new adherents_spid();
if($initialisation == 1)
{
	$message.="La FFTT a validé votre connexion";
	$this->SetMessage($$message);
	//on va vérifier que le numéro du club est bon
	$this->Redirect($id, 'add_edit_club_number', $returnid);
	/*
	$club_number = $this->GetPreference('club_number');
	
	$verifyClub = $ops->VerifyClub($club_number);
	var_dump($verifyClub);
	
	if(true === $verifyClub)
	{
		$message.=" Le numéro de club est correct";
		$this->SetMessage($message);
		$this->RedirectToAdminTab('adherents');
	}
	else
	{
		$message.=" Le numéro de club est incorrect ou la connexion est instable : Recommencez un peu plus tard...";
		//on supprime le numéro du club !!
		$this->SetPreference('club_number', '0');
		$this->SetMessage($message);
		$this->RedirectToAdminTab('compte');
	}
	*/
	
}
else
{
	$this->SetMessage("Une erreur s'est produite : vos identifiants sont erronés !");
	$this->RedirectToAdminTab('compte');
	
}
/*
else
{
	$this->SetMessage("La FFTT a validé votre connexion");
	$this->RedirectToAdminTab('adherents');
}
*/
#
#EOF
#
?>