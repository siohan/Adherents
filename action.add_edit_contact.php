<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Adherents use'))
{

	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($_POST, 'parameters');
$cont_ops = new contact;
$db =& $this->GetDb();
global $themeObject;
if(!empty($_POST))
{
	if(isset($_POST['cancel']))
	{
		//redir
		//$this->Redirect($id, "view_contacts", $returnid, array("genid"=>$genid));
	}
	$edit = 0;
	$error = 0;
	$message = '';
	if(isset($_POST['record_id']) && $_POST['record_id'] != '0')
	{
		$record_id = (int) $_POST['record_id'];
		$edit = 1;
	}
	if(isset($_POST['genid']) && $_POST['genid'] != '')
	{
		$genid = (int) $_POST['genid'];
	}
	else
	{
		$error++;
		$message.=" Identifiant absent !";
	}
	if(isset($_POST['type_contact']) && $_POST['type_contact'] != '')
	{
		$type_contact = (int) $_POST['type_contact'];
	}
	if(isset($_POST['contact']) && $_POST['contact'] != '')
	{
		$contact = $_POST['contact'];
	}
	else
	{
		$error++;
		$message.=" Contact absent !";
	}
	$description = '';
	if(isset($_POST['description']) && $_POST['description'] != '')
	{
		$description = $_POST['description'];
	}
	if($error <1)
	{
		if($edit == 1)
		{
			$update = $cont_ops->update_contact($type_contact,$contact,$description,$record_id);
		}
		else
		{
			$add = $cont_ops->add_contact($genid, $type_contact,$contact,$description);
		}
	}
	//on redirige en fin de script
	$this->SetMessage($message);
	$this->Redirect($id, "view_adherent_details", $returnid, array("record_id"=>$genid));
}
else
{
	//debug_display($params, 'parameters');
	if(isset($params['genid']) && $params['genid'] != '')
	{
		$genid = $params['genid'];
	}
	else
	{
		//on renvoie à une erreur
	}
	
	//valeurs par défaut//Default values
	$edit = 0;
	$record_id = 0;
	$type_contact = 0;
	$contact = "";
	$description = "";
	
	if(isset($params['record_id']) && $params['record_id'] != '')
	{
		$record_id = $params['record_id'];
		$cont_ops = new contact;
		$details = $cont_ops->details_contact($record_id);
		$genid = $details['genid'];
		$type_contact = $details['type_contact'];
		$contact = $details['contact'];
		$description = $details['description'];
		
		$edit = 1;
	}
	if(isset($params['type_contact']) && $params['type_contact'] != '')
	{
		$type_contact = $params['type_contact'];
	}

	$liste_types_contact = array("0"=>"Tél","1"=>"Mail","2"=>"Portable");
	

		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_edit_contact.tpl', null, null, $smarty));
		$tpl->assign('genid', $genid);
		$tpl->assign('record_id', $record_id);
		$tpl->assign('liste_types_contact', $liste_types_contact);
		$tpl->assign('type_contact', $type_contact);
		$tpl->assign('contact', $contact);
		$tpl->assign('description', $description);
		$tpl->display();
}


	



?>