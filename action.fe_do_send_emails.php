<?php

if(!isset($gCms)) exit;

$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);
$db = cmsms()->GetDb();
global $themeObject;
debug_display($params, 'Parameters');
$error = 0;
if(isset($params['destinataires']) && $params['destinataires'])
{
	$destinataires = $params['destinataires'];
	//on va chercher les membres du groupe et leurs adresses emails
	$contact_ops = new contact;
	$groupe_licencies = $contact_ops->UsersFromGroup($destinataires);
	if(is_array($groupe_licencies) || array_count_values($groupe_licencies)>0)
	{
		//$dest1 = array();
		$dest = array();
		foreach($groupe_licencies as $tab )
		{
			//on va chercher les mails de chacun maintenant
			
			$dest1 = $contact_ops->email_address($tab);
			//var_dump($dest1);
			if(FALSE !== $dest1)//l'utilisateur n'a pas de mail enregistré !!
			{
				//il faut signaler l'erreur !
				$dest[] = $dest1;
				
			}
			else
			{
				//on va le mettre en erreur
			}
			
		}
	}
	
	
}
else
{
	$error++;
}
var_dump($groupe_licencies);
var_dump($dest);
$expediteur = $contact_ops->email_address($username);

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
	//On envoie le message ds le module dédié
	$query = "INSERT INTO ".cms_db_prefix()."module_messages_messages (expediteur, sujet, message, priorite, statut) VALUES (?, ?, ?, ?, ?)";
	
	

	foreach($dest as $item=>$v)
	{
	
	//var_dump($item);
	
		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
		$cmsmailer->SetFrom($expediteur);//$this->GetPreference('admin_email'));
		$cmsmailer->AddAddress($v,$name='');
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
	
}
$this->Redirect($id, 'default', $returnid);

?>