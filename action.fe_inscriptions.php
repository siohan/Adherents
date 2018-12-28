<?php
if (!isset($gCms)) exit;
//debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserName($userid);
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
$query = "SELECT id,nom, description, date_debut FROM ".cms_db_prefix()."module_inscriptions_inscriptions WHERE actif = 1";
$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount()>0)
{
	$insc_ops = new T2t_inscriptions;
	$rowarray= array();
	$rowclass = '';
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->nom = $row['nom'];
		
		$onerow->description = $row['description'];
		$onerow->date_debut =  $row['date_debut'];
		$inscrit = $insc_ops->is_inscrit($row['id'], $username);
		if(FALSE ===$inscrit )
		{
			$onerow->is_inscrit = $faux;
			$onerow->details = $this->CreateLink($id, 'fe_details_inscription', $returnid, 'M\'inscrire', array("details"=>"0",'id_inscription'=>$row['id'], 'licence'=>$username));
		}
		else
		{
			$onerow->is_inscrit = $vrai;
			$onerow->details = $this->CreateLink($id, 'fe_details_inscription', $returnid, 'Détails', array("details"=>"1",'id_inscription'=>$row['id'], 'licence'=>$username));
		}
	
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	echo $this->ProcessTemplate('fe_inscriptions.tpl');
}
#
# EOF
#

?>