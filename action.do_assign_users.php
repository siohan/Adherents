<?php
if (!isset($gCms)) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
//debug_display($params, 'Parameters');


if (!$this->CheckPermission('Adherents use'))
{
	$designation.=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('situation');
}
if(isset($params['cancel']))
{
	$this->RedirectToAdminTab('groups');
}
$gp_ops = new groups;
$adh_ops = new AdherentsFeu;
$adh = new Asso_adherents;
$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
$feu = \cms_utils::get_module('FrontEndUsers');
		
		$record_id = '';//c'est le groupe
		if (isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
			//on récupère le nom du groupe ds le module Adherents pour le id du groupe ds FEU
			$details = $gp_ops->details_groupe($record_id);
			$nom_gp = $details['nom'];
			//on cherche son id dans FEU			
			$feu_gid = $details['feu_gid'];
			
		}
		else
		{
			$error++;
		}
	
		if($error ==0)
		{
			//on vire toutes les données  
			$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
			$dbquery = $db->Execute($query, array($record_id));
			
			
			//la requete a fonctionné ?
			
			if($dbquery)
			{
				//idem on vire tous les utilisateurs de ce groupe ds FEU
				$adh_ops->RemoveAllUsersFromGroup($feu_gid);
				$licence = '';
				if (isset($params['licence']) && $params['licence'] != '')
				{
					$licence = $params['licence'];
					$error++;
				}
				foreach($licence as $key=>$value)
				{
					$query2 = "INSERT INTO ".cms_db_prefix()."module_adherents_groupes_belongs (id_group,genid) VALUES ( ?, ?)";
					//echo $query2;
					$dbresultat = $db->Execute($query2, array($record_id,$key));
					//idem ds FEU, on prend le feu_id du module Adhérents pour chq utilisateur
					$details = $adh->details_adherent_by_genid($key);
					$feu_id = $details['feu_id'];
					$assign_adh = $feu->AssignUserToGroup($feu_id,$feu_gid);
				}
			$this->SetMessage('Membres du groupe modifiés ajoutés !');
			}
			else
			{
				echo "la requete de suppression est down !";
			}
				
				
		}
		else
		{
			echo "Il y a des erreurs !";
		}
		


$this->RedirectToAdminTab('groups');

?>
