<?php
if( !isset($gCms)) exit;
debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');

$db =& $this->GetDb();
debug_display($params, 'Parameters');
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];

}
$commandes = new commandes();
$query = "UPDATE ".cms_db_prefix()."module_commandes_cc_items SET user_validation =  1 WHERE id = ? AND genid = ?";
$dbresult= $db->Execute($query, array($record_id, $username));
if($dbresult)
{
	
	//on va chercher les infos pour les mettre dans le message au gestionnaire des commandes
	
	$query2 = "SELECT it.fournisseur, it.categorie_produit, it.libelle_commande, it.quantite, it.ep_manche_taille, it.couleur, it.prix_total FROM ".cms_db_prefix()."module_commandes_cc_items AS it WHERE id = ? AND genid = ?";
	$dbresult2 = $db->Execute($query2, array($record_id, $username));
	$rowclass= 'row1';
	$rowarray= array();
	if(!$dbresult2)
	{
		echo $this->ErrorMsg();
	}
	else
	{
		while($row = $dbresult2->FetchRow())
		{
			$fournisseur = $row['fournisseur'];		
			$categorie_produit = $row['categorie_produit'];			
			$libelle_commande = $row['libelle_commande'];		
			$quantite = $row['quantite'];		
			$ep_manche_taille = $row['ep_manche_taille'];		
			$couleur = $row['couleur'];		
			$prix_total = $row['prix_total'];		
		}
		
	}
	
	$montpl = $this->GetTemplateResource('orig_newcommandemail_Sample.tpl');						
	$smarty = cmsms()->GetSmarty();
	// do not assign data to the global smarty
	$tpl = $smarty->createTemplate($montpl);
	$tpl->assign('fournisseur', $fournisseur);
	$tpl->assign('categorie_produit', $categorie_produit);
	$tpl->assign('libelle_commande', $libelle_commande);
	$tpl->assign('quantite', $quantite);
	$tpl->assign('ep_manche_taille', $ep_manche_taille);
	$tpl->assign('couleur', $couleur);
	$output = $tpl->fetch();
	
	$user_email = $feu->LoggedInEmail();
	$admin_email = $commandes->GetPreference('admin_email'); 
	//echo $to;
	$subject = $commandes->GetPreference('new_command_subject');
	
	$cmsmailer = new \cms_mailer();
	$cmsmailer->reset();
	$cmsmailer->AddAddress($admin_email);
//	$cmsmailer->AddAddress('claude@agi-webconseil.fr');
	//$cmsmailer->AddAddress($admin_email);
	//$cmsmailer->AddAddress($admin_email);
	$cmsmailer->SetBody($output);
	$cmsmailer->SetSubject($subject);
	$cmsmailer->IsHTML(true);
	$cmsmailer->SetPriority(1);
	$cmsmailer->Send();
	$res = true;
	$sent = 0; //par défaut on indique le message à non envoyé sent = 0;
	if($cmsmailer->IsError())
	{
		$res = false;
		
		$this->SetMessage('Email non envoyé au gestionnaire');
		$sent = 0;
		$status = "Email absent";
	}
	else
	{	
		$this->SetMessage('Email  envoyé au gestionnaire');
		$sent = 1;
		$status = "Ok";
	}
	$senddate = date('Y-m-d');
	$sendtime = date('H:i:s');
	$replyto = $user_email;
	$group_id = 0;
	$recipients_number = 1;
	// sujet déjà défini plus haut
	// idem pour le message
	$ar = 0;
	$mess_ops = new T2t_messages;
	$priority = 3;
	$timbre = time();
	$relance = 0;
	$occurence = 0; 
	$mess_ops->add_message($user_email, $senddate, $sendtime, $replyto, $group_id,$recipients_number, $subject, $message, $sent, $priority, $timbre, $ar, $relance, $occurence);
	$message_id = $db->Insert_ID();
	echo $message_id;
	$mess_ops->add_messages_to_recipients($message_id, '0', $admin_email,$sent,$status, $ar);
	//echo 'résultat : '.$res;
	$this->Redirect($id, 'default', $returnid, array("display"=>"fe_commandes"));
}
else
{
	echo "pas cool !";
}
