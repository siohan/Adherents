<?php
if(!isset($gCms) ) exit;
//on établit les permissions
if(!$this->CheckPermission('Adherents use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
//debug_display($parms, 'Parameters');

$idAppli = $this->GetPreference('idAppli');
$motdepasse = $this->GetPreference('motdepasse');
$serie = $this->GetPreference('serie');
$club_number = $this->GetPreference('club_number');
//$serial = !empty($serie)?$serie:"";
$smarty->assign('startform', $this->CreateFormStart($id,'updatecompte', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('idAppli', $this->CreateInputText($id, 'idAppli', 
(isset($idAppli)?$idAppli:'') , 15,25));
$smarty->assign('motdepasse', $this->CreateInputPassword($id,'motdepasse',(isset($motdepasse)?$motdepasse:''), 15,25));
$smarty->assign('serie', $this->CreateInputText($id,'serie',(isset($serie)?$serie:''), 25,50));
$smarty->assign('club_number', $this->CreateInputText($id, 'club_number',(isset($club_number)?$club_number:''),15,25));
//$smarty->assign('tm', $this->CreateInputText($id, 'tm',$value = date('YmdHisu'),25,150));
$smarty->assign('submit', $this->CreateInputSubmit ($id, 'comptesubmitbutton', $this->Lang('submit')));

echo $this->ProcessTemplate('compte.tpl');
#
#EOF
#
?>