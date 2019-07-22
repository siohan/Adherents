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
//debug_display($params, 'Parameters');
//on va vérifier que les données du compte sont renseignées et le n° du club aussi.


$aujourdhui = date('Y-m-d');
//$ping = new Ping();
$act = 1;//par defaut on affiche les actifs (= 1 )
$shopping = '<img src="../modules/Adherents/images/shopping.jpg" class="systemicon" alt="Commandes" title="Commandes">';
$cotis = '<img src="../modules/Adherents/images/cotisations.png" class="systemicon" alt="Cotisations" title="Cotisations">';
$smarty->assign('shopping', $shopping);
$smarty->assign('cotis', $cotis);
$smarty->assign('inactifs',
		$this->CreateLink($id, 'defaultadmin', $returnid, 'Inactifs', array("actif"=>"0", "active_tab"=>"adherents")));
$smarty->assign('actifs',
				$this->CreateLink($id, 'defaultadmin', $returnid, 'Actifs', array("active_tab"=>"adherents")));
if($this->GetPreference('club_number') !="")
{
	$smarty->assign('chercher_adherents_spid',
					$this->CreateLink($id, 'chercher_adherents_spid', $returnid, $contents='Importer les adhérents depuis le Spid',array("obj"=>"all"),$warn_message='Attention, ce script est long (1 min) et peut provoquer une erreur, il faut patienter. Merci de patienter'));
}


if(isset($params['group']) && $params['group'] != '')
{
	$group = $params['group'];
	$req = 1;
	$query = "SELECT adh.id, adh.licence, adh.nom, adh.prenom, adh.actif,adh.genid, adh.anniversaire, adh.sexe, adh.certif, adh.validation, adh.adresse, adh.code_postal, adh.ville, adh.maj FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.licence = be.licence AND be.id_group = ?";//" WHERE actif = 1";
}
else
{
	$req = 2;
	$query = "SELECT id, genid, licence, nom, prenom, actif, anniversaire, sexe, certif, validation, adresse, code_postal, ville, maj FROM ".cms_db_prefix()."module_adherents_adherents AS adh";
}


if(isset($params['actif']) && $params['actif'] == 0)
{
	if($req == 1)
	{
		$query.=" AND adh.actif = 0";
	}
	else
	{
		$query.=" WHERE actif = 0";
	}
	
	$act = 0;
}
else
{
	if($req==1)
	{
		$query.=" AND adh.actif = 1";
	}
	else
	{
		$query.=" WHERE actif = 1";
	}
	$act = 1;
}
$query.=" ORDER BY adh.nom ASC ";
$smarty->assign('act', $act);
if($req == 1)
{
	$dbresult = $db->Execute($query,array($group));
}
else
{
	$dbresult = $db->Execute($query);	
}
$rowarray = array();
$rowclass = 'row1';
$contact_ops = new contact;
//$adh_ops = new adherents_spid;
if($dbresult && $dbresult->RecordCount() >0)
{
	$config = cmsms()->GetConfig();
	$base = $config['root_url'];
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$genid = $row['genid'];
		$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
		foreach($tabExt as $value)
		{
			$right_extension = file_exists("../uploads/images/trombines/".$genid.".".$value);
			if(true == $right_extension)
			{
				$has_image = true;
				$myimage = "../uploads/images/trombines/".$genid.".".$value;
			}
			else
			{
				$has_image = false;
			}
		}
		
		//var_dump($has_image);
		if(true == $has_image)//file_exists("http://localhost:8888/1.0/uploads/images/trombines/".$genid.".jpg"))
		{
			$img = '<img src="'.$myimage.'" alt="ma trombine" width="24" height="24">';
			$thumb = $this->CreateLink($id, 'upload_image', $returnid,$contents=$img, array("genid"=>$genid));
		}
		else
		{
			$thumb = $this->CreateLink($id, 'upload_image', $returnid,$contents=$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("genid"=>$genid));
		}
		$onerow->genid= $genid;
		
		$onerow->thumbnail = $thumb;
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		$actif= $row['actif'];
		if($actif == 1)
		{
			$onerow->actif = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"desactivate", "genid"=>$row['genid']));
		}
		else
		{
			$onerow->actif = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"activate", "genid"=>$row['genid']));
		}
		$onerow->sexe= $row['sexe'];
		$onerow->certif= $row['certif'];
		$onerow->date_validation = $row['validation'];
		$onerow->anniversaire = $row['anniversaire'];
		$onerow->adresse = $row['adresse'];
		$onerow->code_postal = $row['code_postal'];
		$onerow->ville = $row['ville'];
		$email = $contact_ops->has_email($row['genid']);
		//var_dump($email);
		if(TRUE === $email)
		{
			$onerow->has_email = $this->CreateLink($id, 'view_contacts', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("genid"=>$row['genid']));
		}
		elseif(FALSE === $email)
		{
			$onerow->has_email = $this->CreateLink($id, 'add_edit_contact', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("genid"=>$row['genid'], "type_contact"=>'1'));
		}
		$mobile = $contact_ops->has_mobile($row['genid']);
		if(TRUE === $mobile)
		{
			$onerow->has_mobile = $this->CreateLink($id, 'view_contacts', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("genid"=>$row['genid']));
		}
		elseif(FALSE === $mobile)
		{
			$onerow->has_mobile = $this->CreateLink($id, 'add_edit_contact', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("genid"=>$row['genid'], "type_contact"=>'2'));
		}
		$onerow->groups= $this->CreateLink($id, 'assign_groups', $returnid,$themeObject->DisplayImage('icons/system/groupassign.gif', $this->Lang('assign'), '', '', 'systemicon'),array("genid"=>$row['genid']));//$row['closed'];
		$onerow->edit = $this->CreateLink($id, 'edit_adherent',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array("record_id"=>$row['genid']));
		$onerow->view_contacts= $this->CreateLink($id, 'view_contacts', $returnid,$themeObject->DisplayImage('icons/topfiles/groupmembers.gif', $this->Lang('groupmembers'), '', '', 'systemicon'),array("genid"=>$row['genid']));//$row['closed'];
		
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
	$articles = array("Activer"=>"activate", "Désactiver"=>"desactivate");
	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
}
elseif(!$dbresult)
{
	echo $db->ErrorMsg();
}

//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('adherents.tpl');

?>