<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$record_id = '';
$date_event = '';
$affiche = 1;
$current_month = date('n');
$current_day = date('d');
$asso_ops = new Asso_adherents;
if($current_day < 10)
{
	$current_month = $current_month-1;
}

	if(isset($params['record_id']) && $params['record_id'] !='' )
	{
	
		$record_id = $params['record_id'];
		$lic = $asso_ops->details_adherent_by_genid($record_id);
		$licence = $lic['licence'];
		$ping = cms_utils::get_module('Ping');
		$saison_courante = $ping->GetPreference('saison_en_cours');
		
		$query3= "SELECT nom, classement,pointres, victoire,date_event,epreuve,numjourn FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ? ";
		$parms['saison'] = $saison_courante;
		$parms['licence'] = $licence;		
		
		$query3.=" AND MONTH(date_event) = ?";
		$parms['month'] = $current_month;
		$query3.=" ORDER BY date_event DESC";
			
		$dbresult3 = $db->Execute($query3, $parms);
		
		$rowarray= array();
		$rowclass = 'row1';
		if ($dbresult3 && $dbresult3->RecordCount() > 0)
		  {
		    while ($row= $dbresult3->FetchRow())
		      {
	
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->date_event= $row['date_event'];
			$onerow->epreuve= $row['epreuve'];
			$onerow->nom= $row['nom'];
			$onerow->classement= $row['classement'];
			$onerow->victoire= $row['victoire'];
			$onerow->pointres= $row['pointres'];
			$rowarray[]= $onerow;
		      }
		  }
	
	}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('retour',
 		$this->CreateReturnLink($id, $returnid,'Retour'));
$smarty->assign('items', $rowarray);
$smarty->assign('resultats',
		$this->CreateLink($id,'spid',$returnid,$contents = 'Tous ses résultats', array('record_id'=>$licence)));
$smarty->assign('rafraichir',
			$this->CreateLink($id,'retrieve',$returnid, 'Rafraichir mes données ou recalculer', array("retrieve"=>"spid",'record_id'=>$record_id)));
echo $this->ProcessTemplate('fe_spid.tpl');


#
# EOF
#
?>