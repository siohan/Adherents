<?php
if (!isset($gCms)) exit;

$db = cmsms()->GetDb();
global $themeObject;
$final_message = '';
$validation = 0;

/* l'utilisateur ne connait plus son mot de passe !! 
 * On affiche un formulaire avec le nom et le prénom de l'utilisateur (deux champs donc)
 */
 if( !empty($_POST) ) 
{
    if( isset($_POST['cancel']) ) 
	{
        $this->RedirectToAdminTab();
    }
	$error = 0;
	$validation = 1;
	//debug_display($_POST, 'Parameters');
	$nom  = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$asso_ops = new Asso_adherents;
	$cont_ops = new contact;
	$genid  = $asso_ops->search_member_genid($nom, $prenom);
	
	if(false == $genid)
	{
		//pas de genid, on a rien pour l'utilisateur, on fait quoi ?
		$final_message.=" Désolé, utilisateur inconnu !";// L'admin a été prévenu de votre essai";
		echo '<div class="alert alert-danger" role="alert">'.$final_message.'</div>';
	}
	else
	{
		//on a le genid de la personne, on peut récupérer les détails et son email (s'il en a un)
		$details = $asso_ops->details_adherent_by_genid($genid);
		$feu_id = $details['feu_id'];
		$user_email = $cont_ops->email_address($genid);
		if(false != $user_email)
		{
			/*l'utilisateur est connu et a une adresse email, tout va bien.
			* On envoie un mail avec le lien pour le formulaire
			*/
			
			$cg_ops = new CGExtensions;
			//var_dump($adherents);
			$retourid = $this->GetPreference('pageid_subscription');
			$page = $cg_ops->resolve_alias_or_id($retourid);
			$admin_email = $this->GetPreference('admin_email'); 
			$lien = $this->create_url($id,'default',$page, array("display"=>"password","genid"=>$genid, "feu_id"=>$feu_id));
			//echo $to;
			$subject = "Mot de passe perdu";//$this->GetPreference('email_activation_subject');
			$priority = 3;
			
			$montpl = $this->GetTemplateResource('reset_password_email.tpl');						
			$smarty = cmsms()->GetSmarty();
			// do not assign data to the global smarty
			$tpl = $smarty->createTemplate($montpl);
			$tpl->assign('lien',$lien);
			
			$output = $tpl->fetch();

			$cmsmailer = new \cms_mailer();
			$cmsmailer->reset();
			$cmsmailer->AddAddress($user_email);
			$cmsmailer->AddBCC($admin_email);
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
	        	$final_message.= "Un email a été envoyé !";
	        	echo '<div class="alert alert-success" role="alert">'.$final_message.'</div>';
	        }
						
		}
		else
		{
			$final_message.= "Pas d'adresse email trouvée !";
			echo '<div class="alert alert-danger" role="alert">'.$final_message.'</div>';
		}
		
	}
	
}
else
{
	/*ici on affiche le formulaire de récupération du mot de passe
	 * il y a seulement le nom et prénom à entrer
	 */
	 $nom = '';
	 $prenom = '';
	 
	 $tpl  = $smarty->CreateTemplate($this->GetTemplateResource('lost_password.tpl'), null, null, $smarty);
	 $tpl->assign('nom', $nom);
	 $tpl->assign('prenom', $prenom);
	 $tpl->assign('validation', false);
	 $tpl->assign('final_message', $final_message);
	 $tpl->display();
}
$smarty->assign('validation', $validation);
$smarty->assign('final_message', $final_message);
		

