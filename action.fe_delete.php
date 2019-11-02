<?php
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
$error = 0;//on instancie un compteur d'erreurs
//on commence par vérifier que ts les éléments sont là
debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
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
	
	case "cotisation" :
		if(isset($params['ref_action']) && $params['ref_action'] != '')
		{
			$ref_action = $params['ref_action'];
		}
		$query = "DELETE FROM ".cms_db_prefix()."module_cotisations_belongs WHERE ref_action = ?";
			$dbresult = $db->Execute($query, array($ref_action));
			if($dbresult)
			{
				$this->SetMessage('Adhésion supprimée');
				$this->Redirect($id, 'fe_adhesions', $returnid, array("record_id"=>$username));
			}
			else
			{
				$this->SetMessage('une erreur est survenue');
				$this->Redirect($id, 'fe_adhesions', $returnid, array("record_id"=>$username));
			}
	break;
	
	case "fe_lock_unlock" :
	{
		$error = 0;if(isset($params['ref_action']) && $params['ref_action'] != '')
		{
			$ref_action = $params['ref_action'];
		}
		else
		{
			$error++;
		}
		if(isset($params['ref_equipe']) && $params['ref_equipe'] != '')
		{
			$ref_equipe = $params['ref_equipe'];
		}
		else
		{
			$error++;
		}
		if(isset($params['statut']) && $params['statut'] != '')
		{
			$statut = $params['statut'];
		}
		else
		{
			$error++;
		}
		if($error <1)
		{
			$query = "UPDATE ".cms_db_prefix()."module_compositions_compos_equipes SET statut = ? WHERE ref_action = ? AND ref_equipe = ?";
			$dbresult = $db->Execute($query, array($statut,$ref_action, $ref_equipe));
			if($dbresult)
			{
				$this->SetMessage('Changement de statut Ok');
			}
		}
		else
		{
			$this->SetMessage('une erreur est survenue');
		}
		
		$this->Redirect($id, 'fe_compos_equipes', $returnid, array("record_id"=>$username));
	}
}

#
#EOF
#
?>