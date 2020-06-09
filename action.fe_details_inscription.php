<?php
if (!isset($gCms)) exit;
//debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
require_once(dirname(__FILE__).'/include/fe_menu.php');


if(isset($params['record_id']) && $params['record_id'] !='')
{
	$id_inscription = $params['record_id'];
	//choix multi ou pas ?
	$insc_ops = new T2t_inscriptions;
	$detailsInsc = $insc_ops->details_inscriptions($id_inscription);
	$choix_multi = $detailsInsc['choix_multi'];
}
else
{
	//il y a une erreur !
}
$affichage=1;
if(isset($params['affichage']) && $params['affichage'] !='')
{
	$details = $params['affichage'];
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
			$id_option = $row['id'];
			$onerow->description = $row['description'];
			$onerow->date_debut =  $row['date_debut'];
			$inscrit = $insc_ops->is_inscrit_opt($row['id'], $username);
			if(FALSE ===$inscrit )
			{
				$onerow->is_inscrit = 'Non';
			
			}
			else
			{
				$onerow->is_inscrit = 'Oui';
				$onerow->delete = $this->CreateLink($id, 'fe_delete', $returnid, 'Supprimer ce choix', array("obj"=>"option_belongs", "record_id"=>$row['id'], "id_inscription"=>$id_inscription, "genid"=>$username));
			
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
		//
		$compteur = 0;
		$i = 0;
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('fe_edit_inscription.tpl'), null, null, $smarty);
		$tpl->assign('id_inscription', $id_inscription);
		$tpl->assign('genid', $username);
		$tpl->assign('compteur', $compteur);
		$i = 0;
		
		while($row = $dbresult->FetchRow())
		{
			
			$i++;
			${'nom_'.$i} = $row['nom'];
			$nom[] = $row['nom'];
			$id_opt[] = $row['id'];
			$it[$row['nom']] = $row['id'];
			$tpl->assign('nom_'.$i, $row['nom']);
			$tpl->assign('it_'.$i, $row['id']);	
					
		}
	
		$tpl->assign('iteration', $i);
		//$it = array("V1"=>"1", "V2"=>"2", "V3"=>"3");
		//var_dump($nom_1);
		$tpl->assign('choix_multi', $choix_multi);
		$tpl->assign('choix_multi2', $choix_multi);
		
		
		for($a=1; $a<=$i;$a++)
		{
			//echo $a;
			if($choix_multi == '0')//bouton radio
			{
				$tpl->assign('nom', $it);
			}
			else
			{
				$tpl->assign('name_'.$a,  ${'nom_'.$a});
			}
		}
	
		$tpl->display();
	}
}
else
{
	echo "Aucune option disponible !";
}


#
# EOF
#

?>