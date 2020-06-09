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

$send_email = '<img src="../modules/Adherents/images/email-16.png" class="systemicon" title="Renvoyer un nouvel email" alt="Renvoyer un nouvel email"/>';
$query = "SELECT ad.id, ad.genid,ad.licence, ad.nom, ad.prenom, LOWER(CONCAT_WS('',ad.prenom, ad.nom )) AS nom_complet, ct.contact FROM ".cms_db_prefix()."module_adherents_adherents AS ad, ".cms_db_prefix()."module_adherents_contacts AS ct WHERE ad.genid = ct.genid AND ct.type_contact = 1";//" WHERE actif = 1";
$query.=" AND ad.actif = 1 ORDER BY ad.nom ASC";
$dbresult = $db->Execute($query);
$rowarray = array();
$rowclass = 'row1';
$feu = cms_utils::get_module('FrontEndUsers');//on instancie le module FEU
if($dbresult && $dbresult->RecordCount() >0)
{
	$adh_feu = new AdherentsFeu;
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->genid= $row['genid'];
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		$onerow->email = $row['contact'];
		//$nom_complet = str_replace(" ", "",strtolower($row['prenom'].''.$row['nom']));
		
		$onerow->edit = $this->CreateLink($id, 'edit_adherent',$returnid,'Modifier', array("genid"=>$row['genid']));
		$onerow->refresh= $this->CreateLink($id, 'chercher_adherents_spid', $returnid,'<img src="../modules/Adherents/images/refresh.png" class="systemicon" alt="Rafraichir" title="Rafraichir">',array("obj"=>"refresh","licence"=>$row['licence']));//$row['closed'];
		$onerow->view_contacts= $this->CreateLink($id, 'view_contacts', $returnid,'<img src="../modules/Adherents/images/contact.jpg" class="systemicon" alt="Contacts" title="Contacts">',array("genid"=>$row['genid']));//$row['closed'];
		$est_present = $feu->GetUserId($row['nom_complet']);
		//var_dump($est_present);
		$last_connected = $adh_feu->last_logged($est_present);
		
		if($est_present == NULL )
		{
			
			$onerow->last_logged = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon');
			$onerow->push_customer= $this->CreateLink($id, 'push_customer', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('push'), '', '', 'systemicon'), array("genid"=>$row['genid'], "email"=>$row['contact'], "nom"=>$row['nom'], "prenom"=>$row['prenom']));
		}
		else
		{
			$onerow->push_customer=  $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('compte_actif'), '', '', 'systemicon');
			if(FALSE !== $last_connected)
			{
				$onerow->last_logged = $adh_feu->last_logged($est_present);
			}
			else
			{
				$onerow->last_logged = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon');
			}
			$onerow->delete_user_feu = $this->CreateLink($id, 'chercher_adherents_spid', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array("obj"=>"delete_user_feu","genid"=>$est_present ));
		}
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
echo $this->ProcessTemplate('feu.tpl');

?>