<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

$db = cmsms()->GetDb();
global $themeObject;
$asso_ops = new Asso_adherents;
$gp_ops = new groups;
$adhFeu = new AdherentsFeu;
$feu = cms_utils::get_module('FrontEndUsers');
$insc = cms_utils::get_module('Inscriptions');
$insc_ops = new T2t_inscriptions;
$cont_ops = new contact;
$redir = false;
$error = 0;
$message_final='';
// le record_id correspond au genid
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$activ = $asso_ops->activate($params['record_id']);
	if(true == $activ)
	{
		$message_final.= "Votre compte a été activé avec succès ! ";
		//on inclus le user ds FEU
		$genid = $params['record_id'];
		$email = $cont_ops->email_address($genid);		
		
		$details = $asso_ops->details_adherent_by_genid($params['record_id']);
	
		
		$day = date('j');
		$month = date('n');
		$year = date('Y')+5;
		$expires = mktime(0,0,0,$month, $day,$year);
		
		$nom = $asso_ops->clean_name($details['nom']);
		$prenom = str_replace("&#39", "",$details['prenom']);
		$prenom = $asso_ops->clean_name($details['prenom']);
		$nom_complet = strtolower($prenom. ''.$nom);
		
		$mot1 = $this->random_string(7);
		$motdepasse = 'A'.$mot1.'1';
		
		$member_id = $feu->GetUserID($nom_complet);
		if(!$member_id)
		{
			$add_user = $feu->AddUser($nom_complet, $motdepasse,$expires);//renvoit (true, $uid, l'id du user ds FEU ou FALSE)
			$member_id = $add_user[1];
			$message_final.=" <br />Utilisateur ajouté au module d'authentification(FEU)";
		}
		//il faut aussi mettre le feu_id ds le module adhérents
		$feu_id = $adhFeu->feu_id($genid, $member_id);
		if(isset($params['id_inscription']) && $params['id_inscription'] > 0)
		{
			$id_inscription = (int) $params['id_inscription'];
		}
		else
		{
			$error++;
		}
		
		
		
		//on regarde si l'utilisateur appartient aux groupes
		if(isset($params['id_group']) && $params['id_group'] > 0)
		{
			$id_group = (int) $params['id_group'];
			//on inclus l'utilisateur ds le groupe concerné du module Adherents
			$assign_user = $gp_ops->assign_user_to_group($id_group, $genid);
			//on va maintenant chercher le nom du groupe
			$details = $gp_ops->details_groupe($id_group);
			
			$admin_valid = $details['admin_valid'];
			$pageid_aftervalid = $details['pageid_aftervalid'];// c'est la page où on redirige le membre authentifié
			
			$gid = $feu->GetGroupId($details['nom']);
			$gid = (int) $gid;
			
			/* on peut maintenant assigner cet utilisateur au groupe ds FEU */
			$assign_gp = $feu->AssignUserToGroup($member_id,$gid);
			
			//on valide les éventuelles commandes passées (module Inscriptions)
			$valid_insc = $insc_ops->set_to_checked($genid,$id_inscriptions);
			if(true == $assign_gp)
			{
				$message_final.=" <br />Vous avez été ajouté au groupe FEU";
			}
			else
			{
				$message_final.=" <br />Erreur ! Vous n'avez pas été ajouté au groupe FEU";
				$error++;
			}
			/* on remplit les propriétés de lutilisateur */
			$feu->SetUserPropertyFull('email',$email, $member_id);
			$feu->SetUserPropertyFull('nom', $nom_complet,$member_id);
			$feu->SetUserPropertyFull('genid',$genid, $member_id);

			if(!empty($details['pageid_aftervalid']))
			{
				$redir = true;
			}

			if(false == $admin_valid)//Pas besoin d'une inter de l'admin pour envoyer les codes
			{
				$message_final.= "<br />Vous devriez recevoir un courriel avec vos identifiants.";
				
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
				$cmsmailer->AddAddress($email);
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
				$unchecked = $asso_ops->set_to_unchecked($genid);//on a besoin que l'admin vérifie, on met le statut a unchecked (check = 0)
			}
			
		}
		else
		{
			$error++;
		}
		
		
		$cg_ops = new CGExtensions;
		$page = $cg_ops->resolve_alias_or_id($pageid_aftervalid);
		
		$lien = $insc->create_url(cntnt01,'default',$page, array("id_group"=>$id_group,"id_inscription"=>$id_inscription, "genid"=>$params['record_id']));
		//var_dump($lien);
	}
	else
	{
		$message_final = 'Votre compte n\'a pas été activé !';
		$error++;
	}
}
else
{
	$message_final = "Identifiant inconnu ou absent !";
	$error++;
}
$tpl = $smarty->CreateTemplate($this->GetTemplateResource('feu_activation.tpl'), null, null, $smarty);
$tpl->assign('message_final',$message_final);
$tpl->assign('lien', $lien);
$tpl->assign('error', $error);
$tpl->display();

?>
