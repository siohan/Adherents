<?php
if( !isset($gCms) ) exit;
//echo "Cool !";
//debug_display($params, 'Parameters');
$asso_ops = new Asso_adherents;
$display = 'default';
if(isset($params['display']) && $params['display'] =='liste') //pour afficher des liste en front end
{
	$display = $params['display'];
//	require(__DIR__.'/action.adherents.php');
	//echo $display;
	$this->Redirect($id, 'adherents', $returnid, array("record_id"=>$params['record_id']));
}
elseif($params['display'] == 'crea')
{
	//ajout d'un nouvel adhérent depuis le frontend
	//on redirige
	//le record_id est le id_group
	if($params['id_inscription'] >0 && $params['id_group'] >0)
	{
		$this->Redirect($id, 'feu_edit_adherent', $returnid, array("id_group"=>$params['id_group'], "id_inscription"=>$params['id_inscription']));
	}
	else
	{
		echo "Erreur !!";
	}
	
}
elseif($params['display'] == 'activate')
{
	$this->Redirect($id, 'feu_activate', $returnid, array("record_id"=>$params['record_id'], "id_inscription"=>$params['id_inscription'], "id_group"=>$params['id_group']));
}
elseif((isset($params['display']) && $params['display'] != 'liste') || !isset($params['display']))
{
	$display = $params['display'];
	$feu = cms_utils::get_module('FrontEndUsers');
	$userid = $feu->LoggedInId();
	if($userid =='' || true == is_null($userid))
	{
		$feu->Redirect($id,"login",$returnid);
	}
	else
	{
		$properties = $feu->GetUserProperties($userid);
	//	$email = $feu->LoggedInEmail();
		$username = $feu->GetUserProperty('genid');//($userid);
	}
//	var_dump($userid);


	//$path = pathinfo();
	//var_dump($path);
	switch($display)
	{
		

		case 'infos' :
		require(__DIR__.'/action.fe_adherent_infos.php');
		break;

		case 'sportif' :
		//faire un lien pour rediriger vers une commande particulière
		require(__DIR__.'/action.fe-sportif.php');
		break;

		case 'mon-compte' :
		require(__DIR__.'/action.moncompte.php');
		break;

		//visualise une commande en particulier
		case 'feViewCc' :
		require(__DIR__.'/action.feViewCc.php');
		break;

		//ajoute une nouvelle commande
		case 'fe_add_cc' :
		require(__DIR__.'/action.fe_add_cc.php');
		break;

		//ajoute un nouvel article à cette commande
		case 'add_cc_items' :
		require(__DIR__.'/action.fe_add_cc_items.php');
		break;

		//un utilisateur connecté ajoute un nouvel article
		case 'fe_add_item' :
		require(__DIR__.'/action.fe_add_item.php');
		break;

		//visualise mes commandes
		case 'fe_commandes' :
		require(__DIR__.'/action.fe_commandes.php');
		break;

		case 'fe_messages' :
		require(__DIR__.'/action.fe_messages.php');
		break;

		case 'joueurs' :
		require(__DIR__.'/action.fe_commandes.php');	
		break;

		case 'compos' :
		require(__DIR__.'/action.fe_compos.php');	
		break;

		case 'fe_envoi_message' : 
		require(__DIR__.'/action.fe_envoi_message.php');
		break;

		case 'delete' :
		require(__DIR__.'/action.fe_delete.php');
		break;

		case 'validate' :
		require(__DIR__.'/action.fe_validate.php');
		break;
		
		case 'add_edit_compo':
		require(__DIR__.'/action.fe_add_edit_compos_equipe.php');
		break;
		
		case 'contacts':
		require(__DIR__.'/action.fe_view_contacts.php');
		break;
		
		case 'default' :
		require(__DIR__.'/action.fe_adherent_infos.php');
		break;

		default:
		require(__DIR__.'/action.fe_adherent_infos.php');
		break;

	}
}


#
# EOF
#

?>