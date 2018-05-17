<?php
if (!isset($gCms)) exit;
//debug_display($params,'Parameters');
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
$paiements_ops = new paiementsbis;
$designation = '';
$smarty->assign('fe_add_cc',
		$this->CreateLink($id, 'default', $returnid, 'Ajouter un article', array("record_id"=>$username,"display"=>"add_cc_items")));
	//on a l'email
	//on peut récupérer les infos du user
	//on va montrer un lien pour ajouter une nouvelle commande
	//mais surtout les commandes passées s'il y en a
	//echo "on continue";
	//echo $email;
	$query = "SELECT  nom, prenom,licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE licence LIKE ?";
	$dbresult = $db->Execute($query, array($username));
	
	if($dbresult && $dbresult->recordCount() >0)
	{
		$smarty->assign('fe_add_cc',
				$this->CreateLink($id, 'default', $returnid, 'Ajouter un article', array("record_id"=>$username,"display"=>"add_cc_items")));
		$row = $dbresult->FetchRow();
		$client = $row['licence'];
		$nom = $row['nom'];
		echo "Salut ".$row['prenom'];
		//le id est : ".$id_client;
		//deuxième requete pour trouver les commandes
		$query2 = "SELECT id AS commande_id, date_created, libelle_commande,quantite, ep_manche_taille, couleur, commande_number,fournisseur, prix_total, commande, user_validation FROM ".cms_db_prefix()."module_commandes_cc_items WHERE fk_id = ? AND commande <= '1'";
		$dbresult2 = $db->Execute($query2, array($username));
		//echo $query2;
		if($dbresult2 && $dbresult2->RecordCount()>0)
		{
			$rowarray= array();
			$rowclass = '';
			
			while($row = $dbresult2->FetchRow())
			{
				$user_validation = $row['user_validation'];
			//	$commande_number = $row['commande_number'];
				$onerow = new StdClass();
				$onerow->commande_id = $row['commande_id'];
				$onerow->date_created = $row['date_created'];
				$onerow->libelle_commande =  $row['libelle_commande'];
				$onerow->fournisseur = $row['fournisseur'];
				$onerow->prix_total = $row['prix_total'];
				$onerow->statut_commande = $row['commande'];
				$onerow->quantite = $row['quantite'];
				$onerow->ep_manche_taille = $row['ep_manche_taille'];
				$onerow->couleur = $row['couleur'];
		
				//$onerow->view = $this->CreateFrontendLink($id, $returnid,'feViewCc', $contents='Détails',array("record_id"=>$row['commande_id']),$warn_message='',$onlyhref='',$inline='true');
				//$onerow->view = $this->CreateLink($id, 'default', $returnid,'Détails',array("display"=>"feViewCc", "record_id"=>$row['commande_id']),$warn_message='',$onlyhref='',$inline='true');
				if($user_validation==0)
				{
					$onerow->fe_edit = $this->CreateLink($id, 'default', $returnid,$modif,array("display"=>"add_cc_items","produit_id"=>$row['commande_id']),'',$onlyhref='',$inline='true');
					$onerow->fe_delete = $this->CreateLink($id, 'default', $returnid,$delete,array("display"=>"delete","record_id"=>$row['commande_id']),$warn_message='Cet article sera supprimé',$onlyhref='',$inline='true');
					$onerow->fe_confirm = $this->CreateLink($id, 'default', $returnid,'Confirmer',array("display"=>"validate","record_id"=>$row['commande_id']),$warn_message='Cet article sera confirmé et non modifiable',$onlyhref='',$inline='true');
				}
				
				
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
			}
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);
			
			
			
		}
		elseif($dbresult2->RecordCount() == 0)
		{
			//echo "Pas de commandes...";
		}
		else
		{
			echo $db->ErrorMsg();
		}
		echo $this->ProcessTemplate('fe_commandes.tpl');	/*
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);
			$smarty->assign('fe_add_cc',
			$this->CreateLink($id, 'default', $returnid, 'Ajouter un article', array("record_id"=>$client,"display"=>"add_cc_items")));
			//un lien de déconnexion ?
			//Why not !
			*/
		//on commence une autre requete pour les commandes validées
		$query1 = "SELECT date_created, fournisseur, commande_number, libelle_commande, statut_commande, prix_total, paiement FROM ".cms_db_prefix()."module_commandes_cc  WHERE client = ? ";


			//$query .=" ORDER BY id DESC";
			//echo $query;
			$dbresult= $db->Execute($query1, array($username));

			//echo $query;
			$rowarray= array();
			$rowarray2= array();
			$rowclass = '';
			$array_chpt = array();

				if ($dbresult && $dbresult->RecordCount() > 0)
		  		{
		    			while ($row= $dbresult->FetchRow())
		      			{
						$onerow= new StdClass();
						$onerow->rowclass= $rowclass;
						$statut_commande = $row['statut_commande']; //gère si l'item doit être modifiable ou non					
						$onerow->commande_number= $row['commande_number'];
						$onerow->date_created = $row['date_created'];
						$onerow->libelle_commande = $row['libelle_commande'];
						$onerow->fournisseur = $row['fournisseur'];					
						$onerow->prix_total = $row['prix_total'];
						$is_paid = $paiements_ops->is_paid($row['commande_number']);

						if(true === $is_paid)
						{
							$onerow->is_paid = $vrai;//$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
						}
						else
						{
							$false = false;
							$onerow->is_paid = $faux;//$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon');
						}
					//	$onerow->is_paid = $paiement_ops->is_paid($row['commande_number']);
						$onerow->view = $this->CreateLink($id, 'default', $returnid, 'détails', array("display"=>"feViewCc", "commande_number"=>$row['commande_number']));//$row['statut_item'];

						($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
						$rowarray[]= $onerow;
		      			}

		  		}

				$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
				$smarty->assign('itemcount', count($rowarray));
				$smarty->assign('items', $rowarray);



		echo $this->ProcessTemplate('fe_view_orders.tpl');
		
		
	
	}
	elseif($dbresult->RecordCount() == 0)
	{
		echo "Pas d\'utilisateur ayant cette adresse email";
		$designation.=" Adresse email non reconnue !";
		$this->SetMessage($designation);
		$feu->Redirect($id,"login",$returnid);
	}
	else
	{
		echo $db->ErrorMsg();
	}




/**/
//echo $this->ProcessTemplate('default1.tpl');
#
# EOF
#

?>