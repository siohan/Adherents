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
		
		$adresse = '';
		if (isset($params['adresse']) && $params['adresse'] !='')
		{
			$adresse = $params['adresse'];
		}
		$code_postal = '';
		if (isset($params['code_postal']) && $params['code_postal'] !='')
		{
			$code_postal = $params['code_postal'];
		}
				
		$ville = '';
		if (isset($params['ville']) && $params['ville'] !='')
		{
			$ville = $params['ville'];
		}
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->Redirect($id, 'edit_adherent',$returnid, array("licence"=>$licence));//ToAdminTab('commandesclients');
		}
		else // pas d'erreurs on continue
		{
			
			$service = new adherents_spid();
			
			
				$update_adherent = $service->edit_adherent($licence,$adresse,$code_postal,$ville);
			
			
		
			
		}		
		//echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Contact modifié');
$this->Redirect($id,'view_contacts', $returnid, array("licence"=>$licence));

?>