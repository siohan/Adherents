<?php

if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db =& $this->GetDb();
global $themeObject;
$aujourdhui = date('Y-m-d');
$class_ops = new adherents_spid();
if(isset($params['obj']) && $params['obj'] != '')
{
	$obj = $params['obj'];
}
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
}
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
}
if(isset($params['email']) && $params['email'] != '')
{
	$email = $params['email'];
}
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
}
if(isset($params['nom']) && $params['nom'] != '')
{
	$nom = $params['nom'];
}
if(isset($params['prenom']) && $params['prenom'] != '')
{
	$prenom = $params['prenom'];
}

switch($obj)
{
	case "all":
		$adherents_spid = $class_ops->liste_adherents_spid();
	break;
	
	case "refresh" :
		$adherents_spid = $class_ops->infos_adherent_spid($licence);
		$this->RedirectToAdminTab('adherents');
	break;
	
	case "delete_contact" : 
		$del_contact = new contact();
		$adhrents_spid = $del_contact->delete_contact($record_id);
		$this->Redirect($id, 'view_contacts',$returnid, array("licence"=>$licence));
	break;
	case "send_another_email" :
	
		
		//on supprime le mot de passe précédent
		
		$email_ops = new email_notifications();
		$send = $email_ops->send_another_email($email,$licence,$nom,$prenom);
		if($send == TRUE)
		{
			$this->SetMessage('Email renvoyé avec succès');
		}
		else
		{
			$this->SetMessage('Email non envoyé');
		}
		$this->Redirect($id, 'defaultadmin',$returnid, array("active_tab"=>"feu"));
	break;
	
	case "refresh_all"  :
		$adherents_spid = $class_ops->refresh();
	break;
}

//$this->RedirectToAdminTab('adherents');

?>