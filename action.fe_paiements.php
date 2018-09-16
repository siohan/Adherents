<?php
if( !isset($gCms) ) exit;
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);

require_once(dirname(__FILE__).'/include/fe_menu.php');
$delete = '<img src="modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$modif = '<img src="modules/Adherents/images/edit.gif" class="systemicon" alt="Modifier" title="Modifier">';
$vrai = '<img src="modules/Adherents/images/true.gif" class="systemicon" alt="Vrai" title="Vrai">';
$faux = '<img src="modules/Adherents/images/false.gif" class="systemicon" alt="Faux" title="Faux">';
$shopping = '<img src="../modules/Paiements/images/paiement.png" class="systemicon" alt="Réglez" title="Réglez">';
$relance = '<img src="../modules/Paiements/images/forward-email-16.png" class="systemicon" alt="Envoyer une relance" title="Envoyer une relance">';
$details_facture = '<img src="../modules/Paiements/images/billing.jpg" class="systemicon" alt="Détails de la facture" title="Détails de la facture">';
$smarty->assign('details_facture', $details_facture);
$result= array ();
$query = "SELECT pay.id, pay.categorie,pay.date_created, pay.tarif,pay.module,pay.actif, pay.ref_action,pay.licence,pay.statut, nom, date_created FROM ".cms_db_prefix()."module_paiements_produits AS pay WHERE licence = ?";
// , ".cms_db_prefix()."module_adherents_adherents AS adh WHERE adh.licence = pay.licence";
$query.=" ORDER BY pay.id ASC";
$dbresult= $db->Execute($query, array($username));
	
	//echo $query;
	$rowarray= array();
	$rowclass = '';
	$paiement_ops = new paiementsbis;
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			$adh_ops = new adherents_spid;
			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				
				//les champs disponibles : 
				$ref_action = $row['ref_action'];
				$statut = $row['statut'];
				$nom = $row['nom'];
			
				$onerow->id= $row['id'];
				$onerow->nom= $row['nom'];
				$onerow->ref_action= $row['ref_action'];
				$onerow->module= $row['module'];
				$onerow->categorie= $row['categorie'];
				
				$onerow->date_created = $row['date_created'];
				$onerow->tarif = $row['tarif'];	
				$reglement = $paiement_ops->is_paid($ref_action);
				//var_dump($reglement);
				$restant_du = '0.00';
				$du = '0.00';
				if(TRUE === $reglement)
				{
					$onerow->statut = $vrai;//$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('delete'), '', '', 'systemicon');
					$onerow->restant_du = $du;
				//	$onerow->view_reglement = $this->CreateLink($id, 'view_reglements',$returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view'), '', '', 'systemicon'), array('record_id'=>$row['ref_action']));
				}
				elseif(FALSE === $reglement)
				{
					$restant_du = $paiement_ops->restant_du($ref_action);
					//$restant_du = number_format($restant_du,2);
				//	var_dump($restant_du);
					if(is_null($restant_du) || $restant_du > 0)//il n'y a pas encore de reglement ou pas la totalité du montant
					{
						$du = $row['tarif'] - $restant_du;
					//	$du = number_format($du,2);
					//	var_dump($du);
					//	var_dump($du);
						if($du >0)
						{
							$onerow->statut = $faux;//$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('delete'), '', '', 'systemicon');
							//$onerow->add_reglement= $this->CreateLink($id, 'add_edit_reglement', $returnid, $shopping, array('record_id'=>$row['ref_action']));
							$onerow->restant_du = $du;
						//	$onerow->editlink= $this->CreateLink($id, 'add_edit_produit', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['ref_action']));
							//on envoie une relance ? si on a bien un mail
						
						//	$onerow->relance=$this->CreateLink($id, 'relance_email',$returnid,$relance, array("licence"=>$row['licence'], "ref_action"=>$row['ref_action']));
						}
						else
						{

							$onerow->statut = $vrai;//$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('delete'), '', '', 'systemicon');
							$onerow->restant_du = $du;
							//$onerow->view_details_commande=  $this$themeObject->DisplayImage('icons/system/view.gif', $this->Lang('delete'), '', '', 'systemicon');
							//$onerow->view_reglement = $this->CreateLink($id, 'view_reglements',$returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view'), '', '', 'systemicon'), array('record_id'=>$row['ref_action']));
						}


					}
					
					
				}
				//$onerow->delete = $this->CreateLink($id, '', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'),array() );
				
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
      			}
			
  		}

		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		
		

echo $this->ProcessTemplate('fe-paiements.tpl');


#
# EOF
#
?>