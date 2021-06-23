<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();

$final_message = '';

/* l'utilisateur ne connait plus son mot de passe !! 
 * On affiche un formulaire avec le nom et le prénom de l'utilisateur (deux champs donc)
 */
if( !empty($_POST) ) 
{
    if( isset($_POST['cancel']) ) 
	{
        //$this->RedirectToAdminTab();
    }
	
	$error = 0;
	$err_msg = '';
	$validation = 1;
	$smarty->assign('validation', $validation);
	//debug_display($_POST, 'Parameters');
	if(isset($_POST['genid']) && $_POST['genid'] >0)
	 {
		 $genid = (int) $_POST['genid'];
		 
	 }
	 else
	 {
		 $error++;
		 $err_msg.= "Genid";
	 }
	 if(isset($_POST['feu_id']) && $_POST['feu_id'] >0)
	 {
		 $feu_id = (int) $_POST['feu_id'];
		 $err_msg.= "feu_id";
	 }
	 else
	 {
		 $error++;
	 }
	 if(isset($_POST['password1']) && $_POST['password1'] !='')
	 {
		 $password1 = $_POST['password1'];
		 $err_msg.= "password1";
	 }
	 else
	 {
		 $error++;
	 }
	 if(isset($_POST['password2']) && $_POST['password2'] !='')
	 {
		 $password2 = $_POST['password2'];
		 $err_msg.= "password2";
	 }
	 else
	 {
		 $error++;
	 }
	 if($password1 != $password2)
	 {
		$error++;
		$err_msg.= "Correspondance";
		$final_message.="Les mots de passe ne correspondent pas !"; 
		echo '<div class="alert alert-danger" role="alert">'.$final_message.'</div>';
	 }
	 
	if($error < 1)
	{
			//tout va bien on peut continuer...
			
			$feu = cms_utils::get_module('FrontEndUsers');
			$new_password = $feu->SetUserPassword($feu_id, $password1);
			var_dump($new_password);
			if(true == $new_password[0])
			{
				$final_message.=" Votre mot de passe a été modifié avec succès !";
			}
			else
			{
				$final_message.= "le mot de passe n'a pas été accepté !";
			}
			echo '<div class="alert alert-success" role="alert">'.$final_message.'</div>';
	}
	else
	{
		echo '<div class="alert alert-danger" role="alert">'.$final_message.'</div>';
	}
	
	
	
	
	
}
else
{
	
	/*ici on affiche le formulaire de reset du mot de passe
	 * 
	 */
	 $validation = 0;
	 $error = 0;
	 if(isset($params['genid']) && $params['genid'] >0)
	 {
		 $genid = $params['genid'];
	 }
	 else
	 {
		 $error++;
	 }
	 if(isset($params['feu_id']) && $params['feu_id'] >0)
	 {
		 $feu_id = $params['feu_id'];
	 }
	 else
	 {
		 $error++;
	 }
	 //on pourrait aussi vérifier que le genid correspond bien au feu_id
	 $asso_ops = new Asso_adherents;
	 $check = $asso_ops->check_genid_feu_id($genid, $feu_id);
	 if(false == $check)
	 {
		 $final_message.=" Un problème de sécurité est apparu ! Contacter le webmaster...";
		 echo '<div class="alert alert-danger" role="alert">'.$final_message.'</div>';
	 }
	 else
	 {
		$password1 = '';
		$password2 = '';
	 
		$tpl  = $smarty->CreateTemplate($this->GetTemplateResource('reset_password.tpl'), null, null, $smarty);
		$tpl->assign('genid', $genid);
		$tpl->assign('feu_id', $feu_id);
		$tpl->assign('password1', $password1);
		$tpl->assign('password2', $password2);
		$tpl->display();
	}
}
