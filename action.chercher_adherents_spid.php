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
$group_ops = new groups();
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
		//var_dump($adherents_spid);
		if(TRUE === $adherents_spid)
		{
			$this->SetMessag('Adhérent(s) inséré(s)');
		}
		else
		{
			$this->SetMessag('Erreur');
		}
		
		$this->RedirectToAdminTab('adherents');
	break;
	
	case "refresh" :
		$adherents_spid = $class_ops->infos_adherent_spid($licence);
		if(true === $adherents_spid )
		{
			$this->SetMessage('Joueur mis à jour');
		}
		else
		{
			$this->SetMessage('Joueur inactif ou erreur');
		}
		$this->RedirectToAdminTab('adherents');
	break;
	
	case "delete_contact" : 
		$del_contact = new contact();
		$adhrents_spid = $del_contact->delete_contact($record_id);
		$this->Redirect($id, 'view_contacts',$returnid, array("licence"=>$licence));
	break;
	case "delete_user_feu" :
		$feu = cms_utils::get_module('FrontEndUsers');
		//on récupére le id de l'utilisateur
		$id = $feu->GetUserId($licence);
		$supp_user = $feu->DeleteUserFull($id);
		
		$this->RedirectToAdminTab('feu');
	break;
	case "send_another_email" :
	
		
		//on supprime le mot de passe précédent
		
		//maintenant, on le recréé !
		$day = date('j');
		$month = date('n');
		$year = date('Y')+5;
		$expires = mktime(0,0,0,$month, $day,$year);
		//on créé un mot de passe
		$mot1 = $this->random_string(8);
		$motdepasse = $mot1.'1';
		//qqs variables pour le mail
		$smarty->assign('prenom_joueur', $prenom);
		$smarty->assign('nom_joueur' , $nom);
		$smarty->assign('licence', $licence);
		//$motdepasse = 'UxzqsUIM1';
		$smarty->assign('motdepasse', $motdepasse);

		//$add_user = $feu->AddUser($licence, $motdepasse,$expires);
		$add_user = $feu->AddUser($licence, $motdepasse,$expires);

		//on récupère le userid ($uid)
		$uid = $feu->GetUserId($licence);
		//on force le changement de mot de passe ?
		$feu->ForcePasswordChange($uid, $flag = TRUE);	
		$gid = $feu->GetGroupId('adherents');
		/* on peut maintenant assigner cet utilisateur au groupe */
		$feu->AssignUserToGroup($uid,$gid);
		/* on remplit les propriétés de lutilisateur */
		$feu->SetUserPropertyFull('email',$user_email, $uid);
		$feu->SetUserPropertyFull('nom', $nom_complet,$uid);

		/* On essaie d'envoyer un message à l'utilisateur pour lui dire qu'il est enregistré */	

		$admin_email = $this->GetPreference('admin_email'); 
		//echo $to;
		$subject = $this->GetPreference('email_activation_subject');
		$message = $this->GetTemplate('newactivationemail_Sample');
		$body = $this->ProcessTemplateFromData($message);
		$headers = "From: ".$admin_email."\n";
		$headers .= "Reply-To: ".$admin_email."\n";
		$headers .= "Content-Type: text/html; charset=\"utf-8\"";
		/*
		$headers = 'From: claude.siohan@gmail.com' . "\r\n" . 'Reply-To: claude.siohan@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
		*/
		$designation.= 'Compte actif pour '.$prenom;
		if(mail($user_email, utf8_encode($subject), $body, $headers))
		{

			$designation.= ' Email envoyé !';

		}
		
		$this->Redirect($id, 'defaultadmin',$returnid, array("active_tab"=>"feu"));
	break;
	
	case "refresh_all"  :
		$adherents_spid = $class_ops->refresh();
		$this->RedirectToAdminTab('adherents');
	break;
	case "delete_user_from_group" :
		$supp_user_from_group = $group_ops->delete_user_from_group($record_id,$licence);
		if(FALSE === $supp_user_from_group)
		{
			$this->SetMessage('Erreur : Adhérent non supprimé du groupe');
		}
		else
		{
			$this->SetMessage('Adhérent supprimé du groupe');
		}
		$this->Redirect($id, 'view_group_users', $returnid, array("active_tab"=>"feu"));
	break;
	case "delete_group" :
		$del_group = $group_ops->delete_group($record_id);
		$del_group_belongs = $group_ops->delete_group_belongs($record_id);
		$this->Redirect($id, 'defaultadmin',$returnid, array("active_tab"=>"group"));
	break;
}

//$this->RedirectToAdminTab('adherents');

?>