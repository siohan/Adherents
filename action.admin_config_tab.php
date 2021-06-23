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
	if(isset($_POST['pageid_subscription']) && $_POST['pageid_subscription'] != '')
	{
		$this->SetPreference('pageid_subscription', $_POST['pageid_subscription']);
	}
	
	$this->SetPreference('admin_email', $_POST['admin_email']);
	$this->SetPreference('email_activation_subject', $_POST['email_activation_subject']);
	
	$designation= '';
	$module = \cms_utils::get_module('Ping');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_fftt', $_POST['feu_fftt']);
		
	}
	else
	{
		$this->SetPreference('feu_fftt', '0');
		$designation.=" Module Ping absent ou non activé !";
	}
	$module = \cms_utils::get_module('Messages');
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
	$module = \cms_utils::get_module('Cotisations');
	if( is_object( $module ) )
	{
		$this->SetPreference('feu_adhesions', $_POST['feu_adhesions']);		
	}
	else
	{
		$this->SetPreference('feu_adhesions', '0');
		$designation.=" Module Cotisations absent ou non activé !";
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
	
	//pour le panneau Adhérent
	
	$module = \cms_utils::get_module('Paiements');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_paiements', $_POST['pann_paiements']);		
	}
	else
	{
		$this->SetPreference('pann_paiements', '0');
		$designation.=" Module Paiements absent ou non activé !";
	}
	$module = \cms_utils::get_module('Cotisations');
	if( is_object( $module ) )
	{
		$this->SetPreference('pann_cotisations', $_POST['pann_cotisations']);		
	}
	else
	{
		$this->SetPreference('pann_cotisations', '0');
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
	
	//pour le réglage des images
	$max_size = '500000';
	if( isset($_POST['max_size']) && $_POST['max_size'] !='')
	{
		$this->SetPreference('max_size', (int) $_POST['max_size']);		
	}
	$max_width = '800';
	if( isset($_POST['max_width']) && $_POST['max_width'] !='')
	{
		$this->SetPreference('max_width', (int) $_POST['max_width']);		
	}
	$max_height = '800';
	if( isset($_POST['max_height']) && $_POST['max_height'] !='')
	{
		$this->SetPreference('max_height', (int) $_POST['max_height']);		
	}
	$allowed_extensions = 'jpg, gif, jpeg, png';
	if( isset($_POST['allowed_extensions']) && $_POST['allowed_extensions'] !='')
	{
		$this->SetPreference('allowed_extensions', str_replace(' ', '', $_POST['allowed_extensions']));		
	}
	
	$designation.= "Config modifiée";
	$this->SetMessage($designation);
	$this->RedirectToAdminTab('config');
}
else
{
	//debug_display($parms, 'Parameters');
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('config.tpl'), null, null, $smarty);
	
	$tpl->assign('pageid_subscription', $this->GetPreference('pageid_subscription'));
	$tpl->assign('admin_email', $this->GetPreference('admin_email'));
	$tpl->assign('email_activation_subject', $this->GetPreference('email_activation_subject'));
	
	$tpl->assign('feu_fftt', $this->GetPreference('feu_fftt'));
	$tpl->assign('feu_messages', $this->GetPreference('feu_messages'));
	$tpl->assign('feu_inscriptions', $this->GetPreference('feu_inscriptions'));
	$tpl->assign('feu_contacts', $this->GetPreference('feu_contacts'));
	$tpl->assign('feu_presences', $this->GetPreference('feu_presences'));
	$tpl->assign('feu_factures', $this->GetPreference('feu_factures'));
	$tpl->assign('feu_commandes', $this->GetPreference('feu_commandes'));
	$tpl->assign('feu_compos', $this->GetPreference('feu_compos'));
	$tpl->assign('feu_adhesions', $this->GetPreference('feu_adhesions'));
	
	
	$tpl->assign('pann_commandes', $this->GetPreference('pann_commandes'));
	$tpl->assign('pann_inscriptions', $this->GetPreference('pann_inscriptions'));
	$tpl->assign('pann_presences', $this->GetPreference('pann_presences'));
	$tpl->assign('pann_paiements', $this->GetPreference('pann_paiements'));	
	$tpl->assign('pann_compos', $this->GetPreference('pann_compos'));
	$tpl->assign('pann_cotisations', $this->GetPreference('pann_cotisations'));
	
	
	//pour le réglage des images
	
	$tpl->assign('max_size', $this->GetPreference('max_size'));
	$tpl->assign('max_width', $this->GetPreference('max_width'));
	$tpl->assign('max_height', $this->GetPreference('max_height'));
	$tpl->assign('allowed_extensions', $this->GetPreference('allowed_extensions'));

	$tpl->display();
}

#
#EOF
#
?>