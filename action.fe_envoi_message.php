<?php

if(!isset($gCms)) exit;
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);
require_once(dirname(__FILE__).'/include/fe_menu.php');
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$aujourdhui = date('Y-m-d');
//$ping = new Ping();
	

//var_dump($groupes);

$smarty->assign('formstart',
		    $this->CreateFormStart( $id, 'fe_do_send_emails', $returnid ) );
$smarty->assign('endform', $this->CreateFormEnd());

$smarty->assign('from', 
		$this->CreateInputHidden($id, 'from', $username));
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
echo $this->ProcessTemplate('fe_envoi_emails.tpl');

?>