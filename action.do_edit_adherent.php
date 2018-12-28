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
$alert = 0;//pour savoir si certains champs doivent contenir une valeur ou non
$edit = 1;	
		
		
		
	
		$fftt = 1;		
		if (isset($params['fftt']) && $params['fftt'] !='')
		{
			$fftt = $params['fftt'];
		}
		$licence = '';
		if (isset($params['licence']) && $params['licence'] !='')
		{
			$licence = $params['licence'];
		}
		else
		{
			
			$licence = $edit = 0;
		}
		
		$nom = '';
		if (isset($params['nom']) && $params['nom'] !='')
		{
			$nom = strtoupper($params['nom']);
		}
		$anniversaire = '1900-01-01';
		if (isset($params['anniversaire']) && $params['anniversaire'] !='')
		{
			$anniversaire = $params['anniversaire'];
		}
		$prenom = '';
		if (isset($params['prenom']) && $params['prenom'] !='')
		{
			$prenom = $params['prenom'];
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
			if($edit == 1)
			{
				$update_adherent = $service->edit_adherent($edit,$fftt,$licence,$nom, $prenom,$anniversaire,$adresse,$code_postal,$ville);
			}
			else
			{
				$add_adherent = $service->add_adherent($fftt,$licence,$nom,$prenom,$anniversaire,$adresse, $code_postal, $ville);
			}
			
		}		
		//echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Adhérent modifié');
$this->Redirect($id,'defaultadmin', $returnid);

?>