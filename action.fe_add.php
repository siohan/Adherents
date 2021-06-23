<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
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
	case "adhesion" :
		if(isset($params['record_id']) && isset($params['id_cotisation']))
		{
			//$adh = new adherents;
			$ref_action = $this->random_string(15);
			
			$query = "INSERT IGNORE INTO ".cms_db_prefix()."module_cotisations_belongs (ref_action, id_cotisation, genid) VALUES (?, ?, ?)";
			$dbresult = $db->Execute($query, array($ref_action, $params['id_cotisation'], $record_id));
			if($dbresult)
			{
				$this->SetMessage('Inscription ajoutée');
				//il faut ajouter un paiement avec une ref_action
				$paie_ops = new paiementsbis;
				$cotis_ops = new cotisationsbis;
				$module = 'Cotisations';
				$tableau = $cotis_ops->types_cotisations($params['id_cotisation']);
				$add_paiement = $paie_ops->add_paiement($username,$ref_action,$module,$tableau['nom'],$tableau['tarif']);
				/**/
				$this->Redirect($id, 'fe_adhesions', $returnid);
			}
			else
			{
				$this->SetMessage('une erreur est survenue');
				$this->Redirect($id, 'fe_adhesions', $returnid);
			}
		}
	break;
	
	
}

#
#EOF
#
?>