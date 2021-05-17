<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$db =& $this->GetDb();

//on récupère les valeurs
//pour l'instant pas d'erreur
$aujourdhui = date('Y-m-d ');
$error = 0;
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
$alert = 0;//pour savoir si certains champs doivent contenir une valeur ou non
	
		
		
	if (isset($params['edition']) && $params['edition'] !='')
	{
		$edit = $params['edition'];
	
	}
		
		$libelle_commande = '';
		if (isset($params['libelle_commande']) && $params['libelle_commande'] !='')
		{
			$prod = explode('-',$params['libelle_commande']);
			$produits = $prod[2];
		}
		
		
		//on va faire le calcul du prix de la ligne
		//on va d'abord chercher le prix unitaire de l'article
		
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
		if (isset($params['ep_manche_taille']) && $params['ep_manche_taille'] !='')
		{
			$ep_manche_taille = $params['ep_manche_taille'];
		}
		elseif($params['ep_manche_taille'] =='' && $alert == "1")
		{
			$error++;
		}
		
		$couleur = '';
		if (isset($params['couleur']) && $params['couleur'] !='')
		{
			$couleur = strtoupper($params['couleur']);
		}
		elseif($params['couleur'] =='' && ($categorie_produit== "REVETEMENTS" || $categorie_produit =="TEXTILES"))
		{
			$error++;
		}
		
	
	
		$quantite = '';
		if (isset($params['quantite']) && $params['quantite'] !='')
		{
			$quantite = $params['quantite'];
		}
		else
		{
			$error++;
		}
		
		//$libelle_commande = $produits;
		//s'agit-il d'une édition ou d'un ajout ?
		//$record_id = '';
		if(isset($params['produit_id']) && $params['produit_id'] !='')
		{
			$produit_id = $params['produit_id'];
			$edit = 1;//c'est un update
		}
		
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
			$prix_total = $prix_unitaire*$quantite*(1-$reduction/100);
			
			
			if($edit == 0)
			{
				$commande = 0;
				$query = "INSERT INTO ".cms_db_prefix()."module_commandes_cc_items (genid,date_created, date_modified,libelle_commande, categorie_produit, fournisseur, quantite, ep_manche_taille, couleur, prix_total, statut_item, commande) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$dbresult = $db->Execute($query, array($username,$aujourdhui, $aujourdhui,$produits,$categorie_produit,$fournisseur, $quantite,$ep_manche_taille, $couleur, $prix_total, $statut_item,$commande));
			}
			else
			{
				$query = "UPDATE ".cms_db_prefix()."module_commandes_cc_items SET libelle_commande = ?, date_modified =?, quantite = ?,ep_manche_taille = ?, couleur = ?, prix_total = ?,statut_item = ? WHERE id = ?";
				$dbresult = $db->Execute($query, array($produits,$aujourdhui, $quantite,$ep_manche_taille, $couleur, $prix_total,$statut_item,$produit_id));				
			}
			
			
			
		}		
		//echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Article ajouté/modifié. Confirmez votre article en cliquant sur "Confirmer"');
$this->Redirect($id,'default', $returnid, array("display"=>"fe_commandes","record_id"=>$username));

?>