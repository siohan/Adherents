<?php

if(!isset($gCms)) exit;
//on vérifie les permissions

$db =& $this->GetDb();
//debug_display($params, 'Parameters');

//$template = "";
if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
/*
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Adherents::Liste Adhérents');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template liste adhérents introuvable');
        return;
    }
    $template = $tpl->get_name();
}
*/

if(isset($params['group']) && $params['group'] != '')
{
	$group = $params['group'];
	$req = 1;
	$query = "SELECT adh.genid, adh.nom, adh.prenom FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.licence = be.licence AND be.id_group = ?";//" WHERE actif = 1";
}
else
{
	$req = 2;
	$query = "SELECT  adh.genid,  adh.nom, adh.prenom FROM ".cms_db_prefix()."module_adherents_adherents AS adh";
}



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
echo $query;
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
		/*
		foreach($tabExt as $value)
		{
			$right_extension = file_exists("../uploads/images/trombines/".$genid.".".$value);
			if(true == $right_extension)
			{
				//return $value; 
				$has_image = true;
				$myimage = "../uploads/images/trombines/".$genid.".".$value;
				echo $myimage;
			}
			else
			{
				$has_image = false;
			}
		}
		var_dump($has_image);
		//var_dump($has_image);
		if(true == $has_image)//file_exists("http://localhost:8888/1.0/uploads/images/trombines/".$genid.".jpg"))
		{
			$img = '<img src="'.$myimage.'" alt="ma trombine" width="24" height="24">';
			$onerow->thumb = $img;
		}
		else
		{
			$onerow->thumb = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'));
		}
		*/
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
/*
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
*/
//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('liste_adherents.tpl');

?>