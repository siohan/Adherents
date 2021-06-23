<?php
if( !isset($gCms) ) exit;
//echo "Cool !";
//debug_display($params, 'Parameters');
$designation = '';//le message de fin....
$feu = cms_utils::get_module('FrontEndUsers');

$error = 0;//on instancie un compteur d'erreurs
// variables à contrôler :  l'email , la licence
$asso_ops = new Asso_adherents;
$cont = new contact;
if(isset($params['record_id']) && $params['record_id'] !='')//ici c'est le genid de l'utilisateur
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
	$feu_id = $details['feu_id'];
	$nom = $details['nom'];
	$prenom = $details['prenom'];	
}
else
{
	$error++;
}



//echo $error;
if($error<1)
{

	
		//on récupère le nom
		$nom_complet = $feu->GetUserName($feu_id);
		
		$mot1 = $this->random_string(7);
		$motdepasse = 'A'.$mot1.'1';
		//on modifie le mot de passe originel ds FEU
		$new_password = $feu->SetUserPassword($feu_id, $motdepasse);
		
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
		//$cmsmailer->AddBCC( $admin_email);
		$cmsmailer->IsHTML(true);
		$cmsmailer->SetPriority($priority);
		$cmsmailer->SetBody($output);
		$cmsmailer->SetSubject($subject);

	        if( !$cmsmailer->Send() ) 
			{			
	            return false;
				
	        }
	        else
	        {
	        	$designation.= "Un email a été envoyé !";
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
