<?php

if( !isset($gCms) ) exit;
//debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//$username = $feu->GetUserName($userid);
//$username 
require_once(dirname(__FILE__).'/include/fe_menu.php');
//echo "FEU : le user est : ".$username." ".$userid;

if( isset($params['cancel']) )
{
    	$this->RedirectToAdminTab('compos');
    	return;
}
global $themeObject;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();

$comp_ops = new compositionsbis;

//il faut les parametres suivants : idepreuve, saison, ref_action, et ref_equipe
if(isset($params['ref_action']) && $params['ref_action'] != '')
{
	$ref_action = $params['ref_action'];
}
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
}
else
{
	$idepreuve = $comp_ops->get_idepreuve($ref_action);
}
$epreuve = $comp_ops->nom_compet($idepreuve);
if(isset($params['ref_equipe']) && $params['ref_equipe'] != '')
{
	$ref_equipe1 = $params['ref_equipe'];
	$ref_equipe = $params['ref_equipe'];
}


	/*
	$nb_player = $comp_ops->player_by_idepreuve($idepreuve);//le nb de joueurs nécessaires aux compos
	$nb_already_used = $comp_ops->nb_already_used_licences($ref_action);
	$mess = 'Vous avez utilisé '.$nb_already_used.' joueurs(euses) sur '.$nb_player.' nécessaires !';
	$smarty->assign('message', $mess);
	//on récupère d'abord les équipes concernées
	$query = "SELECT id, libequipe, friendlyname FROM ".cms_db_prefix()."module_compositions_equipes WHERE idepreuve = ? ORDER BY id ASC";
	$dbresult = $db->Execute($query, array($idepreuve));
	
	$rowarray= array();
	$rowclass = 'row1';
	if($dbresult && $dbresult->RecordCount()>0)
	{
			while($row = $dbresult->FetchRow())
			{
				$onerow = new StdClass;
				$onerow->rowclass=$rowclass;
				$libequipe = $row['libequipe'];
				$friendlyname = $row['friendlyname'];
				$ref_eq = $row['id'];
				if($ref_eq == $ref_equipe1)
				{
					$classe = 1;
				}
				else
				{
					$classe = 0;
				}
				$onerow->class= $classe;
				$lienequipe = (!empty($row['friendlyname'])?$row['friendlyname']: $row['libequipe']);
				$onerow->equipe = $this->CreateLink($id, 'view_compos', $returnid, $lienequipe, array("ref_action"=>$ref_action, "ref_equipe"=>$row['id']));
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
			}
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);
			
		//	echo $this->ProcessTemplate('view_equipes.tpl');
	}
	*/		
	//on attaque la deuxième requete pour montrer les compos déjà saisies
	$query2 = "SELECT ref_action, ref_equipe, genid, statut FROM ".cms_db_prefix()."module_compositions_compos_equipes WHERE ref_action = ? AND ref_equipe = ?";
	$dbresult2 = $db->Execute($query2, array($ref_action, $ref_equipe1));
	$rowarray2 = array();

	if($dbresult2)
	{
		if($dbresult2->RecordCount()>0)
		{
			$adh_ops =  new Asso_adherents;
			$onerow = new StdClass;
			$lock = '<img src="../modules/Compositions/images/lock.png" class="systemicon" alt="Déverrouiller" title="Déverrouiller">';
			$unlock = '<img src="../modules/Compositions/images/unlock.png" class="systemicon" alt="Verrouiller" title="Verrouiller">';
			$onerow->rowclass=$rowclass;
			while($row2 = $dbresult2->FetchRow())
			{
				$statut = $row2['statut'];
				if($statut == "0")
				{
					$smarty->assign('lock', $this->CreateLink($id, 'fe_delete', $returnid, 'Verrouiller', array("obj"=>"fe_lock_unlock", "ref_action"=>$ref_action, "ref_equipe"=>$ref_equipe, "statut"=>"1")));
					$smarty->assign('modifier', $this->CreateLink($id, 'fe_add_edit_compos_equipe', $returnid, 'Modifier', array("ref_action"=>$ref_action, "ref_equipe"=>$ref_equipe,"edit"=>"1")));
				}
				
				$onerow2 = new StdClass;
				$onerow2->ref_action = $row2['ref_action'];
				$onerow2->ref_equipe = $row2['ref_equipe'];
				$onerow2->licence = $adh_ops->get_name($row2['genid']);
				$onerow2->statut = $statut;
				$rowarray2[] = $onerow2;

			}

			$smarty->assign('itemcount2', count($rowarray2));
			$smarty->assign('items2', $rowarray2);

		}
		else
		{
			$this->Redirect($id, 'fe_add_edit_compos_equipe', $returnid, array('ref_action'=>$ref_action, 'record_id'=>$params['record_id']));
		}
	} 
	else
	{
		echo "Attention !";
	}

	
	echo $this->ProcessTemplate('fe_view_equipes.tpl');

