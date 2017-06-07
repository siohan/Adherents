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
$aujourdhui = date('Y-m-d');
$ping = new Ping();
$act = 1;//par defaut on affiche les actifs (= 1 )
$shopping = '<img src="../modules/Adherents/images/shopping.jpg" class="systemicon" alt="Commandes" title="Commandes">';
$smarty->assign('shopping', $shopping);
$smarty->assign('inactifs',
		$this->CreateLink($id, 'defaultadmin', $returnid, 'Inactifs', array("actif"=>"0", "active_tab"=>"adherents")));
$smarty->assign('actifs',
				$this->CreateLink($id, 'defaultadmin', $returnid, 'Actifs', array("active_tab"=>"adherents")));
$smarty->assign('chercher_adherents_spid',
				$this->CreateLink($id, 'chercher_adherents_spid', $returnid, $contents='Importer les adhérents depuis le Spid',array("obj"=>"all"),$warn_message='Attention, ce script peut être long. Merci de patienter'));
$smarty->assign('refresh',
		$this->CreateLink($id, 'chercher_adherents_spid', $returnid, '<img src="../modules/Adherents/images/refresh.png" class="systemicon" alt="Tout rafraichir" title="Tout rafraichir">Tout rafraichir',array("obj"=>"refresh_all"),$warn_message='Attention, ce script peut être long. Merci de patienter'));
$query = "SELECT id, licence, nom, prenom, actif, anniversaire, sexe, type, certif, validation, echelon, place, points, cat, adresse, code_postal, ville FROM ".cms_db_prefix()."module_adherents_adherents";//" WHERE actif = 1";
if(isset($params['actif']) && $params['actif'] == 0)
{
	$query.=" WHERE actif = 0";
	$act = 0;
}
else
{
	$query.=" WHERE actif = 1";
	$act = 1;
}
$smarty->assign('act', $act);
$dbresult = $db->Execute($query);
$rowarray = array();
$rowclass = 'row1';
if($dbresult && $dbresult->RecordCount() >0)
{
	
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->licence= $row['licence'];
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		$onerow->actif= $row['actif'];
		$onerow->sexe= $row['sexe'];
		$onerow->certif= $row['certif'];
		$onerow->points = $row['points'];
		$onerow->date_validation = $row['validation'];
		$onerow->cat = $row['cat'];
		$onerow->adresse = $row['adresse'];
		$onerow->code_postal = $row['code_postal'];
		$onerow->ville = $row['ville'];
		$onerow->edit = $this->CreateLink($id, 'edit_adherent',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array("licence"=>$row['licence']));
		$onerow->refresh= $this->CreateLink($id, 'chercher_adherents_spid', $returnid,'<img src="../modules/Adherents/images/refresh.png" class="systemicon" alt="Rafraichir" title="Rafraichir">',array("obj"=>"refresh","licence"=>$row['licence']));//$row['closed'];
		$onerow->view_contacts= $this->CreateLink($id, 'view_contacts', $returnid,'<img src="../modules/Adherents/images/contact.jpg" class="systemicon" alt="Contacts" title="Contacts">',array("licence"=>$row['licence']));//$row['closed'];
		
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
echo $this->ProcessTemplate('adherents.tpl');

?>