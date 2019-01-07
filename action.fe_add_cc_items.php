<?php
if( !isset($gCms) ) exit;
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//$username = $feu->GetUsername($userid);
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$db =& $this->GetDb();
$record_id = '';
$produit_id = '';
$edit = 0; //par défaut il s'agit d'un ajout
$error = 0; //on instancie un compteur d'erreurs
//debug_display($params, 'Parameters');
$index = 0;
$adh_ops = new adherents_spid;
$liste_clients = $adh_ops->liste_adherents();

if(isset($params['record_id']) && $params['record_id'] != '')
{
	$client = $params['record_id'];
}
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


//on fait une requete pour completer l'input dropdown du formulaire
$query = "SELECT CONCAT_WS('-',fournisseur, categorie, libelle) AS libelle_form,libelle  FROM ".cms_db_prefix()."module_commandes_items WHERE statut_item = '1'  ORDER BY fournisseur ASC, categorie ASC, libelle ASC";
$dbresult = $db->Execute($query);

	if($dbresult) 
	{
		if($dbresult->RecordCount() >0)
		{
			$a = 0;
			while($row= $dbresult->FetchRow())
			{
				$a++;
				
				$libelle[$row['libelle_form']] = $row['libelle_form'];
			
				//echo $a;
				if(isset($libelle_commande) && $row['libelle_form'] == $produit_final)
				{
					$index = $a-1;
				}
			}
		}
	}
	else
	{
		echo "erreur de requete";
	}
	//echo $produit_final;
	/*
			
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('fe_add_cc_item.tpl'),null,null,$smarty);
	$tpl->assign('form_start',$this->CGCreateFormStart($id,'fe_do_add_cc_item',$returnid,$params,$inline));
	
	if($edit == 1)
	{
		$tpl->assign('libelle_selected', $produit_final);
		
	}
	$tpl->assign('client', $this->CreateInputHidden($id,'client',$record_id));
	
	//$tpl->assign('produit_id', $produit_id);// c'est l'id de chq article
	$tpl->assign('produits',$libelle);
	//var_dump($libelle);
	$tpl->assign('ep_manche_taille', (isset($ep_manche_taille)?$ep_manche_taille:""));
	$tpl->assign('couleur', (isset($couleur)?$couleur:""));//$couleur);
	$tpl->assign('display', 'fe_commandes');
	//$tpl->assign('categorie_produit', $categorie_produit);
	$tpl->assign('quantite', (isset($quantite)?$quantite:"0"));	
	$tpl->assign('form_end', $this->CreateFormEnd());
	$tpl->display();
	*/
	//on construit le formulaire
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'fe_do_add_cc_item', $returnid ) );
	
	$smarty->assign('record_id',
			$this->CreateInputHidden($id,'record_id',$username));
	$smarty->assign('produit_id',
			$this->CreateInputHidden($id, 'produit_id', $produit_id));
	$smarty->assign('edition', 
			$this->CreateInputHidden($id, 'edition',$edit));
	$smarty->assign('date_created',
			$this->CreateInputDate($id, 'date_created',(isset($date_created)?$date_created:"")));
	$smarty->assign('libelle_commande',
			$this->CreateInputDropdown($id,'libelle_commande',$libelle,$selectedindex = $index, $selectedvalue=$libelle));
	$smarty->assign('fournisseur',
			$this->CreateInputHidden($id, 'fournisseur',(isset($fournisseur)?$fournisseur:"")));		
	$smarty->assign('ep_manche_taille',
			$this->CreateInputText($id,'ep_manche_taille',(isset($ep_manche_taille)?$ep_manche_taille:""),50,200));
			
	$smarty->assign('couleur',
			$this->CreateInputText($id,'couleur',(isset($couleur)?$couleur:""),50,200));
			

			
			
	$smarty->assign('categorie_produit',
			$this->CreateInputText($id,'categorie_produit',(isset($categorie_produit)?$categorie_produit:""),30,150));
	$smarty->assign('quantite',
			$this->CreateInputText($id,'quantite',(isset($quantite)?$quantite:""),5,10));
	$smarty->assign('prix_unitaire',
			$this->CreateInputText($id,'prix_unitaire',(isset($prix_unitaire)?$prix_unitaire:""),5,10));		
	$smarty->assign('reduction',
			$this->CreateInputText($id,'reduction',(isset($reduction)?$reduction:""),5,10));			
	/*
	$smarty->assign('statut_item',
			$this->CreateInputText($id,'statut_item',(isset($statut_item)?$statut_item:""),5,10));	
	*/			
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());
	
	



echo $this->ProcessTemplate('fe_add_cc_item2.tpl');
	
# EOF
#
?>
