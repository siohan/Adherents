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
$delete = '<img src="modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$modif = '<img src="modules/Adherents/images/edit.gif" class="systemicon" alt="Modifier" title="Modifier">';
$vrai = '<img src="modules/Adherents/images/true.gif" class="systemicon" alt="Vrai" title="Vrai">';
$faux = '<img src="modules/Adherents/images/false.gif" class="systemicon" alt="Faux" title="Faux">';
$error = 0;
$comp_ops = new compositionsbis;
if(isset($params['ref_action']) && $params['ref_action'] !='')
{
	$ref_action = $params['ref_action'];
	//on va récupérer l'épreuve et la journée concernée.
	$idepreuve = $comp_ops->get_idepreuve($ref_action);
	$journee = $comp_ops->get_journee($ref_action);
	$smarty->assign('idepreuve', $idepreuve);
	$smarty->assign('journee', $journee);	
}
else
{
	$error++;
}
if(isset($params['ref_equipe']) && $params['ref_equipe'] !='')
{
	$ref_equipe = $params['ref_equipe'];
	$equipe = $comp_ops->get_equipe($ref_equipe);
	$smarty->assign('equipe', $equipe);
}
else
{
	$error++;
}

if($error <1)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id, ref_action, ref_equipe, genid, statut FROM ".cms_db_prefix()."module_compositions_compos_equipes WHERE ref_action = ? AND ref_equipe = ?";
	$dbresult = $db->Execute($query, array($ref_action, $ref_equipe));
	if($dbresult && $dbresult->RecordCount()>0)
	{


			$asso_ops = new Asso_adherents;
			$rowarray= array();
			$rowclass = '';
			while($row = $dbresult->FetchRow())
			{
				$onerow = new StdClass();
				$onerow->genid = $asso_ops->get_name($row['genid']);

				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
			}
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);

	}
		echo $this->ProcessTemplate('fe_details_compos.tpl');

	
}
else
{
	echo "Pas de résultats ou erreur requete !";
}



#
# EOF
#

?>