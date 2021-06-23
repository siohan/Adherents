<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$this->SetCurrentTab('emails');
//debug_display($params, 'Parameters');
if(isset($_POST['submit']))
{
	//on sauvegarde ! Ben ouais !
	$this->SetPreference('admin_email', $_POST['admin_email']);
	$this->SetPreference('email_activation_subject', $_POST['email_activation_subject']);	
	
	//on redirige !
	$this->SetMessage('paramètres enregistrés...');
	$this->RedirectToAdminTab();
}
else
{
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('notifications.tpl'), null, null, $smarty);
	$tpl->assign('email_activation_subject', $this->GetPreference('email_activation_subject'));
	$tpl->assign('admin_email', $this->GetPreference('admin_email'));
	$tpl->display();
}


#
# EOF
#
?>