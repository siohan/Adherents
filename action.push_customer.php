<?php
if( !isset($gCms) ) exit;
//echo "Cool !";
debug_display($params, 'Parameters');
$designation = '';//le message de fin....
$feu = cms_utils::get_module('FrontEndUsers');
//$feu = new FrontEndUsers();
$error = 0;//on instancie un compteur d'erreurs
// variables à contrôler :  l'email , la licence
$asso_ops = new Asso_adherents;
$cont = new contact;
if(isset($params['record_id']) && $params['record_id'] !='')
{
	//on vérifie d'abord que le membre a bien une adresse email
	$email = $cont->has_email($params['record_id']);
	if(false == $email)
	{
		$error++;
		$this->SetMessage('Le membre doit avoir une adresse email !');
		$this->Redirect($id, 'view_adherent_details', $returnid, array("record_id"=>$params['record_id']));
	}
	$user_email = $cont->email_address($params['record_id']);
	
	$details = $asso_ops->details_adherent_by_genid($params['record_id']);
	$nom = $details['nom'];
	$nom = mb_convert_encoding($nom, "UTF-8", "Windows-1252");
	$nom = stripslashes($nom);
	$nom = str_replace("&#39;", "", $nom);
	$nom = str_replace(" ", "",$nom);
	
	$prenom = $details['prenom'];
	$prenom = str_replace("&#39", "",$prenom);
	$prenom = $asso_ops->clean_name($prenom);

	$nom_complet = strtolower($prenom. ''.$nom);
	
}
else
{
	$error++;
}



//echo $error;
if($error<1)
{

	$day = date('j');
	$month = date('n');
	$year = date('Y')+5;
	$expires = mktime(0,0,0,$month, $day,$year);
	//on créé un mot de passe
	$mot1 = $this->random_string(7);
	$motdepasse = 'A'.$mot1.'1';

	//qqs variables pour le mail
	$smarty->assign('prenom_joueur', $prenom);
	$smarty->assign('nom_joueur' , $nom);
	$smarty->assign('nom_complet', $nom_complet);
	//$motdepasse = 'UxzqsUIM1';
	$smarty->assign('motdepasse', $motdepasse);
	
	
	$add_user = $feu->AddUser($nom_complet, $motdepasse,$expires);
	
	if(true == $add_user)
	{
		//on récupère le userid ($uid)
		$uid = $feu->GetUserId($nom_complet);
		//on force le changement de mot de passe ?
		$uid = (int) $uid;
		$feu->SetUserPropertyFull('email',$user_email, $uid);
		$feu->SetUserPropertyFull('nom', $nom_complet,$uid);
		$feu->SetUserPropertyFull('genid',$params['record_id'], $uid);

		/* On essaie d'envoyer un message à l'utilisateur pour lui dire qu'il est enregistré */	

		$admin_email = $this->GetPreference('admin_email'); 
		//echo $to;
		$subject = $this->GetPreference('email_activation_subject');
		$priority = 3;
		//$montpl = $this->GetTemplateResource('newactivationemail_Sample.tpl');
		$montpl = $this->GetTemplateResource('newactivationemail_Sample.tpl');						
		$smarty = cmsms()->GetSmarty();
		// do not assign data to the global smarty
		$tpl = $smarty->createTemplate($montpl);
		$tpl->assign('prenom_joueur',$prenom);
		$tpl->assign('nom_joueur',$nom);
		$tpl->assign('nom_complet',$nom_complet);
		$tpl->assign('motdepasse',$motdepasse);
	 	$output = $tpl->fetch();

		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
		$cmsmailer->AddAddress($user_email);
		$cmsmailer->IsHTML(true);
		$cmsmailer->SetPriority($priority);
		$cmsmailer->SetBody($output);
		$cmsmailer->SetSubject($subject);

	        if( !$cmsmailer->Send() ) 
		{			
	            	return false;
			//$mess_ops->not_sent_emails($message_id, $recipients);
	        }
	}
	else
	{
		$designation.= "Une erreur est apparue lors de la création du compte";
	}
	
	$this->SetMessage($designation);
	
}
else
{
	//les conditions ne sont pas remplis, on renvoit à la page précédente
	//echo $error;
	$this->SetMessage('parametres manquants');
	
}
$this->Redirect($id, 'view_adherent_details', $returnid, array("record_id"=>$params['record_id']));


# EOF
#

?>