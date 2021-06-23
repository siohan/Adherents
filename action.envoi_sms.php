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
if(isset($params['group']) && $params['group'] != '')
{
	$group = $params['group'];
	//$tab = explode ('-', $sel);
	//var_dump($tab);
}
else
{
	//une erreur s'est produite !
	$this->SetMessage('Erreur ! Pas de sélection disponible');
	$this->redirectToAdminTab('groupes');
}
$mod = 'Sms';
$module = \cms_utils::get_module($mod);
$result = 0;
if( is_object( $module ) ) $result = 1;//on vérifie que le module adhérents est bien installé et activé
//var_dump( $result);
if(false == $result)
{
	$message.= 'Module '.$mod.' non installé ou non activé !';
	$this->SetMessage($message);
	$this->redirectToAdminTab('groups');
}
else
{
	$destinataires = array();
	/*
	foreach($tab as $sels)
	{
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE licence = ? AND type_contact = 2";
		$dbresult = $db->Execute($query, array($sels));
		$row = $dbresult->FetchRow();
		$contact = $row['contact'];
		if(!is_null($contact))
		{
			$destinataires[] = $contact;
		}

	}
	$adresses  = implode(',',$destinataires);
	*/
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_send_sms', $returnid ) );

	$smarty->assign('sender',
			$this->CreateInputText($id, 'sender',(isset($sender)?$sender:"Expéditeur"),50, 350));
			//$recipients = '33650579764';
	$smarty->assign('group',
			$this->CreateInputHidden($id,'group',$group));
	//$smarty->assign('senddate', $this->CreateInputDate())	;

	//$smarty->assign('sendtime');	


	$parms = array(
			'enablewysiwyg' => 0,
			'name' => $id.'content',
			    'text' => $content,
			    'rows' => 4,
			    'cols' => 40
			);
	$smarty->assign('content',  CmsFormUtils::create_textarea($parms));		

	/*		
	$smarty->assign('description',
			$this->CreateInputTextArea($enablewysiwyg='false',$id,(isset($description)?$description:""),'description','','', '','', $cols='50', $rows='50'));
	*/


	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());





	echo $this->ProcessTemplate('sendsms.tpl');
}





?>