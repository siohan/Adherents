<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$db =& $this->GetDb();
global $themeObject;
if(!isset($params['record_id']) || $params['record_id'] != $username)
{
	echo "Erreur !";
}
else
{
	$licence = $params['record_id'];
	$ping = cms_utils::get_module('Ping');
	$pong = new ping_admin_ops;
	$sit = $pong->get_sit_mens($licence, date('m'), date('Y'));
	$saison = (isset($params['saison'])?$params['saison']:$ping->GetPreference('saison_en_cours'));
//	var_dump($sit);
	if(FALSE === $sit)
	{
		$smarty->assign('sit_mens', $this->CreateLink($id, 'retrieve', $returnid, 'Rafraichir', array("retrieve"=>"sit_mens", "record_id"=>$username)));
	}
	else
	{
		$smarty->assign('sit_mens', $sit);
	}

	$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ?";//" WHERE annee = ? AND mois = ?";
	$dbresult = $db->Execute($query, array($licence));

	$rowclass= 'row1';
	$rowarray= array();

	if ($dbresult && $dbresult->RecordCount() > 0)
	{
	    	while ($row= $dbresult->FetchRow())
		{
			$dbresult2[] = $row;
		}
		//var_dump($dbresult2);
	}
	else
	{
		echo "<p>Pas de résultats disponibles.</p>";
	}
	echo $this->ProcessTemplate('fe_sit_mens.tpl');
}
//on fait une deuxième requete avec l'ensemble des situations completes de la saison
$query2 = "SELECT CONCAT_WS('/', mois, annee) AS date_sit_mens, clglob, licence,aclglob, points, apoint, clnat, rangreg, rangdep, progmois, progmoisplaces, progann FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND saison = ?";
$dbresult2 = $db->Execute($query2, array($licence, $saison));
if($dbresult2)
{
	$rowarray2 = array();
	if($dbresult2->RecordCount()>0)
	{
		while($row2 = $dbresult2->FetchRow())
		{
			$onerow2 = new StdClass;
			$onerow2->date_sit_mens = $row2['date_sit_mens'];
			$onerow2->aclglo = $row2['aclglob'];
			$onerow2->apoint = $row2['apoint'];
			$onerow2->clnat = $row2['clnat'];
			$onerow2->rangreg = $row2['rangreg'];
			$onerow2->rangdep = $row2['rangdep'];
			$onerow2->progmois = $row2['progmois'];
			$onerow2->progmoisplaces = $row2['progmoisplaces'];
			$onerow2->progann = $row2['progann'];
			$rowarray2[]= $onerow2;
		}
		$smarty->assign('items2', $rowarray2);
		$smarty->assign('itemsfound2', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount2', count($rowarray2));
		echo $this->ProcessTemplate('fe_sit_mens2.tpl');
	}
	else
	{
		echo 'pas de résultats disponibles !';
	}
}
else
{
	echo 'erreur ds la requete !';
}





#
# EOF
#
?>