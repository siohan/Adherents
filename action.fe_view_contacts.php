<?php
if( !isset($gCms) ) exit;
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
$smarty->assign('genid', $username);
//global $themeObject;

require_once(dirname(__FILE__).'/include/fe_menu.php');

$db =& $this->GetDb();
global $themeObject;

if(isset($params['record_id']) && $params['record_id'] != '' && $params['record_id'] == $username)
{
	$licence = $params['record_id'];
}
else
{
	//on renvoie à une erreur
	$this->SetMessage('Erreur !');
//	$this->Redirect($id, 'default', $returnid, array("record_id"=>$username));
}
$rowarray= array();
$rowclass = '';
//on prépare un lien pour ajouetre un nouveau contact

$query  = "SELECT id, genid, type_contact, contact, description FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ?";
$dbresult = $db->Execute($query, array($username));
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
			$onerow->edit = $this->CreateLink($id, 'fe_add_edit_contact',$returnid,'Modifier',array("genid"=>$row['genid'], "edit"=>"1", "record_id"=>$row['id']) );
			$onerow->delete = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,'Supprimer',array("obj"=>"delete_contact","genid"=>$row['genid'], "record_id"=>$row['id']) );
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
echo $this->ProcessTemplate('fe-contacts.tpl');
?>