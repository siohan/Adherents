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
$aujourdhui = date('Y-m-d');
//$ping = new Ping();
$act = 1;//par defaut on affiche les actifs (= 1 )
$shopping = '<img src="../modules/Adherents/images/shopping.jpg" class="systemicon" alt="Commandes" title="Commandes">';
$smarty->assign('add_users', 
		$this->CreateLink($id, 'edit_adherent',$returnid, 'Ajouter'));
$smarty->assign('shopping', $shopping);

if(isset($params['group']) && $params['group'] != '')
{
	$group = $params['group'];
	$req = 1;
	$query = "SELECT adh.id, adh.licence, adh.nom, adh.prenom, adh.actif, adh.anniversaire, adh.sexe, adh.type, adh.certif, adh.validation, adh.echelon, adh.place, adh.points, adh.cat, adh.adresse, adh.code_postal, adh.ville FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.licence = be.licence AND be.id_group = ?";//" WHERE actif = 1";
}


if(isset($params['actif']) && $params['actif'] == 0)
{

		$query.=" AND adh.actif = 0";
	
}
else
{
	
		$query.=" AND adh.actif = 1";

}
$query.=" ORDER BY adh.nom ASC ";
$smarty->assign('act', $act);
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
		$onerow->licence= $row['licence'];
		$has_email = $contact_ops->has_email($row['licence']);
		if(TRUE === $has_email)
		{
			$onerow->has_email = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('delete'), '', '', 'systemicon');
		}
		else
		{
			$onerow->has_email = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('delete'), '', '', 'systemicon');
		}
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		$onerow->actif= $row['actif'];
		$onerow->deletefromgroup = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array("obj"=>"delete_user_from_group","licence"=>$row['licence'], "record_id"=>$group));
		
		
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

//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('view_group_users.tpl');

?>