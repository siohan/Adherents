<?php
if(!isset($gCms) ) exit;
//on établit les permissions
if(!$this->CheckPermission('Adherents Set Prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('adherents');
}
if(isset($params['submit']))
{
	$module = \cms_utils::get_module($compositions);
	$result = 0;
	if( is_object( $module ) ) $result = 1;
	$this->SetPreference('feu_fftt', $params['feu_fftt']);
	$this->SetPreference('feu_messages', $params['feu_messages']);
	$this->SetPreference('feu_inscriptions', $params['feu_inscriptions']);
	$this->SetPreference('feu_contacts', $params['feu_contacts']);
	$this->SetPreference('feu_presences', $params['feu_presences']);
	$this->SetPreference('feu_factures', $params['feu_factures']);
	$this->SetPreference('feu_commandes', $params['feu_commandes']);
	$this->SetPreference('feu_compos', $params['feu_compos']);
	$this->SetMessage('Config modifiée');
	$this->RedirectToAdminTab('config');
}
else
{
	//debug_display($parms, 'Parameters');

	$feu_fftt = $this->GetPreference('feu_fftt');
	$feu_messages = $this->GetPreference('feu_messages');
	$feu_contacts = $this->GetPreference('feu_contacts');
	//$club_number = $this->GetPreference('club_number');
	//$serial = random_string(15);
	$OuiNon = array("Oui"=>"1", "Non"=>"0");
	$smarty->assign('startform', $this->CreateFormStart($id,'admin_config_tab', $returnid));
	$smarty->assign('endform', $this->CreateFormEnd());

	$smarty->assign('feu_fftt', $this->CreateInputDropdown($id, 'feu_fftt',$OuiNon,-1,$this->GetPreference('feu_fftt')));
	$smarty->assign('feu_messages', $this->CreateInputDropdown($id, 'feu_messages',$OuiNon,-1,$this->GetPreference('feu_messages')));
	$smarty->assign('feu_inscriptions', $this->CreateInputDropdown($id, 'feu_inscriptions',$OuiNon,-1,$this->GetPreference('feu_inscriptions')));
	$smarty->assign('feu_contacts', $this->CreateInputDropdown($id, 'feu_contacts',$OuiNon,-1,$this->GetPreference('feu_contacts')));
	$smarty->assign('feu_presences', $this->CreateInputDropdown($id, 'feu_presences',$OuiNon,-1,$this->GetPreference('feu_presences')));
	$smarty->assign('feu_factures', $this->CreateInputDropdown($id, 'feu_factures',$OuiNon,-1,$this->GetPreference('feu_factures')));
	$smarty->assign('feu_commandes', $this->CreateInputDropdown($id, 'feu_commandes',$OuiNon,-1,$this->GetPreference('feu_fftt')));
	$smarty->assign('feu_compos', $this->CreateInputDropdown($id, 'feu_compos',$OuiNon,-1,$this->GetPreference('feu_compos')));

	$smarty->assign('submit', $this->CreateInputSubmit ($id, 'submit', $this->Lang('submit')));

	echo $this->ProcessTemplate('config.tpl');
}

#
#EOF
#
?>