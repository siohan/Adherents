<?php
if( !isset($gCms) ) exit;
echo 'Ok !';
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');

global $themeObject;
$ping = new Ping();
$saison = (isset($params['saison'])?$params['saison']:$ping->GetPreference('saison_en_cours'));
$mois_courant = date('m');

$db =& $this->GetDb();
$query= "SELECT nom, classement,pointres, victoire,date_event,epreuve,numjourn FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND MONTH(date_event) = ? AND licence = ?";//" ORDER BY date_event ASC";
$query.=" ORDER BY date_event DESC";
echo $query;
$dbresult = $db->Execute($query, array($saison,$mois_courant,$username));

$rowarray= array();

if ($dbresult && $dbresult->RecordCount() > 0)
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
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('resultats',
		$this->CreateLink($id,'user_results',$returnid,$contents = 'Tous ses résultats', array('licence'=>$licence)));
}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('retour',
$this->CreateReturnLink($id, $returnid,'Retour'));
$smarty->assign('items', $rowarray);

$smarty->assign('resultats',
$this->CreateLink($id,'user_results',$returnid, array('licence'=>$licence)));
/**/
echo $this->ProcessTemplate('fe-sportif.tpl');
//mon FFTT

?>