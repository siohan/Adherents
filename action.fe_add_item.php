<?php

if( !isset($gCms) ) exit;

if( isset($params['cancel']) )
{
    	$this->RedirectToAdminTab('articles');
    	return;
}
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserName($userid);
require_once(dirname(__FILE__).'/include/fe_menu.php');
//on va chercher les différents fournisseurs disponibles
$service = new commandes_ops();
if(!empty($_POST))
{
	if(isset($_POST['cancel']))
	{
		$this->Redirect($id, 'default', $returnid, array("display"=>"fe_commandes"));
	}
	if(isset($_POST['categorie']) && $_POST['categorie'] != '')
	{
		$categorie = $_POST['categorie'];
	}
	if(isset($_POST['fournisseur']) && $_POST['fournisseur'] != '')
	{
		$fournisseur = $_POST['fournisseur'];
	}
	if(isset($_POST['libelle']) && $_POST['libelle'] != '')
	{
		$libelle = $_POST['libelle'];
	}
	if(isset($_POST['reference']) && $_POST['reference'] != '')
	{
		$reference = $_POST['reference'];
	}
	if(isset($_POST['marque']) && $_POST['marque'] != '')
	{
		$marque = $_POST['marque'];
	}
	
}
else
{
	$liste_fournisseurs = $service->liste_fournisseurs();

	//var_dump($liste_fournisseurs);

	//$liste_fournisseurs = array("WACK SPORT"=>"WACK SPORT", "BUTTERFLY"=>"BUTTERFLY", "AUTRES"=>"AUTRES");
	$liste_categories = array("BOIS"=>"BOIS","REVETEMENTS"=>"REVETEMENTS","BALLES"=>"BALLES","TEXTILES"=>"TEXTILES","ACCESSOIRES"=>"ACCESSOIRES","AUTRES"=>"AUTRES");

	$liste_dispo = array("DISPONIBLE"=>"1","NON DISPONIBLE"=>"0");

	$db =& $this->GetDb();
	//s'agit-il d'une modif ou d'une créa ?
	$record_id = '';
	$reference = '';
	$marque = '';
	$libelle = 'Mon produit';
	

	$edit = 0;//pour savoir si on édite ou on créé, 0 par défaut c'est une créa

	
	if(isset($params['record_id']) && $params['record_id'] !="")
	{
			$record_id = $params['record_id'];
			$edit = 1;//on est bien en trai d'éditer un enregistrement
			//ON VA CHERCHER l'enregistrement en question
			$query = "SELECT id, categorie, fournisseur, reference, libelle, marque, prix_unitaire, reduction, statut_item FROM ".cms_db_prefix()."module_commandes_items WHERE id = ?";
			$dbresult = $db->Execute($query, array($record_id));
			$compt = 0;
			while ($dbresult && $row = $dbresult->FetchRow())
			{
				$compt++;
				$id = $row['id'];
				$categorie = $row['categorie'];
				$fournisseur = $row['fournisseur'];
				$reference = $row['reference'];
				$libelle = $row['libelle'];
				$marque = $row['marque'];
				$prix_unitaire = $row['prix_unitaire'];
				$reduction = $row['reduction'];
				$statut_item = $row['statut_item'];

			}
	}
	//on construit le formulaire
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('fe_add_item.tpl'));
	$tpl->assign('record_id',$record_id);
	$tpl->assign('categorie',$categorie);
	$tpl->assign('fournisseur',$fournisseur);
	$tpl->assign('liste_fournisseurs', $liste_fournisseurs);
	$tpl->assign('liste_categories', $liste_categories);
	$tpl->assign('reference',$reference);
	$tpl->assign('libelle',$libelle);
	$tpl->assign('marque',$marque);		
	$tpl->display();
		
		
	#
}

# EOF
#
?>
