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

$db = cmsms()->GetDb();
$gp_ops = new groups;
$groupes = $gp_ops->member_of_groups($username);

$query = "SELECT id,nom, description, date_debut FROM ".cms_db_prefix()."module_inscriptions_inscriptions WHERE actif = 1 AND date_limite >= CURRENT_DATE()";
if(FALSE !== $groupes)
{
	if(is_array($groupes) && count($groupes) > 0 )
	{
		$tab = implode(', ',$groupes);	
		$query.= " AND groupe IN ($tab)";
	}
	else
	{
		$query.= " AND groupe = $tab";
	}
	
	$dbresult = $db->Execute($query);
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$insc_ops = new T2t_inscriptions;
		$rowarray= array();
		$rowclass = '';
		$smarty->assign('nb_results', true);
		
		while($row = $dbresult->FetchRow())
		{
			$onerow = new StdClass();
			$onerow->nom = $row['nom'];
			$onerow->id_inscription = $row['id'];
			$onerow->description = $row['description'];
			$onerow->date_debut =  $row['date_debut'];
			$inscrit = $insc_ops->is_inscrit($row['id'], $username);
			var_dump($inscrit);
			
			$onerow->is_inscrit = $inscrit;

			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		
	}
}
else
{
	$smarty->assign('nb_results', false);
}
echo $this->ProcessTemplate('fe_inscriptions.tpl');
#
# EOF
#

?>