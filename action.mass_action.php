<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
//var_dump($params['sel']);
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
			
			case "sms" :
				$id_sel = implode("-",$params['sel']);				
				$this->Redirect($id,'envoi_sms',$returnid, array("sel"=>$id_sel));
			break;
			
			case "activate" : 
				$adh_ops = new adherents_spid;
				//$id_sel = implode("-",$params['sel']);
				foreach($id_sel as $tab)
				{
					$adh_ops->activate($tab);
				}
				
				$this->Redirect($id,'defaultadmin',$returnid);
			break;
			
			case "desactivate" : 
				$adh_ops = new adherents_spid;
				foreach($params['sel'] as $licence)
				{
					$adh_ops->desactivate($licence);
				}
				
				$this->Redirect($id,'defaultadmin',$returnid);
			break;
			
			case "refresh" : 
				$adh_ops = new adherents_spid;
				foreach($params['sel'] as $licence)
				{
					$adh_ops->infos_adherent_spid($licence);
				}
				
				$this->Redirect($id,'defaultadmin',$returnid);
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