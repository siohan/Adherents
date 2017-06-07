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

if($initialisation === FALSE)
{
	$this->SetMessage("Une erreur s'est produite : vos identifiants sont erronés !");
	$this->RedirectToAdminTab('compte');
	
}
elseif($initialisation == '1')
{
	$this->SetMessage("La FFTT a validé votre connexion");
	$this->RedirectToAdminTab('adherents');
}
else
{
	$this->SetMessage("La FFTT a validé votre connexion");
	$this->RedirectToAdminTab('adherents');
}
#
#EOF
#
?>