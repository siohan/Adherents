<?php
if (!isset($gCms)) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
debug_display($_POST, 'Parameters');
if (!$this->CheckPermission('Adherents use') )
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
		
$ref_action = array();
if (isset($_POST['ref_action']) && $_POST['ref_action'] != '')
{
	$ref_action = $_POST['ref_action'];
}

$cotisation_ops = new cotisationsbis();
$pay_ops = new paiementsbis;
$paiem = new Paiements;
$com_ops = new commandes_ops;

$categorie = 'R';
$actif = 1;
$statut = 1;
$regle = 1;
$tab = array();
$exercice = $paiem->GetPreference('exercice');



foreach($ref_action as $key=>$value)
{
	$details = $pay_ops->details_paiement($value);
	
	if($details['module'] == 'Cotisations')
	{
		$add_cotis_to_user = $cotisation_ops->cotis_paid($value);
		//on décompose la ref_action pour obtenir le genid et le type de cotisation
		$tab = explode('_', $value);
		
		
		if(true == $add_cotis_to_user)
		{
			//on ajoute 
			$message.=".";
			$tableau = $cotisation_ops->types_cotisations($tab[2]);
			//var_dump($nom);
			if(is_array($tableau))
			{
				$nom = $tableau['nom'];
				$tarif = $tableau['tarif'];
				$module = 'Cotisations';
				$del = $pay_ops->delete_paiement($value);
				$add = $pay_ops->add_paiement($tab[2],$value,$categorie,$module,$nom,$tarif, $actif,$statut,$regle, $exercice);

				$message.=" Envoyé au module Paiements.";
			

			}

		}
	}
	elseif($details['module'] == 'Commandes')
	{
		
		
		$item_paid = $com_ops->item_paid($value);
		$del = $pay_ops->delete_paiement($value);
		$add = $pay_ops->add_paiement($details['licence'],$value,$categorie,$details['module'],$details['nom'],$details['tarif'],$actif,$statut,$regle, $exercice);
		$message.=" Envoyé au module Paiements.";
	
	}
	
	


	//la requete a fonctionné ? On ajoute à la table Paiements
	

}
$this->SetMessage($message);
			
$this->Redirect($id, 'view_adherent_details', $returnid, array("record_id"=>$details['licence']));

?>