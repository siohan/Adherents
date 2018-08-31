<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Sms use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;   
}
if( isset($params['cancel']) )
{
    	$this->RedirectToAdminTab('sms');
    	return;
}
debug_display($params, 'Parameters');

//on vérifie que tous les éléments nécessaires sont bien là
$error = 0;
if(isset($params['content']) && $params['content'] != '')
{
	$content = $params['content'];
}
else
{
	$error++;
}
if(isset($params['sender']) && $params['sender'] != '')
{
	$sender = $params['sender'];
}
else
{
	$error++;
}
if(isset($params['group']) && $params['group']!= '')
{
	$group = $params['group'];
}
else
{
	$error++;
}


$db =& $this->GetDb();
	if($error == 0)
	{
		//on met le sms en bdd avec les détails
		$sms_ops = new sms_ops;
		//on prépare les variables avant insertion
		$subtype = 'PREMIUM';
		$senddate = date('Y-m-d');
		$sendtime = date('H:i:s');
		$message = $content;
		$message_reference = $this->random_string(15);
		$senderlabel = $sender;
		$richsms_option = 0;
		$richsms_url = '';
		$add_message = $sms_ops->add_message($message_reference,$subtype, $senddate, $sendtime,$senderlabel, $content, $richsms_option,$richsms_url);
		if(true === $add_message)
		{
			$message_id = $db->Insert_ID();
		}
		$contact = new contact;
		$liste_destinataires = $contact->UsersFromGroup($group);
		//var_dump($liste_destinataires);
		
		//on envoie les destinataires en bdd
		$mobiles = array();
		$adresses = '';
		foreach($liste_destinataires as $tab)
		{
			//on  récupère les N° de portable des personnes
			//on ajoute le destinataire à la table des recipients
			$id_envoi = 0;
			
			$recipients = $contact->mobile($tab);
		//	var_dump($recipients);
			if(FALSE !== $recipients)
			{
				//on incrémente le tableau $mobiles
				$mobiles[]= $recipients;				
			}
			else
			{
				//on indique une erreur ou un manque ?
			}
			$sms_ops->add_recipients($message_id, $id_envoi, $tab, $sent='0', $recipients);
		}
		var_dump($mobiles);
		if(is_array($mobiles) && count($mobiles) > 0)
		{
			$adresses  = implode(',',$mobiles);
		}
		
		var_dump($adresses);
		//Instantiation de l'objet $smsenvoi appartenant à la classe SMSENVOI
		$smsenvoi=new smsenvoi();
		
		//Envoi du SMS (forcé en gamme premium)
		//renvoie true si succès
		
		if($smsenvoi->sendSMS($adresses,$message,'PREMIUM',$sender))
		{
			
				//ENVOI REUSSI
				$success=true;

				//Id de l'envoi effectué
				//Idéalement, cet id devrait être stocké en base de données
				$id_envoi=$smsenvoi->id;
				//on met la bdd à jour
				$maj_message = $sms_ops->maj_envoi($message_reference,$id_envoi);
				//on indique que le message a bien été envoyé
				$sms_ops->maj_envoi_recipients($message_id, $id_envoi);
				$this->SetMessage('Envoi réussi ! Consultez le module T2T SMS...');
				$this->RedirectToAdminTab('sms');
			
		}
		else
		{
				//ECHEC
				$success=false;
				$this->SetMessage('Envoi échoué !');
				$this->RedirectToAdminTab('sms');
		}
		
		
	}
	else
	{ 
		//formulaire non posté ? nous sômmes arrivés ici par erreur
		$this->SetMessage('Erreur(s) dans le formulaire');
		$this->Redirect($id,'sendsms', $returnid);
	
	}


	
?>
