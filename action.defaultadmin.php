<?php
   if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Adherents use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
//	debug_display($params, 'Parameters');

echo $this->StartTabheaders();
$active_tab = !empty($params['active_tab']) ? $params['active_tab']: 'adherents';
  	
	echo $this->SetTabHeader('adherents', 'Adhérents', ($active_tab == 'adherents')?true:false);
	echo $this->SetTabHeader('groups', 'Groupes', ($active_tab == 'groups')?true:false);
	
if ($this->CheckPermission('Adherents prefs'))
{
	echo $this->SetTabHeader('config', 'Config' , ($active_tab == 'config')?true:false);
}


echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	
	echo $this->StartTab('adherents', $params);
    	include(dirname(__FILE__).'/action.admin_adherents_tab.php');
   	echo $this->EndTab();


	echo $this->StartTab('groups', $params);
    	include(dirname(__FILE__).'/action.admin_groups_tab.php');
   	echo $this->EndTab();

if ($this->CheckPermission('Adherents prefs'))
{

	echo $this->StartTab('config' , $params);
	include(dirname(__FILE__).'/action.admin_config_tab.php');
	echo $this->EndTab();
}	

echo $this->EndTabContent();
//on a refermé les onglets
?>