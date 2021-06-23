<?php
if (!isset($gCms)) exit;
//debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
require_once(dirname(__FILE__).'/include/fe_menu.php');
//echo "FEU : le user est : ".$username." ".$userid;
//$properties = $feu->GetUserProperties($userid);
//$email = $feu->LoggedInEmail();
//echo $email;
//var_dump($email);

$db = cmsms()->GetDb();
$gp_ops = new groups;
$groupes = $gp_ops->member_of_groups($username);

$query = "SELECT id, idepreuve, journee, ref_action, actif, statut  FROM ".cms_db_prefix()."module_compositions_journees  ORDER BY idepreuve ASC, journee ASC";

$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount()>0)
{
	$comp_ops = new compositionsbis;
	$rowarray= array();
	$rowclass = '';
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		//$onerow->nom = $row['nom'];
		$idepreuve = $comp_ops->get_idepreuve($row['ref_action']);
		$journee = $comp_ops->get_journee($row['ref_action']);
		$libelle = $comp_ops->details_epreuve($idepreuve);
		$onerow->ref_action = $row['ref_action'];
		$onerow->epreuve = $libelle['libelle'];//idepreuve;//$comp_ops->get_epreuve($ref_action);
		$onerow->journee = $comp_ops->get_journee($row['ref_action']);
		$eq = $comp_ops->capitaine_of_what($username, $idepreuve);
		//var_dump($eq);
		if($eq['friendlyname'] != '')
		{
			$onerow->equipe =  $eq['friendlyname'];//row['ref_equipe'];
		}
		else
		{
			$onerow->equipe =  $eq['libequipe'];//row['ref_equipe'];
		}
		
		//$onerow->genid =  $row['genid'];
		$onerow->details = $this->CreateLink($id, 'fe_view_compos', $returnid, 'Voir', array('ref_action'=>$row['ref_action'], 'record_id'=>$eq['equipe_id'], "idepreuve"=>$idepreuve));
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	echo $this->ProcessTemplate('fe_mes_compos.tpl');
}
#
# EOF
#

?>