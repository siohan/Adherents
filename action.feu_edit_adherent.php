<?php
if (!isset($gCms)) exit;

$db = cmsms()->GetDb();
global $themeObject;
$final_message = '';
$success = 1;

if( !empty($_POST) ) 
{
        if( isset($_POST['cancel']) ) 
	{
            $this->RedirectToAdminTab();
        }
	$error = 0;
	debug_display($_POST, 'Parameters');
	if(isset($_POST['id_group']) && $_POST['id_group'] >0)
	{
		$record_id = $_POST['id_group'];
		$id_group = $_POST['id_group'];
	}
	else
	{
		$error++;
	}
	if(isset($_POST['id_inscription']) && $_POST['id_inscription']>0)
	{
		$id_inscription = $_POST['id_inscription'];
	}
	else
	{
		$error++;
	}
	if(isset($_POST['email1']) && true == is_email($_POST['email1']))
	{
		$email1 = $_POST['email1'];
	}
	if(isset($_POST['email2']) && true == is_email($_POST['email2']))
	{
		$email2 = $_POST['email2'];
	}
	if($email1 != $email2)
	{
		//oups pb !!
		//on fait une redir
		$final_message.= "Les emails ne correspondent pas !!";
	}
	$portable = '';
	if(isset($_POST['portable']) && $_POST['portable'] !='')
	{
		$portable = $_POST['portable'];
	}
	
	$genid = $this->random_int(9);
	
	
	$actif = 0;
	$licence = $_POST['licence'];
	$nom = filter_var(strtoupper($_POST['nom']) , FILTER_SANITIZE_STRING);
	$prenom = $_POST['prenom'];
	$anniversaire = (!empty($_POST['anniversaire'])?$_POST['anniversaire']:"1800-01-01");
	$sexe = $_POST['sexe'];
	$adresse = $_POST['adresse'];
	$code_postal = $_POST['code_postal'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];
	$externe = 1;
	$aujourdhui = date('Y-m-d');
	$validation = true;
	
	$service = new Asso_adherents;
	
	
		$add_adherent = $service->add_adherent($genid,$actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe);
		if(true === $add_adherent)
		{
			$final_message.=" Membre ajouté. ";
			//on insère automatiquement le nouveau ds le gp par défaut 
			$gp_ops = new groups;
			$id_gp = $gp_ops->assign_user_to_group($record_id,$genid);
			if(false !== $id_gp)
			{
				$final_message.=" Inscrit dans le groupe.";
			}
			$cont_ops = new contact;
			//on met à jour les contacts de cet utilisateur
			$contact_mel = $cont_ops->add_contact($genid,'1',$email1,$description='');
			if($portable != '')
			{
				$contact_portable = $cont_ops->add_contact($genid,'2',$portable,$description='');
			}
			if($admin_valid == 0)// l'utilisateur est automatiquement poussé vers le module FEU
			{
				
			}
		}
		else
		{
			$error++;
		}
		
		if($error < 1)
		{
			//on envoie un mail pour la validation du compte
			$cg_ops = new CGExtensions;
			//var_dump($adherents);
			$retourid = $this->GetPreference('pageid_subscription');
			$page = $cg_ops->resolve_alias_or_id($retourid);
			$lien = $this->create_url($id,'default',$page, array("display"=>"activate",  "record_id"=>$genid, "id_group"=>$id_group, "id_inscription"=>$id_inscription));
			$montpl = $this->GetTemplateResource('activation_email.tpl');						
			$smarty = cmsms()->GetSmarty();
			// do not assign data to the global smarty
			$tpl = $smarty->createTemplate($montpl);
			$tpl->assign('lien',$lien);
		 	$output = $tpl->fetch();
			$subject = 'Activation de ton compte';
			$prioriy = 3;
		
			$cmsmailer = new \cms_mailer();			
			//$cmsmailer->SetSMTPDebug($flag = TRUE);
			$cmsmailer->AddAddress($email1, $name='');
	//		$cmsmailer->AddBCC('claude.siohan@gmail.com', $name="Webmaster RPF");
			$cmsmailer->IsHTML(true);
			$cmsmailer->SetPriority($priority);
			$cmsmailer->SetBody($output);
			$cmsmailer->SetSubject($subject);
			$cmsmailer->Send();
			
			$final_message = 'Votre demande a bien été envoyée. Vous allez recevoir un email pour activer votre compte.';
		}
		else
		{
			$success = 0;
			$final_message.=" Erreur(s) Email d'activation non envoyé";
		}
	$smarty->assign('validation', true);
	$smarty->assign('success', $success);
	//$this->GetPreference('message_after_selfregistration');
	$smarty->assign('final_message', $final_message);	
	
	
	
}
else
{
	debug_display($params, 'Parameters');
	
	//on fait qqs vérifs avant d'afficher le formulaire
	//les valeurs des champs par défaut
	$actif = 0;//activation via un lien envoyé par mail
	$genid = "";
	$licence = "";
	$nom = "";//$details['nom'];
	$prenom = "";//$details['prenom'];
	$anniversaire = date('Y-m-d');//$details['anniversaire'];
	$sexe = 'M';//$details['sexe'];
	$adresse = "";//$details['adresse'];
	$code_postal = "";//$details['code_postal'];
	$ville = "";//$details['ville'];
	$pays = 'France';//$details['pays'];
	$liste_sexe = array("M"=>"Masculin", "F"=>"Féminin");
	$portable = '';
	$email = '';
	$edit = 0;
	$image = '';
	
	$anniversaire = date('Y-m-d');
	
	$id_group = 0;
	if(isset($params['id_group']) && $params['id_group'] > 0)
	{
		$id_group = $params['id_group'];
	}
	$id_inscription = 0;
	if(isset($params['id_inscription']) && $params['id_inscription'] >0)
	{
		$id_inscription = $params['id_inscription'];
	}

}
$tpl = $smarty->CreateTemplate($this->GetTemplateResource('feu_edit_adherent.tpl'), null, null, $smarty);
$tpl->assign('record_id', $record_id);
$tpl->assign('id_inscription', $id_inscription);
$tpl->assign('id_group', $id_group);
$tpl->assign('genid', $genid);
$tpl->assign('actif', $actif);
$tpl->assign('nom', $nom);
$tpl->assign('licence', $licence);
$tpl->assign('prenom', $prenom);
$tpl->assign('sexe', $sexe);
$tpl->assign('anniversaire', $anniversaire);
$tpl->assign('liste_sexe', $liste_sexe);
$tpl->assign('adresse', $adresse);
$tpl->assign('code_postal', $code_postal);
$tpl->assign('ville', $ville);
$tpl->assign('pays', $pays);
$tpl->assign('image', $image);
$tpl->assign('email', $email);
$tpl->assign('portable', $portable);
$tpl->display();	

#
#EOF
#
?>