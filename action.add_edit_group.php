<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Adherents use'))
{
    	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

if( isset($params['cancel']) )
{
    	$this->RedirectToAdminTab('adherents');
    	return;
}
$db =& $this->GetDb();
//debug_display($params, 'Parameters');
if(!empty($_POST))
{
	if(isset($_POST['cancel']))
	{
		$this->Redirect($id, 'defaultadmin', $returnid);
	}
	//debug_display($_POST, 'Parameters');
	$error = 0;
	$message = '';
	$edit = 0;
	if (isset($_POST['record_id']) && $_POST['record_id'] !='')
	{
		$record_id = $_POST['record_id'];
		$edit = 1;
	}
	if(isset($_POST['nom']) && $_POST['nom'] != '')
	{
		$nom = $_POST['nom'];
	}
	else
	{
		$error++;
		$message.=" Donnez un nom à votre groupe !";
	}
	$description = '';
	if(isset($_POST['description']) && $_POST['description'] != '')
	{
		$description = $_POST['description'];
	}
	if(isset($_POST['actif']) && $_POST['actif'] != '')
	{
		$actif = $_POST['actif'];
	}
	$public = 0;
	if(isset($_POST['public']) && $_POST['public'] != '')
	{
		$public = $_POST['public'];
	}
	$auto_subscription = 0;
	if(isset($_POST['auto_subscription']) && $_POST['auto_subscription'] != '')
	{
		$auto_subscription = $_POST['auto_subscription'];
	}
	$admin_valid = 1;
	if(isset($_POST['admin_valid']) && $_POST['admin_valid'] != '')
	{
		$admin_valid = $_POST['admin_valid'];
	}
	$pageid_aftervalid = '';
	if(isset($_POST['pageid_aftervalid']) && $_POST['pageid_aftervalid'] != '')
	{
		$pageid_aftervalid = $_POST['pageid_aftervalid'];
	}
	
	if($error < 1)
	{
		$gp_ops = new groups;
		if($edit == 0)
		{
			$add_gp = $gp_ops->add_group($nom, $description, $actif, $public, $auto_subscription, $admin_valid,$pageid_aftervalid);
			if(true == is_int($add_gp) && $public == 1)
			{
				$gp_ops->create_tag($add_gp);
			}
			if(true ==is_int($add_gp) && $auto_subscription == 1)
			{
				$gp_ops->create_tag_auto($add_gp);
			}
			
		}
		else
		{
			$edit_gp = $gp_ops->edit_group($nom, $description, $actif, $public,$auto_subscription, $admin_valid,$pageid_aftervalid, $record_id);
			if($public == 1)
			{
				$gp_ops->create_tag($record_id);
			}
			else
			{
				$gp_ops->delete_tag($record_id);
			}
			if(true == $auto_subscription)
			{
				$gp_ops->create_tag_auto($record_id);
			}
			
		}
	}
	else
	{
		$this->SetMessage($message);
	}
	$this->RedirectToAdminTab('groups');
}
else
{
	
	//s'agit-il d'une modif ou d'une créa ?
	$record_id = '';
	
	$nom = '';
	$description = '';
	$actif = 0;
	$edit = 0;
	$public = 0;
	$auto_subscription = 0;
	$admin_valid = 0;
	$tag = '';
	$tag_subscription = '';
	$pageid_aftervalid = '';

	if(isset($params['record_id']) && $params['record_id'] !="")
	{
			$record_id = $params['record_id'];
			$edit = 1;//on est bien en trai d'éditer un enregistrement
			//ON VA CHERCHER l'enregistrement en question
			$query = "SELECT * FROM ".cms_db_prefix()."module_adherents_groupes WHERE id = ?";
			$dbresult = $db->Execute($query, array($record_id));
			$compt = 0;
			while ($dbresult && $row = $dbresult->FetchRow())
			{
				$compt++;
				$id = $row['id'];
				$nom = $row['nom'];
				//$commande_number = $row['commande_number'];
				$description = $row['description'];
				$actif = $row['actif'];
				$public = $row['public'];
				$auto_subscription = $row['auto_subscription'];
				$admin_valid = $row['admin_valid'];
				$tag = $row['tag'];
				$tag_subscription = $row['tag_subscription'];
				$pageid_aftervalid = $row['pageid_aftervalid'];

			}
	}
		

		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_edit_group.tpl'), null, null, $smarty);
		$tpl->assign('record_id', $record_id);
		$tpl->assign('nom', $nom);
		$tpl->assign('description', $description);
		$tpl->assign('actif', $actif);
		$tpl->assign('public', $public);
		$tpl->assign('auto_subscription', $auto_subscription);
		$tpl->assign('admin_valid', $admin_valid);
		$tpl->assign('tag', $tag);
		$tpl->assign('tag_subscription', $tag_subscription);
		$tpl->assign('pageid_aftervalid', $pageid_aftervalid);
		$tpl->display();
}

#
# EOF
#
?>
