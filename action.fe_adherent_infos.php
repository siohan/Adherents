<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserName($userid);

require_once(dirname(__FILE__).'/include/fe_menu.php');

$db =& $this->GetDb();
global $themeObject;
$licence = '';
$edition = 0;
$OuiNon = array("Oui"=>"1","Non"=>"0");
if(isset($params['record_id']) && $params['record_id'] != '' && $params['record_id'] == $username)
{
	$edition = 1;
	$record_id = $params['record_id'];
	
	$query  = "SELECT licence,actif,fftt, anniversaire,nom, prenom, adresse, code_postal, ville FROM ".cms_db_prefix()."module_adherents_adherents WHERE licence = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			//$compt++;
			
			$onerow = new StdClass();
			$onerow->licence = $row['licence'];
			$onerow->nom = $row['nom'];
			$onerow->prenom = $row['prenom'];
			$onerow->fftt = $row['fftt'];
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
	
				
		//$query.=" ORDER BY date_compet";
	echo $this->ProcessTemplate('adherent_infos.tpl');
	}
	elseif(!$dbresult)
	{
		echo $db->ErrorMsg();
	}
	
}
else
{
	echo "une erreur s'est produite !";
}


	







#
#EOF
#
?>