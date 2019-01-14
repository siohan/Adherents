<?php
if (!isset($gCms)) exit;
debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
require_once(dirname(__FILE__).'/include/fe_menu.php');
$pres_ops = new T2t_presence;
$delete = '<img src="modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$modif = '<img src="modules/Adherents/images/edit.gif" class="systemicon" alt="Modifier" title="Modifier">';
$vrai = '<img src="modules/Adherents/images/true.gif" class="systemicon" alt="Vrai" title="Vrai">';
$faux = '<img src="modules/Adherents/images/false.gif" class="systemicon" alt="Faux" title="Faux">';
if(isset($params['id_presence']) && $params['id_presence'] !='')
{
	$id_presence = $params['id_presence'];
}
if(isset($params['reponse']) && $params['reponse'] !='')
{
	$reponse = $params['reponse'];
}

$db = cmsms()->GetDb();
$del_rep = $pres_ops->delete_reponse($id_presence, $username);
if(true === $del_rep)
{
	$add_rep = $pres_ops->add_reponse($id_presence, $username, $reponse);
	$this->SetMessage('Réponse modifiée');
}

$this->Redirect($id, 'fe_presences', $returnid, array("username"=>$username));
#
# EOF
#

?>