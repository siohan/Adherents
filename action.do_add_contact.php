<?php
if (!isset($gCms)) exit;
debug_display($params, 'Parameters');

if (!$this->CheckPermission('Adherents use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('adherents');
}
if( isset($params['cancel']) )
{
	$this->RedirectToAdminTab('adherents');
	return;
}

//on récupère les valeurs
//pour l'instant pas d'erreur
$aujourdhui = date('Y-m-d ');
$error = 0;
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
$alert = 0;//pour savoir si certains champs doivent contenir une valeur ou non
	
		
		
		$licence = '';
		if (isset($params['licence']) && $params['licence'] !='')
		{
			$licence = $params['licence'];
		}
		else
		{
			$error++;
		}
		
		$record_id = '';
		if (isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = $params['record_id'];
			$edit = 1;
		}
		$type_contact = '';
		if (isset($params['type_contact']) && $params['type_contact'] !='')
		{
			$type_contact = $params['type_contact'];
		}
		
		
		if($type_contact == "email")
		{
			$alert = 1;
		}
		
		
		$contact = '';
		if (isset($params['contact']) && $params['contact'] !='')
		{
			$contact = $params['contact'];
		}
		elseif($params['contact'] =='' )
		{
			$error++;
		}
		
		$description = '';
		if (isset($params['description']) && $params['description'] !='')
		{
			$description = $params['description'];
		}
	
		
		
		
		$statut_item = '1';
		if (isset($params['statut_item']) && $params['statut_item'] !='')
		{
			$statut_item = $params['statut_item'];
		}
		
		
	
		
		//s'agit-il d'une édition ou d'un ajout ?
		//$record_id = '';
		if(isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = $params['record_id'];
			$edit = 1;//c'est un update
		}
		
		
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->Redirect($id, 'add_edit_contact',$returnid, array("licence"=>$licence, "edit"=>$edit));//ToAdminTab('commandesclients');
		}
		else // pas d'erreurs on continue
		{
			
			$service = new contact();
			
			if($edit == 0)
			{
				$add_contact = $service->add_contact($licence, $type_contact,$contact,$description);				
			}
			else
			{
				$update_contact = $service->update_contact($type_contact,$contact,$description,$record_id);
			}
			
		
			
		}		
		//echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Contact modifié');
$this->Redirect($id,'view_contacts', $returnid, array("licence"=>$licence));

?>