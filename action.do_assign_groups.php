<?php
if (!isset($gCms)) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
//debug_display($_POST, 'Parameters');


if (!$this->CheckPermission('Adherents use'))
{
	$designation.=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('situation');
}
if(isset($_POST['cancel']))
{
	$this->RedirectToAdminTab('groups');
}
$asso_ops = new Asso_adherents;
$adh_ops = new AdherentsFeu;
$gp_ops = new groups;
$feu = \cms_utils::get_module('FrontEndUsers');
$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
		
		$genid = '';
		if (isset($_POST['genid']) && $_POST['genid'] != '')
		{
			$record_id = $_POST['genid'];
			//on récupère le feu_id de l'utilisateur
			$details = $asso_ops->details_adherent_by_genid($record_id);
			$feu_id = $details['feu_id'];
		}
		else
		{
			$error++;
		}
	
		if($error ==0)
		{
			//on supprime les appartenances ds adhrents_belongs
			$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE genid = ?";
			$dbquery = $db->Execute($query, array($record_id));
			
			//la requete a fonctionné ?
			
			if($dbquery)
			{
				//on fait pareil ds FEU on supprime les appartenances de l'utilisateur
				$adh_ops->removefromallgroups($feu_id);
				
				$group = '';
				if (isset($_POST['group']) && $_POST['group'] != '')
				{
					$group = $_POST['group'];
					//$error++;
				}
				foreach($group as $key=>$value)
				{
					$query2 = "INSERT INTO ".cms_db_prefix()."module_adherents_groupes_belongs (id_group,genid) VALUES ( ?, ?)";
					
					$dbresultat = $db->Execute($query2, array($value,$record_id));
					if($dbresultat)
					{
						//la requete a fonctionnée, on fait pareil dans FEU, on récupère le feu_gid avant
						$details = $gp_ops->details_groupe($value);
						$gid = $details['feu_gid'];
						$feu->AssignUserToGroup($feu_id,$gid);
					}
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
		


$this->Redirect($id, 'view_adherent_details', $returnid, array('record_id'=>$record_id));

?>