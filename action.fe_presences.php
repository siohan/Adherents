<?php
if (!isset($gCms)) exit;
//debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
require_once(dirname(__FILE__).'/include/fe_menu.php');
$aujourdhui = date('Y-m-d');
global $themeObject;
$delete = '<img src="modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$modif = '<img src="modules/Adherents/images/edit.gif" class="systemicon" alt="Modifier" title="Modifier">';
$vrai = '<img src="modules/Adherents/images/true.gif" class="systemicon" alt="Vrai" title="Vrai">';
$interdit = '<img src="modules/Adherents/images/false.gif" class="systemicon" alt="Faux" title="Faux">';
$faux = '<img src="modules/Adherents/images/false2.gif" class="systemicon" alt="Faux" title="Faux">';

$db = cmsms()->GetDb();
$query = "SELECT id,nom, description, date_debut FROM ".cms_db_prefix()."module_presence_presence WHERE actif = 1 OR date_limite > ?";
$dbresult = $db->Execute($query,array($aujourdhui));
if($dbresult && $dbresult->RecordCount()>0)
{
	$insc_ops = new T2t_presence;
	$rowarray= array();
	$rowclass = '';
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->nom = $row['nom'];
		
		$onerow->description = $row['description'];
		$onerow->date_debut =  $row['date_debut'];
		$inscrit = $insc_ops->has_expressed($row['id'], $username);
		if(FALSE ===$inscrit )
		{
			$onerow->present = $this->CreateLink($id, 'fe_edit_reponse', $returnid, $faux, array("reponse"=>"1",'id_presence'=>$row['id'], 'genid'=>$username));
			$onerow->absent = $this->CreateLink($id, 'fe_edit_reponse', $returnid, $faux, array("reponse"=>"0",'id_presence'=>$row['id'], 'genid'=>$username));	
			
		}
		elseif($inscrit ==1)
		{
			$user_choice = $insc_ops->user_choice($row['id'], $username);
			if ($user_choice == 1)//l'adhérent a répondu Oui
			{
				$onerow->present = $this->CreateLink($id, 'fe_edit_reponse', $returnid, $vrai, array("reponse"=>"1",'id_presence'=>$row['id'], 'genid'=>$username));
				$onerow->absent = $this->CreateLink($id, 'fe_edit_reponse', $returnid, $faux, array("reponse"=>"0",'id_presence'=>$row['id'], 'genid'=>$username));
			}
			else
			{
				$onerow->present = $this->CreateLink($id, 'fe_edit_reponse', $returnid, $faux, array("reponse"=>"1",'id_presence'=>$row['id'], 'genid'=>$username));
				$onerow->absent = $this->CreateLink($id, 'fe_edit_reponse', $returnid, $vrai, array("reponse"=>"0",'id_presence'=>$row['id'], 'genid'=>$username));
			}
			
		
		}
		
	
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	echo $this->ProcessTemplate('fe_presence.tpl');
}
#
# EOF
#

?>