<?php

if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$error = 0;
if(isset($params['destinataires']) && $params['destinataires'])
{
	$destinataires = $params['destinataires'];
}
else
{
	$error++;
}
if(isset($params['from']) && $params['from'])
{
	$from = $params['from'];
}
else
{
	$error++;
}
if(isset($params['priority']) && $params['priority'])
{
	$priority = $params['priority'];
}
else
{
	$error++;
}
if(isset($params['sujet']) && $params['sujet'])
{
	$sujet = $params['sujet'];
}
else
{
	$error++;
}

if(isset($params['message']) && $params['message'])
{
	$message = $params['message'];
}	
else
{
	$error++;
}
if($error >0)
{
	//pas glop, des erreurs !
	echo "trop d\'erreurs !";
}
else
{
	// on commence le traitement
	$tab = explode(',', $destinataires);
	var_dump($tab);
	

	foreach($tab as $item=>$v)
	{
	
	//var_dump($item);
	
		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
		$cmsmailer->SetFrom($from);//$this->GetPreference('admin_email'));
		$cmsmailer->AddAddress($v,$name='');
		$cmsmailer->IsHTML(false);
		$cmsmailer->SetPriority($priority);
		$cmsmailer->SetBody($message);
		$cmsmailer->SetSubject($sujet);
		$cmsmailer->Send();
                if( !$cmsmailer->Send() ) {
                    audit('',$this->GetName(),'Problem sending email to '.$item);
                    
                }
	}
}

