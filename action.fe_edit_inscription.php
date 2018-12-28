<?php
if (!isset($gCms)) exit;
debug_display($params,'Parameters');
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
if(isset($params['id_inscription']) && $params['id_inscription'] !='')
{
	$id_inscription = $params['id_inscription'];
	//choix multi ou pas ?
	$insc_ops = new T2t_inscriptions;
	$details = $insc_ops->details_inscriptions($id_inscription);
	$choix_multi = $details['choix_multi'];
	var_dump($choix_multi); 
}
$details=1;
if(isset($params['details']) && $params['details'] !='')
{
	$details = $params['details'];
}

$db = cmsms()->GetDb();
$query = "SELECT id,nom, description, date_debut, tarif FROM ".cms_db_prefix()."module_inscriptions_options AS opt WHERE id_inscription = ? AND actif = 1 ";
$dbresult = $db->Execute($query, array($id_inscription));
if($dbresult && $dbresult->RecordCount()>0)
{
	if($details ==1)//on affiche le détail sans permettre de changer
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
			$inscrit = $insc_ops->is_inscrit_opt($row['id'], $username);
			if(FALSE ===$inscrit )
			{
				$onerow->is_inscrit = $faux;
			
			}
			else
			{
				$onerow->is_inscrit = $vrai;
			
			}

			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		echo $this->ProcessTemplate('fe_details_inscriptions.tpl');
	}
	else //on affiche le formulaire
	{
		$smarty->assign('id_inscription', 
				$this->CreateInputHidden($id, 'id_inscription', $id_inscription));
		$smarty->assign('licence', 
				$this->CreateInputHidden($id, 'licence', $username));//attention choix multi ou pas ?
		while($row = $dbresult->FetchRow())
		{
			if($choix_multi == 0)//bouton radio
			{
				$smarty->assign($row['nom']);

			}
			else
			{
				//bouton checkbox
			}
	}
}


#
# EOF
#

?>