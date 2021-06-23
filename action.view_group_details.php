<?php

if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$gp_ops = new groups;
$feu = cms_utils::get_module('FrontEndUsers');
$rowclass = 'row1';
$query = "SELECT id,nom, description, actif, public, auto_subscription, tag, tag_subscription FROM ".cms_db_prefix()."module_adherents_groupes WHERE id = ?";
$dbresult = $db->Execute($query, array($params['group']));
if($dbresult && $dbresult->RecordCount() >0)
{
	while($row = $dbresult->FetchRow())
	{
	
		$onerow2 = new StdClass();
		$onerow2->rowclass = $rowclass;
		$smarty->assign('nom', $row['nom']);
		$smarty->assign('description', $row['description']);
		$smarty->assign('actif', $row['actif']);
		$smarty->assign('id', $row['id']);
		$smarty->assign('public', $row['public']);
		$smarty->assign('tag', $row['tag']);
		$smarty->assign('tag_subscription', $row['tag_subscription']);
		$onerow2->auto_subscription = $row['auto_subscription'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray2[]= $onerow2;
	}
	$smarty->assign('itemsfound2', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount2', count($rowarray2));
	$smarty->assign('items2', $rowarray2);
}

$query = "SELECT adh.id, adh.genid, adh.licence, adh.nom, adh.prenom, adh.actif, adh.anniversaire, adh.sexe, adh.certif, adh.validation, adh.adresse, adh.code_postal, adh.ville FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.genid = be.genid";//" AND be.id_group = ?";//" WHERE actif = 1";
if(isset($params['group']) && $params['group'] != '')
{
	$group = $params['group'];
	$details = $gp_ops->details_groupe($group);
	$group = $params['group'];
	$admin_valid = $details['admin_valid'];
	$smarty->assign('admin_valid', $admin_valid);
	$query.=" AND be.id_group = ?";
}
else
{
	//un groupe doit être précisé
	$this->SetMessage('Un groupe doit être précisé !');
	$this->RedirectToAdminTab('groupes');
}

$query.=" AND adh.actif = 1 ORDER BY adh.nom ASC ";
$dbresult = $db->Execute($query,array($group));

$rowarray = array();
$rowclass = 'row1';
if($dbresult && $dbresult->RecordCount() >0)
{
	$contact_ops = new contact();
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->genid= $row['genid'];
		$actif = $row['actif'];
		$genid = (int) $row['genid'];
		$user_exists = false;
		
		
		$has_email = $contact_ops->has_email($row['genid']);
		if(TRUE === $has_email)
		{
			$onerow->has_email = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('delete'), '', '', 'systemicon');
		}
		else
		{
			$onerow->has_email = $this->CreateLink($id, 'add_edit_contact', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('delete'), '', '', 'systemicon'), array("genid"=>$row['genid']));
		}
		$mobile = $contact_ops->has_mobile($row['genid']);
		if(TRUE === $mobile)
		{
			$onerow->has_mobile = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
		}
		elseif(FALSE === $mobile)
		{
			$onerow->has_mobile = $this->CreateLink($id, 'add_edit_contact', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("genid"=>$row['genid']));
		}
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		if($actif == 1)
		{
			$onerow->actif= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
		}
		else
		{
			$onerow->actif= $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon');
		}
		
		$onerow->deletefromgroup = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array("obj"=>"delete_user_from_group","genid"=>$row['genid'], "record_id"=>$group));
		
		
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
		
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	
	$smarty->assign('form2start',
			$this->CreateFormStart($id,'mass_action',$returnid));
	$smarty->assign('form2end',
			$this->CreateFormEnd());
	$articles = array("Envoyer un email"=>"email", "Envoyer un SMS"=>"sms");
	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
	
}
elseif(!$dbresult)
{
	echo $db->ErrorMsg();
	echo 'pb';
}

//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('view_group_details.tpl');

?>
