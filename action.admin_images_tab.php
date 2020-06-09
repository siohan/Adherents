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
	
	$this->SetMessage('Paramètres enregistrés...');
	$this->RedirectToAdminTab('images');
}
else
{
	//debug_display($parms, 'Parameters');
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('admin_images.tpl', null, null, $smarty));
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