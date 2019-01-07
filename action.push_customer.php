<?php
if( !isset($gCms) ) exit;
//echo "Cool !";
//debug_display($params, 'Parameters');
$designation = '';//le message de fin....
$feu = cms_utils::get_module('FrontEndUsers');
//$feu = new FrontEndUsers();
$error = 0;//on instancie un compteur d'erreurs
// variables à contrôler :  l'email , la licence
if(isset($params['nom']) && $params['nom'] !='')
{
	$nom = str_replace(" ", "",$params['nom']);
}
if(isset($params['prenom']) && $params['prenom'] !='')
{
	$prenom = str_replace(" ", "",$params['prenom']);
}
$nom_complet = strtolower($prenom. ''.$nom);
if(isset($params['genid']) && $params['genid'] !='')
{
	$genid = $params['genid'];
}
else
{
	$error++;
}
if(isset($params['email']) && $params['email'] !='')
{
	$user_email = $params['email'];
}
else
{
	$error++;
}
//echo $error;
if($error<1)
{
	//on fait le job
	//on ajoute le groupe
	$group_exists = $feu->GroupExistsByName('adherents');
	$feu->SetPreference('username_is_email',0);
	if(FALSE === $group_exists)
	{
		$feu->AddGroup('adherents', 'les adhérents du club');
		
		/* On récupère l'id du group créé à savoir adherents */
		$gid = $feu->GetGroupId('adherents');
		
		/*
		on créé les propriétés de ce groupe à savoir
		1- Ton email
		2- Ton nom
		*/
		$name = "email";
		$prompt = "Ton email";
		$type = 2;//0 = text; 1 = checkbox; 2 = email;3 = textarea; 4,5 = count(options)?;6 = image;7= radiobuttons; 8= date
		$length = 80;
		$maxlength = 255;		
		$feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = 0, $encrypt = 0 );
		
		$sortkey = 1;
		$required = 2; //2= requis, 1 optionnel, 0 = off
		/* on peut assigner les propriétés au groupe adhérents */
		$feu->AddGroupPropertyRelation($gid,$name,$sortkey, -1, $required);
		
		/*On fait la même chose pour la deuxième propriété */
		$name = "nom";
		$prompt = "Ton nom";
		$type = 0;
		$length = 80;
		$maxlength = 255;		
		$feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = 0, $encrypt = 0 );
		
		$sortkey = 1;
		$required = 2; //2= requis, 1 optionnel, 0 = off
		/* on peut assigner les propriétés au groupe adhérents */
		$feu->AddGroupPropertyRelation($gid,$name,$sortkey, -1, $required);
		
		/*On fait la même chose pour la troisième propriété */
		$name = "genid";
		$prompt = "Ton ID";
		$type = 0;
		$length = 10;
		$maxlength = 15;		
		$feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = 0, $encrypt = 0 );
		
		$sortkey = 1;
		$required = 0; //2= requis, 1 optionnel, 0 = off
		/* on peut assigner les propriétés au groupe adhérents */
		$feu->AddGroupPropertyRelation($gid,$name,$sortkey, -1, $required);
		
	}
	
	$day = date('j');
	$month = date('n');
	$year = date('Y')+5;
	$expires = mktime(0,0,0,$month, $day,$year);
	//on créé un mot de passe
	$mot1 = $this->random_string(8);
	$motdepasse = $mot1.'1';
	//qqs variables pour le mail
	$smarty->assign('prenom_joueur', $prenom);
	$smarty->assign('nom_joueur' , $nom);
	$smarty->assign('nom_complet', $nom_complet);
	//$motdepasse = 'UxzqsUIM1';
	$smarty->assign('motdepasse', $motdepasse);
	
	//$add_user = $feu->AddUser($licence, $motdepasse,$expires);
	$add_user = $feu->AddUser($nom_complet, $motdepasse,$expires);
	
	//on récupère le userid ($uid)
	$uid = $feu->GetUserId($nom_complet);
	//on force le changement de mot de passe ?
	$feu->ForcePasswordChange($uid, $flag = TRUE);	
	$gid = $feu->GetGroupId('adherents');
	/* on peut maintenant assigner cet utilisateur au groupe */
	$feu->AssignUserToGroup($uid,$gid);
	/* on remplit les propriétés de lutilisateur */
	$feu->SetUserPropertyFull('email',$user_email, $uid);
	$feu->SetUserPropertyFull('nom', $nom_complet,$uid);
	$feu->SetUserPropertyFull('genid',$genid, $uid);
	
	/* On essaie d'envoyer un message à l'utilisateur pour lui dire qu'il est enregistré */	

	$admin_email = $this->GetPreference('admin_email'); 
	//echo $to;
	$subject = $this->GetPreference('email_activation_subject');
	$message = $this->GetTemplate('newactivationemail_Sample');
	$body = $this->ProcessTemplateFromData($message);
	$headers = "From: ".$admin_email."\n";
	$headers .= "Reply-To: ".$admin_email."\n";
	$headers .= "Content-Type: text/html; charset=\"utf-8\"";
	/*
	$headers = 'From: claude.siohan@gmail.com' . "\r\n" . 'Reply-To: claude.siohan@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
	*/
	$designation.= 'Compte actif pour ! '.$prenom;
	if(mail($user_email, utf8_encode($subject), $body, $headers))
	{
	
		$designation.= ' Email envoyé !';
	
	}
	
	$this->SetMessage($designation);
	$this->RedirectToAdminTab('feu');
	
}
else
{
	//les conditions ne sont pas remplis, on renvoit à la page précédente
	//echo $error;
	$this->SetMessage('parametres manquants');
	$this->Redirect($id, 'defaultadmin',$returnid, array("activetab"=>"feu"));
}


# EOF
#

?>