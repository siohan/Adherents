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
$eq_ops = new equipes_comp;

//$groupes = $gp_ops->member_of_groups($username);

$query = "SELECT id,ref_action, ref_equipe, genid, statut FROM ".cms_db_prefix()."module_compositions_compos_equipes WHERE genid = ?";

$dbresult = $db->Execute($query, array($username));
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
		$libelle = $comp_ops->details_epreuve($idepreuve);
		$details = $eq_ops->details_equipe($row['ref_equipe']);
		$onerow->ref_action = $row['ref_action'];
		$onerow->epreuve = $libelle['libelle'];//idepreuve;//$comp_ops->get_epreuve($ref_action);
		$onerow->journee = $comp_ops->get_journee($row['ref_action']);
		$onerow->equipe =  $details['friendlyname'];
		$onerow->genid =  $row['genid'];
		$onerow->details = $this->CreateLink($id, 'fe_details_compos', $returnid, 'Détails', array('ref_action'=>$row['ref_action'], 'record_id'=>$row['ref_equipe']));
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	echo $this->ProcessTemplate('fe_compos_equipes.tpl');
}
#
# EOF
#

?>