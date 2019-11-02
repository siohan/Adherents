<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');


if( isset($params['cancel']) )
{
	$this->Redirect($i, 'default', $returnid);
	return;
}
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');

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
		$anniversaire = '';
		if (isset($params['anniversaire']) && $params['anniversaire'] !='')
		{
			$anniversaire = $params['anniversaire'];
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
			$this->Redirect($id, 'edit_adherent',$returnid, array("genid"=>$username));//ToAdminTab('commandesclients');
		}
		else // pas d'erreurs on continue
		{
			
			$service = new Asso_adherents;
			
			
				$update_adherent = $service->fe_edit_adherent($username,$anniversaire,$adresse,$code_postal,$ville);
			
			
		
			
		}		
		//echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Adhérent modifié');
$this->Redirect($id,'fe_adherent_infos', $returnid, array("record_id"=>$licence));

?>