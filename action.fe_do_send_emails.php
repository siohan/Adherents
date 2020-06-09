<?php

if(!isset($gCms)) exit;

$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);
$db = cmsms()->GetDb();
global $themeObject;
debug_display($params, 'Parameters');
$error = 0;

$destinataires = 'claude.siohan@gmail.com';//$params['destinataires'];	

$contact_ops = new contact;
$expediteur = $contact_ops->email_address($username);

if(isset($params['priority']) && $params['priority'])
{
	$priority = $params['priority'];
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
	//On envoie le message ds le module dédié
	$senddate = date('Y-m-d');
	$sendtime = date('H:i:s');
	$replyto = $username;
	$group_id = 0;
	$recipients_number = 1;
	$subject = $sujet;
	$sent = 1;
	$mess_ops = new T2t_messages;
	$add_mess = $mess_ops->add_message($username, $senddate, $sendtime, $replyto, $group_id,$recipients_number, $subject, $message, $sent);
	
	

	
	
	//var_dump($item);
	
		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
		$cmsmailer->SetFrom($expediteur);//$this->GetPreference('admin_email'));
		$cmsmailer->AddAddress('claude.siohan@gmail.com',$name='Claude SIOHAN');
		$cmsmailer->IsHTML(false);
		$cmsmailer->SetPriority($priority);
		$cmsmailer->SetBody($message);
		$cmsmailer->SetSubject($sujet);
		$cmsmailer->Send();
                if( !$cmsmailer->Send() ) {
                    audit('',$this->GetName(),'Problem sending email to '.$item);
			$send = FALSE;
                    
                }
		else
		{
			$send = TRUE;
		}
	
	
}
$this->Redirect($id, 'default', $returnid);

?>