<?php
if(!isset($gCms) ) exit;
//on établit les permissions
//debug_display($_POST, 'Parameters');
if(!$this->CheckPermission('Adherents prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('adherents');
}
if(isset($_POST['submit']))
{
	
	/*
	$designation= '';
	$module = \cms_utils::get_module('Ping');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_fftt', $_POST['pann_fftt']);
		
	}
	else
	{
		$this->SetPreference('pann_fftt', '0');
		$designation.=" Module Ping absent ou non activé !";
	}
	
	$module = \cms_utils::get_module('Messages');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_messages', $_POST['pann_messages']);
		
	}
	else
	{
		$this->SetPreference('pann_messages', '0');
		$designation.=" Module Messages absent ou non activé !";
	}
	*/
	$module = \cms_utils::get_module('Paiements');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_factures', $_POST['pann_factures']);
		
	}
	else
	{
		$this->SetPreference('pann_factures', '0');
		$designation.=" Module Paiements absent ou non activé !";
	}
	$module = \cms_utils::get_module('Cotisations');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_adhesions', $_POST['pann_adhesions']);		
	}
	else
	{
		$this->SetPreference('pann_adhesions', '0');
		$designation.=" Module Cotisations absent ou non activé !";
	}
	$module = \cms_utils::get_module('Commandes');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_commandes', $_POST['pann_commandes']);
		
	}
	else
	{
		$this->SetPreference('pann_commandes', '0');
		$designation.=" Module Commandes absent ou non activé !";
	}
	$module = \cms_utils::get_module('Inscriptions');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_inscriptions', $_POST['pann_inscriptions']);
	}
	else
	{
		$this->SetPreference('pann_inscriptions', '0');
		$designation.=" Module Inscriptions absent ou non activé !";
	}
	$module = \cms_utils::get_module('Presence');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_presences', $_POST['pann_presences']);
		
	}
	else
	{
		$this->SetPreference('pann_presences', '0');
		$designation.=" Module Presence absent ou non activé !";
	}
	$module = \cms_utils::get_module('Compositions');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_compos', $_POST['pann_compos']);
		
	}
	else
	{
		$this->SetPreference('pann_compos', '0');
		$designation.=" Module Compositions absent ou non activé !";
	}

//	$this->SetPreference('pann_contacts', $_POST['pann_contacts']);
	$designation.= "Config du panneau Adhérent modifiée";
	$this->SetMessage($designation);
	$this->RedirectToAdminTab('panneau');
}
else
{
	//debug_display($parms, 'Parameters');

	$smarty->assign('pann_fftt', $this->GetPreference('pann_fftt'));
//	$smarty->assign('pann_messages', $this->GetPreference('pann_messages'));
	$smarty->assign('pann_inscriptions', $this->GetPreference('pann_inscriptions'));
//	$smarty->assign('pann_contacts', $this->GetPreference('pann_contacts'));
	$smarty->assign('pann_presences', $this->GetPreference('pann_presences'));
	$smarty->assign('pann_factures', $this->GetPreference('pann_factures'));
	$smarty->assign('pann_commandes', $this->GetPreference('pann_commandes'));
	$smarty->assign('pann_compos', $this->GetPreference('pann_compos'));
	$smarty->assign('pann_adhesions', $this->GetPreference('pann_adhesions'));

	echo $this->ProcessTemplate('config_panneau.tpl');
}

#
#EOF
#
?>