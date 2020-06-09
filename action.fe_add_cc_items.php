<?php
if( !isset($gCms) ) exit;
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
$db =& $this->GetDb();


if(!empty($_POST))
{
	//debug_display($_POST, 'Parameters');
	if(isset($_POST['cancel']))
	{
		//redirection
		$this->RedirectToAdminTab();
	}
	else
	{
		
		//on traite les données reçues
		$error = 0; //on instancie un compteur d'erreur
		$date_modified = date('Y-m-d');
		$date_created = date('Y-m-d');
		if (isset($_POST['date_created']) && $_POST['date_created'] !='')
		{
			$date_created = $_POST['date_created'];
		}
		if (isset($_POST['edit']) && $_POST['edit'] !='')
		{
			$edit = $_POST['edit'];
		}
		if (isset($_POST['produit_id']) && $_POST['produit_id'] !='')
		{
			$produit_id = $_POST['produit_id'];
			
		}
		$produits = '';
		if (isset($_POST['fournisseur']) && $_POST['fournisseur'] !='')
		{
			$produits = $_POST['fournisseur'];
		}		
		$query2 = "SELECT prix_unitaire, reduction, categorie, fournisseur, statut_item FROM ".cms_db_prefix()."module_commandes_items WHERE libelle LIKE ?";
		$dbresult2 = $db->Execute($query2, array($produits));
		if($dbresult2)
		{
			$row2 = $dbresult2->FetchRow();
			$reduction = $row2['reduction'];
			$prix_unitaire = $row2['prix_unitaire'];
		//	echo $prix_unitaire;
			$fournisseur = $row2['fournisseur'];
			$categorie_produit = $row2['categorie'];
			$statut_item = $row2['statut_item'];
		}
		if($categorie_produit == "BOIS" || $categorie_produit == "REVETEMENTS" || $categorie_produit == "TEXTILES")
		{
			$alert = 1;
		}
		
		
		$ep_manche_taille = '';
		if (isset($_POST['ep_manche_taille']) && $_POST['ep_manche_taille'] !='')
		{
			$ep_manche_taille = $_POST['ep_manche_taille'];
		}
		elseif($_POST['ep_manche_taille'] =='' && $alert == "1")
		{
			$error++;
		}
		
		$couleur = '';
		if (isset($_POST['couleur']) && $_POST['couleur'] !='')
		{
			$couleur = strtoupper($_POST['couleur']);
		}
		elseif($_POST['couleur'] =='' && ($categorie_produit== "REVETEMENTS" || $categorie_produit =="TEXTILES"))
		{
			$error++;
		}	
	
		$quantite = '';
		if (isset($_POST['quantite']) && $_POST['quantite'] !='')
		{
			$quantite = $_POST['quantite'];
		}
		else
		{
			$error++;
		}
		
		$statut_item = 1;
		$prix_total = 0;
		//echo "le nb erreurs est : ".$error;
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->Redirect($id, 'default',$returnid, array("display"=>"add_cc_items", "edit"=>$edit));//ToAdminTab('commandesclients');
		}
		else // pas d'erreurs on continue
		{
			
			//on fait le calcul du prix total de larticle
			//$prix_total = $prix_unitaire*$quantite*(1-$reduction/100);
			
			
			if($edit == 0)
			{
				$commande = 0;
				$query = "INSERT INTO ".cms_db_prefix()."module_commandes_cc_items (genid,date_created, date_modified,libelle_commande, categorie_produit, fournisseur, quantite, ep_manche_taille, couleur, prix_total, statut_item, commande) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$dbresult = $db->Execute($query, array($username,$date_created, $date_modified,$produits,$categorie_produit,$fournisseur, $quantite,$ep_manche_taille, $couleur, $prix_total, $statut_item,$commande));
			}
			else
			{
				$query = "UPDATE ".cms_db_prefix()."module_commandes_cc_items SET libelle_commande = ?, date_modified =?, quantite = ?,ep_manche_taille = ?, couleur = ?, prix_total = ?,statut_item = ? WHERE id = ?";
				$dbresult = $db->Execute($query, array($produits,$date_modified, $quantite,$ep_manche_taille, $couleur, $prix_total,$statut_item,$produit_id));				
			}
			
			
			
		}		
		//on redirige
		$this->Redirect($id,'default', $returnid, array("display"=>"fe_commandes"),$onlyhref='',$inline='true');
		//$this->Redirect($id, 'default', $returnid, array("display"=>"fe_commandes"));
		//{redirect_page page='mon-compte'}
		//echo $this->ProcessTemplate('fe_add_cc_item3.tpl');
	}
}
else
{
	//global $themeObject;
	
	require_once(dirname(__FILE__).'/include/fe_menu.php');
	$record_id = $username;
	$produit_id = '';
	$edit = 0; //par défaut il s'agit d'un ajout
	$error = 0; //on instancie un compteur d'erreurs
	//debug_display($params, 'Parameters');
	$index = 0;
	$adh_ops = new adherents_spid;
	$liste_clients = $adh_ops->liste_adherents();

	if(isset($params['record_id']) && $params['record_id'] != '')
	{
		$record_id = $params['record_id'];
	}
	//les valeurs par défaut 
	$date_created = date('Y-m-d');
	$com_ops = new commandes_ops;
	$liste_items = $com_ops->liste_items();
	$libelle_commande = "Ma commande";
	$fournisseur = "Mon fournisseur";
	$categorie_produit = "Catégorie produit";
	$quantite = 0;
	$ep_manche_taille = '';
	$couleur = '';
	$edit = 0;
	$produit_final = $fournisseur.'-'.$categorie_produit.'-'.$libelle_commande;

	if(isset($params['produit_id']) && $params['produit_id'] != '')
	{
		$produit_id = $params['produit_id'];
		$edit = 1;
		//ON VA CHERCHER l'enregistrement en question
		$query = "SELECT it.id AS item_id,items.id AS index1, it.fk_id ,it.commande_number, it.date_created,it.libelle_commande,it.fournisseur,it.couleur, it.ep_manche_taille, it.categorie_produit, it.fournisseur,it.quantite, it.prix_total, it.statut_item FROM ".cms_db_prefix()."module_commandes_cc_items AS it, ".cms_db_prefix()."module_commandes_items AS items  WHERE it.libelle_commande LIKE items.libelle  AND it.id = ?  ORDER BY items.categorie, items.libelle ASC";
		$dbresult = $db->Execute($query, array($produit_id));
		$compt = 0;
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			$compt++;
			$item_id = $row['item_id'];
			$commande_id = $row['fk_id'];
			//$commande_number = $row['commande_number'];
			$date_created = $row['date_created'];
			$libelle_commande = $row['libelle_commande'];
			$categorie_produit = $row['categorie_produit'];
			$fournisseur = $row['fournisseur'];
			$quantite = $row['quantite'];
			$prix_total = $row['prix_total'];
			$statut_item = $row['statut_item'];
			$ep_manche_taille = $row['ep_manche_taille'];
			$couleur = $row['couleur'];
			$produit_final = $fournisseur.'-'.$categorie_produit.'-'.$libelle_commande;
		}

	}
//var_dump($liste_items);

		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('fe_add_cc_item3.tpl'),null,null,$smarty);	
		$tpl->assign('produit_final', $libelle_commande);
		$tpl->assign('record_id', $record_id);
		$tpl->assign('edit', $edit);
		$tpl->assign('produit_id', $produit_id);// c'est l'id de chq article
		$tpl->assign('produits',$libelle);
		$tpl->assign('ep_manche_taille', (isset($ep_manche_taille)?$ep_manche_taille:""));
		$tpl->assign('couleur', (isset($couleur)?$couleur:""));//$couleur);
		$tpl->assign('display', 'fe_commandes');
		$tpl->assign('liste_items', $liste_items);
		$tpl->assign('quantite', $quantite);	
		$tpl->assign('date_created', $date_created);	
		$tpl->display();
		
	
}





	
# EOF
#
?>
