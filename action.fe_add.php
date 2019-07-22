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
	case "adhesion" :
		if(isset($params['genid']) && isset($params['id_cotisation']))
		{
			$query = "INSERT INTO ".cms_db_prefix()."module_cotisations_belongs (ref_action, id_cotisation, genid) VALUES (?, ?, ?)";
			$dbresult = $db->Execute($query, array($ref_action, $id_cotisation, $genid));
			if($dbresult)
			{
				$this->SetMessage('Inscription ajoutée');
				//il faut ajouter un paiement avec une ref_action
				$this->Redirect($id, 'default', $returnid, array("display"=>"fe_adhesions"));
			}
			else
			{
				$this->SetMessage('une erreur est survenue');
				$this->Redirect($id, 'default', $returnid, array("display"=>"fe_adhesions"));
			}
		}
	break;
	
	
}

#
#EOF
#
?>