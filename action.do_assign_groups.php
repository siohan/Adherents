<?php
if (!isset($gCms)) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
debug_display($_POST, 'Parameters');


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
$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
		
		$genid = '';
		if (isset($_POST['genid']) && $_POST['genid'] != '')
		{
			$record_id = $_POST['genid'];
		}
		else
		{
			$error++;
		}
	
		if($error ==0)
		{
			//on vire toutes les données de cette compet avant 
			$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE genid = ?";
			$dbquery = $db->Execute($query, array($record_id));
			
			//la requete a fonctionné ?
			
			if($dbquery)
			{
				$group = '';
				if (isset($_POST['group']) && $_POST['group'] != '')
				{
					$group = $_POST['group'];
					//$error++;
				}
				foreach($group as $key=>$value)
				{
					$query2 = "INSERT INTO ".cms_db_prefix()."module_adherents_groupes_belongs (id_group,genid) VALUES ( ?, ?)";
					//echo $query2;
					$dbresultat = $db->Execute($query2, array($value,$record_id));
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