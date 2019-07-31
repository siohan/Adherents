<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//echo $username;
require_once(dirname(__FILE__).'/include/fe_menu.php');

$db =& $this->GetDb();
global $themeObject;
$licence = '';
$edition = 0;
$rowclass='row1';
$OuiNon = array("Oui"=>"1","Non"=>"0");

	
	$query  = "SELECT licence,actif, anniversaire,nom, prenom, adresse, code_postal, ville FROM ".cms_db_prefix()."module_adherents_adherents WHERE genid = ?";
	$dbresult = $db->Execute($query, array($username));
	if($dbresult)
	{
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			//$compt++;
			
			$onerow = new StdClass();
			$onerow->licence = $row['licence'];
			$onerow->nom = $row['nom'];
			$onerow->prenom = $row['prenom'];
			$onerow->adresse = $row['adresse'];
			$onerow->code_postal = $row['code_postal'];
			$onerow->ville = $row['ville'];
			$onerow->anniversaire = $row['anniversaire'];
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);			
		$smarty->assign('fe_edit', $this->CreateLink($id, 'fe_edit_adherent', $returnid, 'Modifier', array("record_id"=>$username)));
				
		//$query.=" ORDER BY date_compet";
	echo $this->ProcessTemplate('adherent_infos.tpl');
	}
	elseif(!$dbresult)
	{
		echo $db->ErrorMsg();
		echo "une erreur s'est produite !";
	}
	

#
#EOF
#
?>