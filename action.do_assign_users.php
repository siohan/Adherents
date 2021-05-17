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
$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
		
		$record_id = '';//c'est le groupe
		if (isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
			//on récupère le nom du groupe ds le module Adherents pour le id du groupe ds FEU
			$details = $gp_ops->details_groupe($record_id);
			$nom_gp = $details['nom'];
			//on cherche son id dans FEU
			$feu = \cms_utils::get_module('FrontEndUsers');
			$feu_gp = $feu->GetGroupId($nom_gp);
			
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