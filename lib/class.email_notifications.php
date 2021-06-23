<?php
class email_notifications
{
	function __construct() {}
	function send_another_email($email,$licence, $nom,$prenom)
	{
		$prenom_joueur = $prenom;
		//$smarty->assign('prenom_joueur',$prenom);
		$adherents = cms_utils::get_module('Adherents');;
		$admin_email = $adherents->GetPreference('admin_email'); 
		//echo $to;
		$subject = $adherents->GetPreference('email_activation_subject');
		$message = $adherents->GetTemplate('newactivationemail_Sample');
		$body = $adherents->ProcessTemplateFromData($message);
		$headers = "From: ".$admin_email."\n";
		$headers .= "Reply-To: ".$admin_email."\n";
		$headers .= "Content-Type: text/html; charset=\"utf-8\"";
		if(mail($email, utf8_encode($subject), $body, $headers))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}//end of class

?>