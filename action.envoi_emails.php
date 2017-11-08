<?php

if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$aujourdhui = date('Y-m-d');
//$ping = new Ping();
$act = 1;//par defaut on affiche les actifs (= 1 )
if(isset($params['sel']) && $params['sel'] != '')
{
	$sel = $params['sel'];
	$tab = explode ('-', $sel);
	//var_dump($tab);
}
else
{
	//une erreur s'est produite !
	$this->SetMessage('Erreur ! Pas de sélection disponible');
	$this->redirectToAdminTab('groupes');
}
$destinataires = array();
foreach($tab as $sels)
{
	$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE licence = ? AND type_contact = 1";
	$dbresult = $db->Execute($query, array($sels));
	$row = $dbresult->FetchRow();
	$contact = $row['contact'];
	if(!is_null($contact))
	{
		$destinataires[] = $contact;
	}
	
}
$adresses  = implode(',',$destinataires);
//var_dump($adresses);
$smarty->assign('formstart',
		    $this->CreateFormStart( $id, 'do_send_emails', $returnid ) );
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('destinataires',
		$this->CreateInputHidden($id,'destinataires',$adresses, 100, 200));
$smarty->assign('from', 
		$this->CreateInputText($id, 'from', $this->GetPreference('admin_email'), 50, 200));
$array_priorities = array("Normale"=>"3","Haute"=>"1","Basse"=>"5");
$smarty->assign('priority', $this->CreateInputDropdown($id, 'priority', $array_priorities));
$smarty->assign('sujet',
		$this->CreateInputText($id, 'sujet','', 50, 200));		
$smarty->assign('message',
		$this->CreateSyntaxArea($id,$text='','message','', '', '', '', 80, 7));
$smarty->assign('submit',
		$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
$smarty->assign('cancel',
		$this->CreateInputSubmit($id,'cancel',
					$this->Lang('cancel')));	

//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('envoi_emails.tpl');

?>