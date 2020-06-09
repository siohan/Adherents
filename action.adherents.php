<?php

if(!isset($gCms)) exit;
//on vérifie les permissions

$db =& $this->GetDb();
//debug_display($params, 'Parameters');
$gp_ops = new groups;
//$template = "";
if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Adherents::liste_adherents');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template liste adhérents introuvable');
        return;
    }
    $template = $tpl->get_name();
}

if(isset($params['record_id']) && $params['record_id'] != '')
{
	$group = (int) $params['record_id'];
	//on vérifie si la liste est publique
	$details = $gp_ops->details_groupe($group);
	$public = $details['public'];
	
	$smarty->assign('nom_liste', $details['nom']);
	
	$req = 1;
	$query = "SELECT adh.genid, adh.nom, adh.prenom, adh.image FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.genid = be.genid AND be.id_group = ? ";//" WHERE actif = 1";
}
else
{
	$req = 2;
	$query = "SELECT  adh.genid,  adh.nom, adh.prenom,adh.image FROM ".cms_db_prefix()."module_adherents_adherents AS adh";
}

if(true == $public)
{
	if($req==1)
	{
		$query.=" AND adh.actif = 1";
	}
	else
	{
		$query.=" WHERE adh.actif = 1";
	}
	$act = 1;

$query.=" ORDER BY adh.nom ASC ";
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
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
if($dbresult && $dbresult->RecordCount() >0)
{
	
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$genid = $row['genid'];
		$image = $row['image'];
		$separator = ".";
		
		
		
		if($image !='')
		{
			$myimage = $config['root_url']."/uploads/images/trombines/".$genid.$separator.$image;
			
			$img = '<img src="'.$myimage.'" alt="ma trombine" width="24" height="24">';
			$onerow->thumb = $img;
		}
		else
		{
			$myimage = $config['root_url']."/assets/modules/Adherents/images/no-image.png";
			$img = '<img src="'.$myimage.'" alt="ma trombine" width="24" height="24">';
			$onerow->thumb = $img;
		}
		
	
		$onerow->genid= $row['genid'];
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];	
	//	$onerow->sexe= $row['sexe'];
		//$onerow->groups= $this->CreateLink($id, 'assign_groups', $returnid,$themeObject->DisplayImage('icons/system/groupassign.gif', $this->Lang('assign'), '', '', 'systemicon'),array("genid"=>$row['genid']));//$row['closed'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
		
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
}
elseif(!$dbresult)
{
	echo $db->ErrorMsg();
}

$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
}
else
{
	echo "Cette liste n'est pas publique...";
}
	

?>