<?php
if( !isset($gCms) ) exit;
//echo "Cool !";
//debug_display($params, 'Parameters');

$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$properties = $feu->GetUserProperties($userid);
$email = $feu->LoggedInEmail();
//var_dump($email);
$username = $feu->GetUsername($userid);
//echo "le username est : ".$username;
if($username == '')
{
	//echo "pas de résultats, on fait quoi ?";
	//on redirige vers le formulaire de login
	$feu->Redirect($id,"login",$returnid);
	exit;
}

$display = 'default';
if(isset($params['display']) && $params['display'] !='')
{
	$display = $params['display'];
}

//echo $display;
//$path = pathinfo();
//var_dump($path);
switch($display)
{
	case 'infos' :
	require(__DIR__.'/action.fe_edit_adherent.php');
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
	
	case 'joueurs' :
	require(__DIR__.'/action.fe_commandes.php');	
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
	
	case 'default' :
	require(__DIR__.'/action.moncompte.php');
	break;
	
	default:
	require(__DIR__.'/action.moncompte.php');
	break;
	
}
#
# EOF
#

?>