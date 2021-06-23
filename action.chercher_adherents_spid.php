<?php
set_time_limit(300);
if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params,'Parameters');
$db =cmsms()->GetDb();
global $themeObject;
$aujourdhui = date('Y-m-d');
$class_ops = new Asso_adherents;
$ass_ops = new AdherentsFeu;
$group_ops = new groups;
$feu = cms_utils::get_module('FrontEndUsers');
//$feu_ops = new FrontEndUsersManipulator;
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
if(isset($params['genid']) && $params['genid'] != '')
{
	$genid = $params['genid'];
}
if(isset($params['nom']) && $params['nom'] != '')
{
	$nom = str_replace(" ","",$params['nom']);
}
if(isset($params['prenom']) && $params['prenom'] != '')
{
	$prenom = str_replace(" ", "",$params['prenom']);
}


switch($obj)
{

	
	case "delete_contact" : 
		$del_contact = new contact;
		$adhrents_spid = $del_contact->delete_contact($record_id);
		$this->Redirect($id, 'view_adherent_details',$returnid, array("record_id"=>$genid));
	break;
	case "delete_user_feu" :
		//cms_utils::get_module('FrontEndUsers');
		//on récupére le id de l'utilisateur
		$id = $params['genid'];//$feu->GetUserInfoByProperty('genid',$genid);
		var_dump($id);
		$supp_user = $feu->DeleteUserFull($id);
		
		
		$this->RedirectToAdminTab('feu');
	break;
		
	
	case "delete_user_from_group" :
		$supp_user_from_group = $group_ops->delete_user_from_group($record_id,$genid);
		if(FALSE === $supp_user_from_group)
		{
			$this->SetMessage('Erreur : Adhérent non supprimé du groupe');
		}
		else
		{
			$this->SetMessage('Adhérent supprimé du groupe');
		}
		$this->Redirect($id, 'view_group_users', $returnid, array("group"=>$record_id));
	break;
	case "delete_group" :
		$del_group = $group_ops->delete_group($record_id);
		$del_group_belongs = $group_ops->delete_group_belongs($record_id);
		$this->Redirect($id, 'defaultadmin',$returnid, array("active_tab"=>"group"));
	break;
	
	case "activate" :
		$class_ops->activate($genid);
		$uid = $ass_ops->GetUserInfoByProperty($genid);
		var_dump($uid);
		$feu->SetUserDisabled($uid,$state=0);
		//$group_ops->assign_to_adherent($genid);
		$this->SetMessage('Adhérent activé');
		$this->Redirect($id, 'defaultadmin', $returnid);
	break;
	
	case "desactivate" : 
		$class_ops->desactivate($genid);
		$uid = $ass_ops->GetUserInfoByProperty($genid);
		$feu->SetUserDisabled($uid,$state=1);
		//$group_ops->delete_user_from_all_groups($genid);
		//$group_ops->delete_user_feu($genid);
		$this->SetMessage('Adhérent désactivé');//, retiré de tous les groupes et accès espace privé supprimé');
		$this->Redirect($id, 'defaultadmin', $returnid);
	break;
	
	case "suppr" :
	{
		
	}
	
	//Active un groupe
	case "activate_group" :
	{
		$group_ops->activate_group($record_id);
		$this->SetMessage('Groupe activé');
		$this->Redirect($id, 'view_group_details', $returnid, array("active_tab"=>"groups", "group"=>$record_id));
	}
	//Désactive un groupe
	case "desactivate_group" :
	{
		$group_ops->desactivate_group($record_id);
		$this->SetMessage('Groupe désactivé, non public, tags effacés');
		$$this->Redirect($id, 'view_group_details', $returnid, array("active_tab"=>"groups", "group"=>$record_id));
	}
	//Publie : rend un groupe public ->tag à prévoir en conséquence
	case "publish_group" :
	{
		$pub_group = $group_ops->publish_group($record_id);
		if(true == $pub_group)
		{
			$message = "Groupe publié.";
			$crea_tag = $group_ops->create_tag($record_id);
			if(true == $crea_tag)
			{
				$message.=" Tag créé (voir détails).";
			}
			else
			{
				$message.="Tag non créé !";
			}
		}
		else
		{
			$message = "Erreur ! Le groupe n'est pas public !";
		}
		$this->SetMessage($message);
		$this->Redirect($id, 'view_group_details', $returnid, array("active_tab"=>"groups", "group"=>$record_id));
	}
	
	//dépublie un groupe et supprime le tag en conséquence
	case "unpublish_group" :
	{
		$unpub_group = $group_ops->unpublish_group($record_id);
		if(true == $unpub_group)
		{
			$message = "Groupe rendu non public. ";
			$del_tag = $group_ops->delete_tag($record_id);
			if(true == $del_tag)
			{
				$message.= "Tag effacé";
			}
			else
			{
				$message.= "Tag non effacé";
			}
		}
		else
		{
			$message = "Erreur ! Le groupe est toujours public !";
		}
		$this->SetMessage($message);
		$this->Redirect($id, 'view_group_details', $returnid, array("active_tab"=>"groups", "group"=>$record_id));
	}
	
	//Permet l'auto-enregistrement des utilisateurs avec génération d'un tag
	case "ok_auto" :
	{
		$ok_auto = $group_ops->ok_auto($record_id);
		if(true == $ok_auto)
		{
			$message = "Auto-enregistrement autorisé. ";
			$crea_tag = $group_ops->create_tag_auto($record_id);
			if(true == $crea_tag)
			{
				$message.= "Tag auto-enregistrement créé (voir détails)";
			}
			else
			{
				$message.= "Tag auto-enregistrement non créé !!";
			}
		}
		else
		{
			$message = "Erreur ! L'auto-enregistrement n'a pas fonctionné !";
		}
		$this->SetMessage($message);
		$this->Redirect($id, 'view_group_details', $returnid, array("active_tab"=>"groups", "group"=>$record_id));
	}
	
	//empeche l'auto-enregistrement dans un groupe
	//Permet l'auto-enregistrement des utilisateurs avec génération d'un tag
	case "ko_auto" :
	{
		$ko_auto = $group_ops->ko_auto($record_id);
		if(true == $ko_auto)
		{
			$message = "Auto-enregistrement non autorisé. ";
			$del_tag = $group_ops->delete_tag_auto($record_id);
			if(true == $del_tag)
			{
				$message.= "Tag auto-enregistrement supprimé";
			}
			else
			{
				$message.= "Tag auto-enregistrement non supprimé !!";
			}
		}
		else
		{
			$message = "Erreur ! L'auto-enregistrement n'a pas fonctionné !";
		}
		$this->SetMessage($message);
		$this->Redirect($id, 'view_group_details', $returnid, array("active_tab"=>"groups", "group"=>$record_id));
	}
	case "admin_valid" :
	{
		if(isset($params['valid']) && $params['valid'] != '')
		{
			$valid = $params['valid'];
		}
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$admin_valid = $group_ops->set_admin_valid($record_id, $valid);
		$this->Redirect($id, 'view_group_details', $returnid, array("active_tab"=>"groups", "group"=>$record_id));
	}
}

//$this->RedirectToAdminTab('adherents');

?>
