<?php
if( !isset($gCms) ) exit;

$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//$username = $feu->GetUsername($userid);
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$email = $feu->LoggedInEmail();
//var_dump($email);
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
$error = 0;//on instancie un compteur d'erreurs
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	//echo "le record_id est :".$record_id;
}
else
{
	$error++;
}
$modify = '<img src="modules/Adherents/images/edit.gif" class="systemicon" alt="Modifier" title="Modifier">';
$del = '<img src="modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$result= array ();
$query1 = "SELECT it.id AS item_id, it.fk_id , it.date_created,it.libelle_commande,it.ep_manche_taille, it.couleur, it.categorie_produit, it.fournisseur,it.quantite, it.prix_total, it.statut_item,it.commande FROM ".cms_db_prefix()."module_commandes_cc_items AS it WHERE id = ? AND genid = ? ";


	//$query .=" ORDER BY id DESC";
	//echo $query1;
	$dbresult= $db->Execute($query1,array($record_id,$username));
	
	//echo $query;
	$rowarray= array();
	$rowclass = '';
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				$onerow->item_id= $row['item_id'];
				$id_commandes = $row['genid'];
				//$user_validation = $row['user_validation'];
				//$commande_number = $row['commande_number'];
				$commande = $row['commande']; //gère si l'item doit être modifiable ou non
				//$fournisseur = $row['fournisseur'];
				$onerow->commande_id= $row['genid'];
				$onerow->date_created = $row['date_created'];
				$onerow->libelle_commande = $row['libelle_commande'];
				$onerow->categorie_produit = $row['categorie_produit'];
				$onerow->fournisseur = $row['fournisseur'];
				//$onerow->prix_unitaire = $row['prix_unitaire'];
				$onerow->quantite = $row['quantite'];
				$onerow->ep_manche_taille = $row['ep_manche_taille'];
				$onerow->couleur = $row['couleur'];
				//$onerow->reduction = $row['reduction'];
				$onerow->prix_total = $row['prix_total'];
				$onerow->statut = $row['statut_item'];
				
				if($user_validation == 0)
				{
					$onerow->edit = $this->CreateLink($id, 'default', $returnid,$modify, array("display"=>"add_cc_items","record_id"=>$row['item_id'], "commande_number"=>$commande_number,"edit"=>"1" ));
					$onerow->delete = $this->CreateLink($id, 'default', $returnid,$del, array("display"=>"delete","record_id"=>$row['item_id'], "commande_number"=>$commande_number ));
				}
				
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
      			}
			
  		}
		else
		{
			echo 'pas d\'articles à cette commande';
		}
		$smarty->assign('user_validation', $user_validation);
		$smarty->assign('validate',
			$this->CreateLink($id, 'default',$returnid, 'Terminer ma commande', array("display"=>"validate", "commande_number"=>$commande_number),$warn_message="Votre commande va devenir définitive : vous ne pourrez plus la modifier."));
		$smarty->assign('new_command', 
			$this->CreateLink($id, 'default', $returnid, 'Ajouter un article',array("display"=>"add_cc_items","commande_number"=>$commande_number, "commande_id"=>$row['genid'],"fournisseur"=>$fournisseur)));
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		$smarty->assign('commande_num', $commande_number);
		


echo $this->ProcessTemplate('fe_view_order.tpl');


#
# EOF
#
?>