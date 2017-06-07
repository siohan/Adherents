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
$send_email = '<img src="../modules/Adherents/images/email-16.png" class="systemicon" title="Renvoyer un nouvel email" alt="Renvoyer un nouvel email"/>';
$query = "SELECT ad.id, ad.licence, ad.nom, ad.prenom, ct.contact FROM ".cms_db_prefix()."module_adherents_adherents AS ad, ".cms_db_prefix()."module_adherents_contacts AS ct WHERE ad.licence = ct.licence AND ct.type_contact = 1";//" WHERE actif = 1";
$query.=" AND actif = 1";
$dbresult = $db->Execute($query);
$rowarray = array();
$rowclass = 'row1';
$feu = cms_utils::get_module('FrontEndUsers');//on instancie le module FEU
if($dbresult && $dbresult->RecordCount() >0)
{
	
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->licence= $row['licence'];
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		$onerow->email = $row['contact'];
		
		$onerow->edit = $this->CreateLink($id, 'edit_adherent',$returnid,'Modifier', array("licence"=>$row['licence']));
		$onerow->refresh= $this->CreateLink($id, 'chercher_adherents_spid', $returnid,'<img src="../modules/Adherents/images/refresh.png" class="systemicon" alt="Rafraichir" title="Rafraichir">',array("obj"=>"refresh","licence"=>$row['licence']));//$row['closed'];
		$onerow->view_contacts= $this->CreateLink($id, 'view_contacts', $returnid,'<img src="../modules/Adherents/images/contact.jpg" class="systemicon" alt="Contacts" title="Contacts">',array("licence"=>$row['licence']));//$row['closed'];
		
		$est_present = $feu->GetUserId($row['licence']);
		//var_dump($est_present);
		if($est_present == NULL )
		{
			$onerow->push_customer= $this->CreateLink($id, 'push_customer', $returnid, $themeObject->DisplayImage('icons/system/groupassign.gif', $this->Lang('push'), '', '', 'systemicon'), array("licence"=>$row['licence'], "email"=>$row['contact'], "nom"=>$row['nom'], "prenom"=>$row['prenom']));
		}
		else
		{
			$onerow->push_customer=  $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('compte_actif'), '', '', 'systemicon');
			$onerow->send_another_email = $this->CreateLink($id, 'chercher_adherents_spid', $returnid, $send_email, array("obj"=>"send_another_email","licence"=>$row['licence'], "email"=>$row['contact'], "nom"=>$row['nom'], "prenom"=>$row['prenom']));
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