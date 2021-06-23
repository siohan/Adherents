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
	$group_id = $params['group'];
}
else
{
	$error++;
}
if(isset($params['from']) && $params['from'])
{
	$sender = $params['from'];
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
	$subject = $params['sujet'];
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
	$senddate = date('Y-m-d');
	$sendtime = date("H:i:s");
	$replyto = $sender;
	$sent = 1;
	$gp_ops = new groups;
	$recipients_number = $gp_ops->count_users_in_group($group_id);
	$mess_ops = new T2t_messages;
	$mess = $mess_ops->add_message($sender, $senddate, $sendtime, $replyto, $group_id,$recipients_number, $subject, $message, $sent);
	$message_id =$db->Insert_ID();
//	var_dump($message_id);
	//on extrait les utilisateurs (licence) du groupe sélectionné
	$contacts_ops = new contact;
	$adherents = $contacts_ops->UsersFromGroup($group_id);
	
//	var_dump($adherents);
	foreach($adherents as $sels)
	{
		//avant on envoie dans le module emails pour tous les utilisateurs et sans traitement
				
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE licence = ? AND type_contact = 1 LIMIT 1";
		$dbresult = $db->Execute($query, array($sels));
		$row = $dbresult->FetchRow();
			
		$email_contact = $row['contact'];
		var_dump($email_contact);
		if(!is_null($email_contact))
		{
			$destinataires[] = $email_contact;
				$sent = 1;
				$status = "Email Ok";
				$ar = 0;
		}
		else
		{
			//on indique l'erreur : pas d'email disponible !
				$sent = 0;
				$status = "Email absent";
				$ar = 0;
				$email_contact = "rien";
		}
			
		echo $status.'<br />';	
		
		/*
		$query2 = "INSERT INTO ".cms_db_prefix()."module_messages_recipients (message_id, licence, recipients,sent,status, ar) VALUES (?, ?, ?, ?, ?, ?)";
		$dbresult2 = $db->Execute($query2, array($message_id, $sels, $email_contact,$sent,$status, $ar));
		*/
		$add_to_recipients = $mess_ops->add_messages_to_recipients($message_id, $sels, $email_contact,$sent,$status, $ar);
	//	var_dump($add_to_recipients);
	}
	var_dump($destinataires);
	//$adresses  = implode(',',$destinataires);
	//$tab = explode(',', $destinataires);
	//var_dump($tab);
	


	foreach($destinataires as $item=>$v)
	{
	
	//var_dump($item);
	
		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
		$cmsmailer->SetFrom($sender);//$this->GetPreference('admin_email'));
		$cmsmailer->AddAddress($v,$name='');
		$cmsmailer->IsHTML(false);
		$cmsmailer->SetPriority($priority);
		$cmsmailer->SetBody($message);
		$cmsmailer->SetSubject($subject);
		$cmsmailer->Send();
                if( !$cmsmailer->Send() ) 
		{			
                    	$mess_ops->not_sent_emails($message_id, $recipients);
			$this->Audit('',$this->GetName(),'Problem sending email to '.$item);
                    
                }
	}

}
$this->Redirect($id, 'defaultadmin', $returnid);
