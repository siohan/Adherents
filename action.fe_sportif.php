<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');//$username = $feu->GetUsername($userid);
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$asso_ops = new Asso_adherents;
$details = $asso_ops->details_adherent_by_genid($username);
$licence = $details['licence'];
var_dump($licence);
global $themeObject;
$ping = new Ping();
$saison = (isset($params['saison'])?$params['saison']:$ping->GetPreference('saison_en_cours'));
$mois_courant = date('m');

$db =& $this->GetDb();
$query= "SELECT advnompre, advclaof,pointres, vd,date_event,codechamp FROM ".cms_db_prefix()."module_ping_parties WHERE saison = ? AND licence = ?";//" ORDER BY date_event ASC";
$query.=" ORDER BY date_event DESC";
//echo $query;
$dbresult = $db->Execute($query, array($saison,$licence));

$rowarray= array();
$rowclass= '';
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {

	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->date_event= $row['date_event'];
	$onerow->advclaof= $row['advclaof'];
	$onerow->nom= $row['advnompre'];
	$onerow->codechamp= $row['codechamp'];
	$onerow->victoire= $row['vd'];
	$onerow->pointres= $row['pointres'];
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('resultats',
		$this->CreateLink($id,'user_results',$returnid,$contents = 'Tous ses résultats', array('licence'=>$username)));
//}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('retour',
$this->CreateReturnLink($id, $returnid,'Retour'));
$smarty->assign('items', $rowarray);
$smarty->assign('rafraichir',
			$this->CreateLink($id,'retrieve',$returnid, 'Rafraichir mes données', array("retrieve"=>"fftt",'record_id'=>$username)));
$smarty->assign('resultats',
$this->CreateLink($id,'user_results',$returnid, array('licence'=>$username)));
/**/
echo $this->ProcessTemplate('fe-sportif2.tpl');
//mon FFTT

?>