<?php
if (!isset($gCms)) exit;
//debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
require_once(dirname(__FILE__).'/include/fe_menu.php');

//on détermine dans quels groupes figure l'adhérent
$gp_ops = new groups;
$adh = $gp_ops->member_of_groups($username);
//var_dump($adh);
$quer = 0;
if(is_array($adh) && count($adh) > 0 )
{
	$tab = implode(', ',$adh);
	$quer = 1;	
}


//var_dump($adh);
$delete = '<img src="../assets/modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$modif = '<img src="../assets/modules/Adherents/images/edit.gif" class="systemicon" alt="Modifier" title="Modifier">';
$vrai = '<img src="../assets/modules/Adherents/images/true.gif" class="systemicon" alt="Vrai" title="Vrai">';
$faux = '<img src="../assets/modules/Adherents/images/false.gif" class="systemicon" alt="Faux" title="Faux">';

$details=1;
if(isset($params['details']) && $params['details'] !='')
{
	$details = $params['details'];
}

$db = cmsms()->GetDb();
$query = "SELECT id,nom, description, tarif, groupe FROM ".cms_db_prefix()."module_cotisations_types_cotisations WHERE actif = 1 ";
if($quer ==1)
{
	$query.=" AND groupe IN ($tab) ";
}
$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount()>0)
{
	if($details ==1)//on affiche le détail sans permettre de changer
	{
	
		$cotis_ops = new cotisationsbis;
		$pay_ops = new paiementsbis;
		$rowarray= array();
		$rowclass = '';
		while($row = $dbresult->FetchRow())
		{
			$onerow = new StdClass();
			$onerow->nom = $row['nom'];
			$id_option = $row['id'];
			$onerow->description = $row['description'];
			$inscrit = $cotis_ops->belongs_exists($row['id'],$username);
			$ref = $cotis_ops->ref_action($username, $row['id']);
			//var_dump($ref);
			if(false != $ref)
			{
				$is_paid = $pay_ops->is_paid($ref);
			}
			else
			{
				$is_paid = false;
			}
		
			if(FALSE ===$inscrit )
			{
				$onerow->is_inscrit = $faux;
				$onerow->regle = $faux;
				$onerow->inscription = $this->CreateLink($id, 'fe_add', $returnid,$contents="M'inscrire", array("id_cotisation"=>$row['id'], "record_id"=>$username, "obj"=>"adhesion"));
			}
			else
			{
				$onerow->is_inscrit = $vrai;
				if(false != $is_paid)// c'est bien payé !
				{
					$onerow->regle = $vrai;
					$onerow->delete = $false;//this->CreateLink($id, 'fe_delete', $returnid, $delete, array("obj"=>"option_belongs", "record_id"=>$row['id'], "id_inscription"=>$id_inscription, "adherent"=>$username));
				}
				else
				{
					$onerow->regle = $false;
					$onerow->delete = $this->CreateLink($id, 'fe_delete', $returnid, $delete, array("obj"=>"cotisation", "ref_action"=>$ref));
				}
				$onerow->inscription = $false;
				//$onerow->delete = $this->CreateLink($id, 'fe_delete', $returnid, $delete, array("obj"=>"option_belongs", "record_id"=>$row['id'], "id_inscription"=>$id_inscription, "adherent"=>$username));
			
			}
			
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		echo $this->ProcessTemplate('fe_adhesions.tpl');
	}
	else //on affiche le formulaire
	{
		
		$i = 0;
		$smarty->assign('formstart',
				$this->CreateFormStart($id,  'fe_do_edit_inscription', $returnid));
		$smarty->assign('id_inscription', 
				$this->CreateInputHidden($id, 'id_inscription', $id_inscription));
		$smarty->assign('licence', 
				$this->CreateInputHidden($id, 'licence', $username));//attention choix multi ou pas ?
				$it = array();
		while($row = $dbresult->FetchRow())
		{
			
			$i++;
			${'nom_'.$i} = $row['nom'];
			$nom[] = $row['nom'];
			$id_opt[] = $row['id'];
			$it[$row['nom']] = $row['id'];
			$smarty->assign('nom_'.$i, $row['nom']);			
		}
		//$it = array("V1"=>"1", "V2"=>"2", "V3"=>"3");
		//var_dump($nom_1);
		$smarty->assign('compteur',  $i);
		$smarty->assign('choix_multi', $choix_multi);
		$smarty->assign('choix_multi2', $this->createInputHidden($id, 'choix_multi2',$choix_multi));
		
				for($a=1; $a<=$i;$a++)
				{
					//echo $a;
					if($choix_multi == '0')//bouton radio
					{
						$smarty->assign('nom', $this->CreateInputRadioGroup($id, 'nom', $it,$selectedvalue='', '','<br />'));//${'nom_'.$a}, ''));
					}
					else
					{
						$smarty->assign('name_'.$a, $this->CreateInputCheckbox($id, 'nom[]', ${'nom_'.$a}, ''));
					}
				}
	
		$smarty->assign('submit',
				$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
		$smarty->assign('cancel',
				$this->CreateInputSubmit($id,'cancel',
							$this->Lang('cancel')));


		$smarty->assign('formend',
				$this->CreateFormEnd());
	echo $this->ProcessTemplate('fe_edit_inscription.tpl');
	}
}


#
# EOF
#

?>