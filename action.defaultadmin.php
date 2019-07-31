<?php
   if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Adherents use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
//	debug_display($params, 'Parameters');

echo $this->StartTabheaders();
if (FALSE == empty($params['active_tab']))
  {
    $tab = $params['active_tab'];
  } else {
  $tab = 'Adherents';
 }	
	echo $this->SetTabHeader('adherents', 'Adhérents', ('adherents' == $tab)?true:false);
	echo $this->SetTabHeader('groups', 'Groupes', ('groups' == $tab)?true:false);
	echo $this->SetTabHeader('feu', 'Espace privé' , ('feu' == $tab)?true:false);
	echo $this->SetTabHeader('email', 'Emails' , ('email' == $tab)?true:false);
if ($this->CheckPermission('Adherents prefs'))
{
	echo $this->SetTabHeader('config', 'Config' , ('config' == $tab)?true:false);
//	echo $this->SetTabHeader('compte', 'FFTT' , ('compte' == $tab)?true:false);
}


echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	
	echo $this->StartTab('adherents', $params);
    	include(dirname(__FILE__).'/action.admin_adherents_tab.php');
   	echo $this->EndTab();


	echo $this->StartTab('groups', $params);
    	include(dirname(__FILE__).'/action.admin_groups_tab.php');
   	echo $this->EndTab();

	/**/
	echo $this->StartTab('feu', $params);
    	include(dirname(__FILE__).'/action.admin_feu_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('email', $params);
    	include(dirname(__FILE__).'/action.admin_emails_tab.php');
   	echo $this->EndTab();
/*	*/
if ($this->CheckPermission('Adherents prefs'))
{
	echo $this->StartTab('config' , $params);
	include(dirname(__FILE__).'/action.admin_config_tab.php');
	echo $this->EndTab();
}	

echo $this->EndTabContent();
//on a refermé les onglets
?>