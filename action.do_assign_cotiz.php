<?php
if (!isset($gCms)) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
debug_display($_POST, 'Parameters');
if (!$this->CheckPermission('Adherents use') && !$this->CheckPermission('Cotisations use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
if(isset($_POST['cancel']))
{
	$this->Redirect();
}
$message = '';
$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
		
		$genid = '';
		if (isset($_POST['genid']) && $_POST['genid'] != '')
		{
			$genid = $_POST['genid'];
		}
		else
		{
			$error++;
		}
		
	
		if($error ==0)
		{
			
			$group = array();
			if (isset($_POST['group']) && $_POST['group'] != '')
			{
				$group = $_POST['group'];
			}
			//var_dump($group);
			$cotisation_ops = new cotisationsbis();
			$paiements_ops = new paiementsbis();
			$paiem = new Paiements;
			$exercice = $paiem->GetPreference('exercice');
			
			//on supprime toutes les appartenances de cet utilisateur
			
			//on supprime aussi ds Paiements ? Il faudrait bloquer les cotiz déjà payées....
			
			$del = $cotisation_ops->delete_user_cotis($genid);
			$categorie = 'R';
			$actif = 1;
			$regle = 0;
			$statut = 1;
			
			
			foreach($group as $key=>$value)
			{
				$ref_action = 'Cotiz_'.$genid.'_'.$value;//$this->random_string(15);
				$add_cotis_to_user = $cotisation_ops->add_user_cotis($ref_action,$value, $genid);
				
				//la requete a fonctionné ? On ajoute à la table Paiements
				if(true == $add_cotis_to_user)
				{
					//on ajoute 
					$message.="Adhérent(s) ajouté(s) au groupe.";
					$tableau = $cotisation_ops->types_cotisations($value);
					//var_dump($nom);
					if(is_array($tableau))
					{
						$nom = $tableau['nom'];
						$tarif = $tableau['tarif'];
						$module = 'Cotisations';
						$add = $paiements_ops->add_paiement($genid,$ref_action,$categorie,$module,$nom,$tarif,$actif, $statut, $regle, $exercice);
						if(true === $add)
						{
							$message.=" Envoyé au module Paiements.";
						}
						//var_dump($add);
					
					}
				
				}
			}
		$this->SetMessage($message);
			
				
				
		}
		else
		{
			echo "Il y a des erreurs !";
		}
		


$this->Redirect($id, 'view_adherent_details', $returnid, array("record_id"=>$genid));

?>