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
$numero_club = $this->GetPreference('club_number');
//echo $numero_club;
if(!isset($numero_club) || $numero_club == '')
{
	$smarty->assign('alert', '1');
	$smarty->assign('link_alert', 
			$this->CreateLink($id, 'add_edit_club_number', $returnid, 'Votre numéro de club est manquant !'));
}

$aujourdhui = date('Y-m-d');
//$ping = new Ping();
$act = 1;//par defaut on affiche les actifs (= 1 )
$shopping = '<img src="../modules/Adherents/images/shopping.jpg" class="systemicon" alt="Commandes" title="Commandes">';
$cotis = '<img src="../modules/Adherents/images/cotisations.png" class="systemicon" alt="Cotisations" title="Cotisations">';
$smarty->assign('add_users', 
		$this->CreateLink($id, 'edit_adherent',$returnid, 'Ajouter'));
$smarty->assign('shopping', $shopping);
$smarty->assign('cotis', $cotis);
$smarty->assign('inactifs',
		$this->CreateLink($id, 'defaultadmin', $returnid, 'Inactifs', array("actif"=>"0", "active_tab"=>"adherents")));
$smarty->assign('actifs',
				$this->CreateLink($id, 'defaultadmin', $returnid, 'Actifs', array("active_tab"=>"adherents")));
$smarty->assign('chercher_adherents_spid',
				$this->CreateLink($id, 'chercher_adherents_spid', $returnid, $contents='Importer les adhérents depuis le Spid',array("obj"=>"all"),$warn_message='Attention, ce script peut être long. Merci de patienter'));
$smarty->assign('refresh',
		$this->CreateLink($id, 'chercher_adherents_spid', $returnid, '<img src="../modules/Adherents/images/refresh.png" class="systemicon" alt="Tout rafraichir" title="Tout rafraichir">Tout rafraichir',array("obj"=>"refresh_all"),$warn_message='Attention, ce script peut être long. Merci de patienter'));

if(isset($params['group']) && $params['group'] != '')
{
	$group = $params['group'];
	$req = 1;
	$query = "SELECT adh.id, adh.licence, adh.nom, adh.prenom, adh.actif, adh.anniversaire, adh.sexe, adh.type, adh.certif, adh.validation, adh.echelon, adh.place, adh.points, adh.cat, adh.adresse, adh.code_postal, adh.ville FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.licence = be.licence AND be.id_group = ?";//" WHERE actif = 1";
}
else
{
	$req = 2;
	$query = "SELECT id, licence, nom, prenom, actif, anniversaire, sexe, type, certif, validation, echelon, place, points, cat, adresse, code_postal, ville FROM ".cms_db_prefix()."module_adherents_adherents AS adh";
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
		$onerow->anniversaire = $row['anniversaire'];
		$onerow->adresse = $row['adresse'];
		$onerow->code_postal = $row['code_postal'];
		$onerow->ville = $row['ville'];
		$onerow->edit = $this->CreateLink($id, 'edit_adherent',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array("record_id"=>$row['id']));
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