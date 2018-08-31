<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$licence = '';
$date_event = '';
$affiche = 1;//cette variable détermine l'affichage par mois
$ok = 0;
if(isset($params['saison']) && $params['saison'] != '')
{
	$saison_courante = $params['saison'];
}
else
{
	$ping = cms_utils::get_module('Ping');
	$saison_courante = $ping->GetPreference('saison_en_cours');
}

$phase = (isset($params['phase']))?$params['phase']:$this->GetPreference('phase_en_cours');
//echo 'la phase est : '.$phase;
	if(!isset($params['record_id']) && $params['record_id'] =='' )
	{
		echo "la licence est absente !";
		
	}
	else
	{
		$licence = $params['record_id'];
		$parms = array();
		//si une date est précisée alors on affiche que les résultats de cette date
		if(isset($params['date_debut']) && $params['date_debut'] !='')
		{
			//on va alors cacher certains éléments de la page
			$affiche = 0;
			$date_debut = $params['date_debut'];
			$date_fin = $params['date_fin'];
			//on en déduit la saison pour le cas où on ne serait pas dans la saison en cours
		}
		
		if(isset($params['month']) && $params['month'] !='')
		{
			$affiche = 0;
			$ok = 1;
			$month = $params['month'];
		}
		if($affiche ==1)
		{
			$smarty->assign('phase2',
					$this->CreateLink($id,'fe_user_results',$returnid, 'Phase 2', array("phase"=>"2","record_id"=>$licence,'saison'=>$saison_courante) ));
			$smarty->assign('phase1',
					$this->CreateLink($id,'fe_user_results',$returnid, 'Phase 1', array("phase"=>"1","record_id"=>$licence,'saison'=>$saison_courante) ));
		}
		
		$rowarray1 = array();
		$query = "SELECT SUM(vd) AS vic, count(vd) AS total, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ?";//" WHERE saison = ? AND licence = ?";
		//qqs paramètres
		$parms['licence'] = $licence;
		if($affiche !='0'){
			$query.=" AND saison = ?";
			$parms['saison'] = $saison_courante;
		}
		//$parms['saison'] = $saison_courante;
		
		//on presente phase par phase ?
		
		if($affiche ==1)
		{
			if($phase =='1' )
			{
				if($phase ==2)
				{
					$query.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7"; 
				}
				else
				{
					$query.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
			}
			elseif( $phase == '2')
			{
				if($phase ==1)
				{
					$query.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
				else
				{
					$query.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";	
				}
			}
		}
		elseif($ok =='1')
		{
			$query.=" AND MONTH(date_event) = ?";
			$parms['month'] = $month;
		}
		

		$dbresult = $db->Execute($query, $parms);
		$rowclass = 'row1';
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row1 = $dbresult->FetchRow())
				{
					$onerow1= new StdClass();
					$onerow1->rowclass= $rowclass;
					$onerow1->vic= $row1['vic'];
					$onerow1->total= $row1['total'];
					$onerow1->pts= $row1['pts'];
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray1[]= $onerow1;
				}
			}
			$smarty->assign('items1', $rowarray1);


		$query1 = "SELECT CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";


		$dbresultat = $db->Execute($query1, array($licence));
		
		//faudrait tester si ça marche ou non
		if(!$dbresultat)
		{
			$designation = $db->ErrorMsg();
			ping_admin_ops::ecrirejournal('','KO',$designation,'');
		}
		$parms = array();
		$row1 = $dbresultat->FetchRow();
		$joueur = $row1['joueur'];
		$smarty->assign('joueur', $joueur);
		$result= array ();
		$query3= "SELECT advnompre, advclaof,pointres, vd,date_event FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ?";//" AND licence = ?";//" ORDER BY date_event ASC";
		//echo $query3;
		$parms['licence'] = $licence;
		$parms['saison'] = $saison_courante;
		
		if($affiche =='1')
		{
			if($phase =='1' )
			{
				if($phase ==2)
				{
					$query3.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7"; 
				}
				else
				{
					$query3.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
			}
			elseif( $phase == '2')
			{
				if($phase ==1)
				{
					$query3.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
				else
				{
					$query3.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";	
				}
			}
			$query3.= " ORDER BY date_event DESC";
		}
		elseif($affiche =='0')
		{
			if($ok=='1')
			{
				$query3.=" AND MONTH(date_event) = ?";
				$parms['date_event'] = $month;
				$query3.=" ORDER BY date_event DESC";
				
			}
			else
			{
				$query3.=" AND date_event BETWEEN ? AND ?";
				$parms['date_debut'] = $date_debut;
				$parms['date_fin'] = $date_fin;
				$query3.=" ORDER BY date_event DESC";
				
			}
		}
		
		else
		{
			$query3.=" ORDER BY date_event DESC";
			
		}
		
		$dbresult3 = $db->Execute($query3, $parms);
		
		$rowarray= array();

		if ($dbresult3 && $dbresult3->RecordCount() > 0)
		{
		    while ($row= $dbresult3->FetchRow())
			{
	
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				$onerow->date_event= $row['date_event'];
				$onerow->advnompre= $row['advnompre'];			
				$onerow->advclaof= $row['advclaof'];
				$onerow->vd= $row['vd'];			
				$onerow->pointres= $row['pointres'];
				$rowarray[]= $onerow;
		      	}
		}
	
		$smarty->assign('resultats',
				$this->CreateLink($id,'user_results',$returnid,$contents = 'Tous ses résultats', array('licence'=>$licence,'saison'=>$saison_courante)));
	}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('ok',$ok);
$smarty->assign('itemcount', count($rowarray));

$smarty->assign('items', $rowarray);
$smarty->assign('affiche',$affiche);

$smarty->assign('rafraichir',
		$this->CreateLink($id,'retrieve',$returnid, 'Rafraichir mes données', array("retrieve"=>"fftt",'record_id'=>$licence)));

echo $this->ProcessTemplate('fe_user_results.tpl');


#
# EOF
#
?>