<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Adherents use'))
{

	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$db =& $this->GetDb();
global $themeObject;

if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
}
else
{
	//on renvoie à une erreur
}
$rowarray= array();
$rowclass = '';
//on prépare un lien pour ajouetre un nouveau contact
$smarty->assign('add_edit_contact', $this->CreateLink($id, 'add_edit_contact', $returnid, $contents='Nouveau contact',array("licence"=>$licence)));
$query  = "SELECT id, licence, type_contact, contact, description FROM ".cms_db_prefix()."module_adherents_contacts WHERE licence = ?";
$dbresult = $db->Execute($query, array($licence));
if($dbresult)
{
	//la requete a fonctionné
	if($dbresult->RecordCount()>0)
	{
		//il y a des enregistrements !
		while($row = $dbresult->FetchRow())
		{
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->id = $row['id'];
			$onerow->type_contact = $row['type_contact'];
			$onerow->contact = $row['contact'];
			$onerow->description = $row['description'];
			$onerow->edit = $this->CreateLink($id, 'add_edit_contact',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array("licence"=>$licence, "edit"=>"1", "record_id"=>$row['id']) );
			$onerow->delete = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'),array("obj"=>"delete_contact","licence"=>$licence, "record_id"=>$row['id']) );
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
			
		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
	}
	else
	{
		echo 'Pas de contacts à afficher !';
	}
}
elseif(!$dbresult)
{
	echo $db->ErrorMsg();
}

//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('contacts.tpl');
?>