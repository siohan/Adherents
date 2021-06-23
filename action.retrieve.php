<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;

debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db =& $this->GetDb();
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//echo $username;

$service = new retrieve_ops();
$ping_ops = new ping_admin_ops();
$asso_ops = new Asso_adherents;

if(isset($params['record_id']) && $params['record_id'] == $username)
{
	$record_id = $params['record_id'];
	//on récupère la catégorie du joueur depuis le module adherent
	$cat = $this->get_cat($record_id);
	$lic = $asso_ops->details_adherent_by_genid($record_id);
	$licence = $lic['licence']; 
}
else
{
	echo 'pb !';
}
switch($params['retrieve'])
{
	case "spid" :
		
		
    			$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
			$dbretour = $db->Execute($query, array($licence));
			if ($dbretour && $dbretour->RecordCount() > 0)
			{
			    while ($row= $dbretour->FetchRow())
			      	{
					$player = $row['player'];
					
					
					$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
					$maj_spid = $ping_ops->compte_spid($licence);
					//var_dump($resultats);
				}

			}  
		$this->Redirect($id, 'fe_spid', $returnid, array("record_id"=>$record_id));		
	break;
	case "fftt" :
		
		
    			$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
			$dbretour = $db->Execute($query, array($licence));
			if ($dbretour && $dbretour->RecordCount() > 0)
			{
			    while ($row= $dbretour->FetchRow())
			      	{
					$player = $row['player'];					
					$resultats = $service->retrieve_parties_fftt($licence,$player,$cat);
					$maj_spid = $ping_ops->compte_fftt($licence);
					//var_dump($resultats);
				}

			}
		$this->Redirect($id, 'fe_user_results', $returnid, array("record_id"=>$record_id));
  		
	break;
		
	case "sit_mens" :
		
		
		$sit_mens = $service->retrieve_sit_mens($licence);
		//$this->SetMessage();
		$this->Redirect($id,'fe_sit_mens', $returnid, array("record_id"=>$record_id));		
		
	break;

	
}

?>