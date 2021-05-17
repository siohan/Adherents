<?php
if(!isset($gCms) ) exit;
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
//$username = $feu->GetUserProperty('genid');
$adh_feu = new AdherentsFeu;
$username =$adh_feu->get_genid($userid);
var_dump($username);
//$username = (int) $params['genid'];//c'est le genid du module adherents


//um menu ?
require_once(dirname(__FILE__).'/include/fe_menu.php');
//avec un contenu par défaut !
//le spid ?
//go pour le spid
$ping = cms_utils::get_module('Ping');
if( is_object( $ping ))
{
	$saison = (isset($params['saison'])?$params['saison']:$ping->GetPreference('saison_en_cours'));
	//echo $saison;

	$mois_courant = date('m');
	//mon spid
	//un lien pour récupérer mes parties spid ? Go !

	$db = cmsms()->GetDb();
	//on fait les requetes pour extraire les infos dont on a besoin dans la page d'accueil de l'espace privé
	//un lien de retour à l'accueil du compte
	$smarty->assign('Retour',
	$this->CreateLink($id, 'default', $returnid, array("display"=>"default","record_id"=>$username) ));


	$query= "SELECT nom, classement,pointres, victoire,date_event,epreuve,numjourn FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND MONTH(date_event) = ? AND licence = ?";//" ORDER BY date_event ASC";
	$query.=" ORDER BY date_event DESC";
	//echo $query;
	$dbresult = $db->Execute($query, array($saison,$mois_courant,$username));
	$rowarray= array();

	if ($dbresult && $dbresult->RecordCount() > 0)
	  {
	    while ($row= $dbresult->FetchRow())
	      {
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->date_event= $row['date_event'];
		$onerow->epreuve= $row['epreuve'];
		$onerow->nom= $row['nom'];
		$onerow->classement= $row['classement'];
		$onerow->victoire= $row['victoire'];
		$onerow->coeff= $row['coeff'];
		$onerow->pointres= $row['pointres'];
		$rowarray[]= $onerow;
	      }
	  }
	else
	{
		//echo "pas de résultats disponibles ! ";
	}

	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('retour',
			$this->CreateReturnLink($id, $returnid,'Retour'));
	$smarty->assign('items', $rowarray);
	$smarty->assign('resultats',
			$this->CreateLink($id,'user_results',$returnid, array('licence'=>$username)));

	
}
else
{
	//le module Ping est pas installé
}
echo $this->ProcessTemplate('fe-sportif2.tpl');
?>