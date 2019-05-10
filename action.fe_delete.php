<?php
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
$error = 0;//on instancie un compteur d'erreurs
//on commence par vérifier que ts les éléments sont là
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
}
else
{
	$error++;
}
if(isset($params['obj']) && $params['obj'] !='')
{
	$obj = $params['obj'];
}
else
{
	$error++;
}
switch($obj) 
{
	case "commandes_cc_items" :
		$query = "DELETE FROM ".cms_db_prefix()."module_commandes_cc_items WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			$this->SetMessage('Article supprimé');
			$this->Redirect($id, 'default', $returnid, array("display"=>"fe_commandes"));
		}
		else
		{
			$this->SetMessage('une erreur est survenue');
			$this->Redirect($id, 'default', $returnid, array("display"=>"fe_commandes"));
		}
	break;
	
	case "option_belongs" : 
		if(isset($params['adherent']) && $params['adherent'] != '')
		{
			$adherent = $params['adherent'];
		}
		if(isset($params['id_inscription']) && $params['id_inscription'] != '')
		{
			$id_inscription = $params['id_inscription'];
		}
		$query = "DELETE FROM ".cms_db_prefix()."module_inscriptions_belongs WHERE id_inscription = ? AND id_option = ? AND genid = ?";
			$dbresult = $db->Execute($query, array($id_inscription,$record_id, $adherent));
			if($dbresult)
			{
				$this->SetMessage('Inscription à cette option supprimée');
				$this->Redirect($id, 'fe_inscriptions', $returnid, array("record_id"=>$params['adherent']));
			}
			else
			{
				$this->SetMessage('une erreur est survenue');
				$this->Redirect($id, 'fe_inscriptions', $returnid, array("record_id"=>$params['adherent']));
			}
		
	break;
	case "message" :
		$query = "UPDATE ".cms_db_prefix()."module_messages_recipients SET actif = 0 AND ar = 1 WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		$this->Redirect($id, 'fe_messages', $returnid, array("record_id"=>$username));
	break;
}

#
#EOF
#
?>