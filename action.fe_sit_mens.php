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
	$rowarray= array ();

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





#
# EOF
#
?>