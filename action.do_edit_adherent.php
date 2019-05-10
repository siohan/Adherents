<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

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
$edit = 0;	
		
		
		if (isset($params['genid']) && $params['nom'] !='0')
		{
			$genid = (int) $params['genid'];
			$edit = 1;
		}
		else
		{
			$genid = $this->random_int(9);
		}
		if (isset($params['nom']) && $params['nom'] !='')
		{
			$nom = strtoupper($params['nom']);
		}
		else
		{
			$error++;
		}
		if (isset($params['prenom']) && $params['prenom'] !='')
		{
			$prenom = $params['prenom'];
		}
		else
		{
			$error++;
		}
		$sexe = '';
		if (isset($params['sexe']) && $params['sexe'] !='')
		{
			$sexe = $params['sexe'];
		}
		$anniversaire = '1900-01-01';
		if (isset($params['anniversaire']) && $params['anniversaire'] !='')
		{
			$anniversaire = $params['anniversaire'];
		}
		
		$licence = '';
		if (isset($params['licence']) && $params['licence'] !='')
		{
			$licence = $params['licence'];
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
		$pays = '';
		if (isset($params['pays']) && $params['pays'] !='')
		{
			$pays = $params['pays'];
		}
		$actif = 1;
		if (isset($params['actif']) && $params['actif'] !='')
		{
			$actif = $params['actif'];
		}
		$externe = 0;
		if (isset($params['externe']) && $params['externe'] !='')
		{
			$externe = $params['externe'];
		}
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->Redirect($id, 'edit_adherent',$returnid, array("genid"=>$genid));//ToAdminTab('commandesclients');
		}
		else // pas d'erreurs on continue
		{
			
			$message = '';
			$service = new Asso_adherents();
			if($edit == 1)
			{
				$update_adherent = $service->update_adherent($actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe, $aujourdhui, $genid);
				$message.=" Adhérent modifié. ";
			}
			else
			{
				$add_adherent = $service->add_adherent($genid,$actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe);
				if(true === $add_adherent)
				{
					$message.=" Adhérent inséré. ";
					//on insère automatiquement le nouveau ds le gp par défaut 
					$gp_ops = new groups;
					$id_gp = $gp_ops->assign_to_adherent($genid);
					if(false !== $id_gp)
					{
						$message.=" Inscrit dans le groupe adhérent.";
					}
				}
			}
			
		}		
		//echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Adhérent modifié');
$this->Redirect($id,'defaultadmin', $returnid);

?>