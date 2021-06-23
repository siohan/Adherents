<?php
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Adherents use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('adherents');
}
//on prépare une navigation
$letter = '';
if(isset($params['letter']) && $params['letter'] !='')
{
	$letter = $params['letter'];
}

$query = "SELECT DISTINCT SUBSTRING(adh.nom, 1,1) AS letter FROM ".cms_db_prefix()."module_adherents_adherents AS adh ";//
if(isset($_POST['record_id']) && $_POST['record_id'] > 0)
{
	$record_id = $_POST['record_id'];
	$query.=", ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.genid = be.genid AND be.id_group = ? AND adh.actif = 1 GROUP BY adh.nom";
	$dbresult = $db->Execute($query, array($record_id));
}
else
{
	$query.= " WHERE adh.actif = 1 GROUP BY adh.nom";
	$dbresult = $db->Execute($query);
}
$rowarray= array();
if($dbresult && $dbresult->RecordCount() >0)
{
	$rowarray = array();
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->letter = $row['letter'];
		$rowarray[] = $onerow;
	}
}
$smarty->assign('letter', $letter);
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
//$smarty->assign('genid', $record_id);
echo $this->ProcessTemplate('navigation.tpl');
?>