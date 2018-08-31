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
debug_display($params, 'Parameters');
$error = 0;
if(isset($params['group']) && $params['group'])
{
	$group = $params['group'];
}
else
{
	$error++;
}
if(isset($params['from']) && $params['from'])
{
	$from = $params['from'];
}
else
{
	$error++;
}
if(isset($params['priority']) && $params['priority'])
{
	$priority = $params['priority'];
}
else
{
	$error++;
}
if(isset($params['sujet']) && $params['sujet'])
{
	$sujet = $params['sujet'];
}
else
{
	$error++;
}

if(isset($params['message']) && $params['message'])
{
	$message = $params['message'];
}	
else
{
	$error++;
}
if($error >0)
{
	//pas glop, des erreurs !
	echo "trop d\'erreurs !";
}
else
{
	// on commence le traitement
	//on extrait les utilisateurs (licence) du groupe sélectionné
	$contacts_ops = new contact;
	$adherents = $contacts_ops->UsersFromGroup($group);
	
	var_dump($adherents);
	foreach($adherents as $sels)
	{
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE licence = ? AND type_contact = 1";
		$dbresult = $db->Execute($query, array($sels));
		$row = $dbresult->FetchRow();
		$contact = $row['contact'];
		if(!is_null($contact))
		{
			$destinataires[] = $contact;
		}
		else
		{
			//on indique l'erreur : pas d'email disponible !
		}

	}
	$adresses  = implode(',',$destinataires);
	//$tab = explode(',', $destinataires);
	var_dump($tab);
	

/*
	foreach($tab as $item=>$v)
	{
	
	//var_dump($item);
	
		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
		$cmsmailer->SetFrom($from);//$this->GetPreference('admin_email'));
		$cmsmailer->AddAddress($v,$name='');
		$cmsmailer->IsHTML(false);
		$cmsmailer->SetPriority($priority);
		$cmsmailer->SetBody($message);
		$cmsmailer->SetSubject($sujet);
		$cmsmailer->Send();
                if( !$cmsmailer->Send() ) {
                    audit('',$this->GetName(),'Problem sending email to '.$item);
                    
                }
	}
*/
}
$this->Redirect($id, 'defaultadmin', $returnid);
