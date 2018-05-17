<?php
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
$error = 0;//on instancie un compteur d'erreurs
//on commence par vérifier que ts les éléments sont là

if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
	
	
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
}
#
#EOF
#
?>