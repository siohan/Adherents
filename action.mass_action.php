<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
var_dump($params['sel']);
$db = cmsms()->GetDb();
if (isset($params['submit_massaction']) && isset($params['actiondemasse']) )
  {
     if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
      	{
        	
		switch($params['actiondemasse'])
		{
			case "email" :
				$id_sel = implode("-",$params['sel']);
				$this->Redirect($id,'envoi_emails',$returnid, array("sel"=>$id_sel));
			break;
	
			
	
      		}//fin du switch
  	}
	else
	{
		$this->SetMessage('PB de sélection de masse !!');
		$this->RedirectToAdminTab('adherents');
	}
}
/**/
#
# EOF
#
?>