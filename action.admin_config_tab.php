<?php
if(!isset($gCms) ) exit;
//on établit les permissions
//debug_display($_POST, 'Parameters');
if(!$this->CheckPermission('Adherents Set Prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('adherents');
}
if(isset($_POST['submit']))
{
	$designation= '';
	$module = \cms_utils::get_module('Ping');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_messages', $_POST['feu_messages']);
		
	}
	else
	{
		$this->SetPreference('feu_messages', '0');
		$designation.=" Module Messages absent ou non activé !";
	}
	$module = \cms_utils::get_module('Paiements');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_factures', $_POST['feu_factures']);
		
	}
	else
	{
		$this->SetPreference('feu_factures', '0');
		$designation.=" Module Paiements absent ou non activé !";
	}
	$module = \cms_utils::get_module('Commandes');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_commandes', $_POST['feu_commandes']);
		
	}
	else
	{
		$this->SetPreference('feu_commandes', '0');
		$designation.=" Module Commandes absent ou non activé !";
	}
	$module = \cms_utils::get_module('Inscriptions');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_inscriptions', $_POST['feu_inscriptions']);
		
	}
	else
	{
		$this->SetPreference('feu_inscriptions', '0');
		$designation.=" Module Inscriptions absent ou non activé !";
	}
	$module = \cms_utils::get_module('Presence');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_presences', $_POST['feu_presences']);
		
	}
	else
	{
		$this->SetPreference('feu_presences', '0');
		$designation.=" Module Presence absent ou non activé !";
	}
	$module = \cms_utils::get_module('Compositions');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_compos', $_POST['feu_compos']);
		
	}
	else
	{
		$this->SetPreference('feu_compos', '0');
		$designation.=" Module Compositions absent ou non activé !";
	}

	$this->SetPreference('feu_contacts', $_POST['feu_contacts']);
	$designation.= "Config modifiée";
	$this->SetMessage($designation);
	$this->RedirectToAdminTab('config');
}
else
{
	//debug_display($parms, 'Parameters');

	$smarty->assign('feu_fftt', $this->GetPreference('feu_fftt'));
	$smarty->assign('feu_messages', $this->GetPreference('feu_messages'));
	$smarty->assign('feu_inscriptions', $this->GetPreference('feu_inscriptions'));
	$smarty->assign('feu_contacts', $this->GetPreference('feu_contacts'));
	$smarty->assign('feu_presences', $this->GetPreference('feu_presences'));
	$smarty->assign('feu_factures', $this->GetPreference('feu_factures'));
	$smarty->assign('feu_commandes', $this->GetPreference('feu_fftt'));
	$smarty->assign('feu_compos', $this->GetPreference('feu_compos'));

	echo $this->ProcessTemplate('config.tpl');
}

#
#EOF
#
?>