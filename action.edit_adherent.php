<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

if (!$this->CheckPermission('Adherents use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('adherents');
}
$db =& $this->GetDb();
$asso_ops = new Asso_adherents;
$gp_ops = new groups;
global $themeObject;
if( !empty($_POST) ) {
        if( isset($_POST['cancel']) ) {
            $this->RedirectToAdminTab();
        }

	$message = "";
	$genid = (int) $_POST['genid'];
	if(! $genid)
	{
		$genid = $this->random_int(9);
	}
	$edit = $_POST['edit'];
	$actif = cms_to_bool($_POST['actif']);
	$licence = $_POST['licence'];
	$nom = $asso_ops->clean_name($_POST['nom']);
	$nom = strtoupper($nom);
	$prenom = $_POST['prenom'];
	$anniversaire = (!empty($_POST['anniversaire'])?$_POST['anniversaire']:"1800-01-01");
	$sexe = $_POST['sexe'];
	$adresse = $_POST['adresse'];
	$code_postal = $_POST['code_postal'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];
	$externe = 0;
	$aujourdhui = date('Y-m-d');
	
	$service = new Asso_adherents;
	
	if($edit == 1)
	{
		$update_adherent = $service->update_adherent($actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe, $aujourdhui, $genid);
		$message.="Adhérent modifié. ";
		
		//quelle est la valeur de la variable actif
		//si actif == 1 on ne fait rien
		//si actif == 0 on l'enlève de tous les groupes automatiquement
		if($actif == 0)
		{
			//on supprime l'accès à FEU
			//a-t-il un compte existant ?
			$feu = cms_utils::get_module('FrontEndUsers');
			//$feu_ops = new FrontEndUsersManipulator;//cms_utils::get_module('FrontEndUsers');
			//on récupére le id de l'utilisateur
			$uid = $feu->GetUserInfoByProperty('genid',$genid);
			var_dump($uid);
			
			$del_feu = $gp_ops->delete_user_feu($uid[1]['id']);
			if(true == $del_feu)
			{
				//l'utilisateur est bien supprimé de FEU
				$message.= "Membre supprimé de FEU.";				
			}
			else
			{
				//pb pour supprimer l'utilisateur
				$message.= "Attention, le membre tjs présent dans FEU !";
			}
			
			$del_user = $gp_ops->delete_user_from_all_groups($genid);
			if(true == $del_user)
			{
				$message.=" Membre supprimé de tous les groupes du module Adherents";
			}
			
		}
		
	}
	else
	{
		$add_adherent = $service->add_adherent($genid,$actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe);
		if(true === $add_adherent)
		{
			$message.=" Adhérent inséré. ";
			//on insère automatiquement le nouveau ds le gp par défaut 
			$id_gp = $gp_ops->assign_to_adherent($genid);
			if(false !== $id_gp)
			{
				$message.=" Inscrit dans le groupe adhérent.";
			}
		}
		
	}
	$this->SetMessage($message);
	$this->Redirect($id, 'view_adherent_details', $returnid, array("record_id"=>$genid));
	
}
else
{
	//debug_display($params, 'Parameters');
	//les valeurs des champs par défaut
	$actif = 1;
	$genid = "";
	$licence = "";
	$nom = "";//$details['nom'];
	$prenom = "";//$details['prenom'];
	$anniversaire = date('Y-m-d');//$details['anniversaire'];
	$sexe = 'M';//$details['sexe'];
	$adresse = "";//$details['adresse'];
	$code_postal = "";//$details['code_postal'];
	$ville = "";//$details['ville'];
	$pays = 'France';//$details['pays'];
	$OuiNon = array("Non"=>"0","Oui"=>"1");
	$liste_sexe = array("M"=>"Masculin", "F"=>"Féminin");
	$edit = 0;
	$image = '';
	
	$anniversaire = date('Y-m-d');
	if(isset($params['record_id']) && $params['record_id'])
	{
		$record_id = $params['record_id'];
		$genid = $params['record_id'];
		$as_adh = new Asso_adherents;
		$details = $as_adh->details_adherent_by_genid($record_id);
		//var_dump($details);
		$edit = 1;
		$actif = $details['actif'];
		$genid = $details['genid'];
		$licence = $details['licence'];
		$nom = $details['nom'];
		$prenom = $details['prenom'];
		$anniversaire = $details['anniversaire'];
		$sexe = $details['sexe'];
		$adresse = $details['adresse'];
		$code_postal = $details['code_postal'];
		$ville = $details['ville'];
		$pays = $details['pays'];
		$image = $details['image'];	
	}
	
	

				
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('edit_adherent.tpl'), null, null, $smarty);
	$tpl->assign('edit', $edit);
	$tpl->assign('genid', $genid);
	$tpl->assign('actif', $actif);
	$tpl->assign('nom', $nom);
	$tpl->assign('licence', $licence);
	$tpl->assign('prenom', $prenom);
	$tpl->assign('sexe', $sexe);
	$tpl->assign('anniversaire', $anniversaire);
	$tpl->assign('liste_sexe', $liste_sexe);
	$tpl->assign('adresse', $adresse);
	$tpl->assign('code_postal', $code_postal);
	$tpl->assign('ville', $ville);
	$tpl->assign('pays', $pays);
	$tpl->assign('image', $image);
	$tpl->display();
			
	//$query.=" ORDER BY date_compet";
//echo $this->ProcessTemplate('edit_adherent.tpl');
}
	

#
#EOF
#
?>