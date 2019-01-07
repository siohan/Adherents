<?php
if(!isset($gCms) ) exit;
//on établit les permissions
if(!$this->CheckPermission('Adherents Set Prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
//debug_display($parms, 'Parameters');

$idAppli = $this->GetPreference('idAppli');
$motdepasse = $this->GetPreference('motdepasse');
$serie = $this->GetPreference('serie');
//$club_number = $this->GetPreference('club_number');
//$serial = random_string(15);
$OuiNon = array("Oui"=>"1", "Non"=>"0");
$smarty->assign('startform', $this->CreateFormStart($id,'updatecompte', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('idAppli', $this->CreateInputText($id, 'idAppli', 
(isset($idAppli)?$idAppli:'') , 15,25));
$smarty->assign('motdepasse', $this->CreateInputPassword($id,'motdepasse',(isset($motdepasse)?$motdepasse:''), 15,25));
$smarty->assign('serie', $this->CreateInputText($id,'serie',(isset($serie)?$serie:""), 25,50));

$smarty->assign('submit', $this->CreateInputSubmit ($id, 'comptesubmitbutton', $this->Lang('submit')));

echo $this->ProcessTemplate('compte.tpl');
#
#EOF
#
?>