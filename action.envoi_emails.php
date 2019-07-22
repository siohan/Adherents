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
$mod = 'Messages';
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
	//debug_display($params, 'Parameters');
	$aujourdhui = date('Y-m-d');
	$cont_ops = new contact;// = new Ping();
	$group = $cont_ops->liste_groupes();
	$act = 1;//par defaut on affiche les actifs (= 1 )

	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_send_emails', $returnid ) );
	$smarty->assign('endform', $this->CreateFormEnd());
	$smarty->assign('group',
			$this->CreateInputDropdown($id,'group',$group));
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
}


?>