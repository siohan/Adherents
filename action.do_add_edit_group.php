<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

	if (!$this->CheckPermission('Adherents use'))
	{
		$designation .=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('adherents');
	}

//on récupère les valeurs
//pour l'instant pas d'erreur
$aujourdhui = date('Y-m-d ');
$error = 0;
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
	
		
		
		if (isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = $params['record_id'];
			$edit = 1;
		}		
		
	
		
		$nom = '';
		if (isset($params['nom']) && $params['nom'] !='')
		{
			$nom = $params['nom'];
		}
		else
		{
			$error++;
		}
		
		$description = '';
		if (isset($params['description']) && $params['description'] !='')
		{
			$description = $params['description'];
		}
		
		
		
		
		$actif = 0;
		if (isset($params['actif']) && $params['actif'] !='')
		{
			$actif = $params['actif'];
		}
		
		$public = 0;
		if (isset($params['public']) && $params['public'] !='')
		{
			$public = $params['public'];
		}
		
		
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->RedirectToAdminTab('groups');
		}
		else // pas d'erreurs on continue
		{
			
			$feu = cms_utils::get_module('FrontEndUsers');
			
			
			if($edit == 0)
			{
				$query = "INSERT INTO ".cms_db_prefix()."module_adherents_groupes (nom, description, actif, public) VALUES ( ?, ?, ?, ?)";
				$dbresult = $db->Execute($query, array($nom, $description, $actif, $public));
			}
			else
			{
				$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET nom = ?, description = ?, actif = ?, public = ? WHERE id = ?";
				$dbresult = $db->Execute($query, array($nom, $description, $actif, $public, $record_id));
				
				
			}
			
			
			
		}		
	//	echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Groupe modifié ou ajouté');
$this->RedirectToAdminTab('groups',$params='');

?>