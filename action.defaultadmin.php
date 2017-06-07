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
//	echo $this->SetTabHeader('feu', 'Espace privé' , ('feu' == $tab)?true:false);
//	echo $this->SetTabHeader('email', 'Emails' , ('email' == $tab)?true:false);
	echo $this->SetTabHeader('compte', 'Compte' , ('compte' == $tab)?true:false);


echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	
	echo $this->StartTab('adherents', $params);
    	include(dirname(__FILE__).'/action.admin_adherents_tab.php');
   	echo $this->EndTab();

	/*
	echo $this->StartTab('feu', $params);
    	include(dirname(__FILE__).'/action.admin_feu_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('email', $params);
    	include(dirname(__FILE__).'/action.admin_emails_tab.php');
   	echo $this->EndTab();
	*/
	echo $this->StartTab('compte' , $params);
	include(dirname(__FILE__).'/action.admin_compte_tab.php');
	echo $this->EndTab();

echo $this->EndTabContent();
//on a refermé les onglets
?>