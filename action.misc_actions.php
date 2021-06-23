<?php
set_time_limit(300);
if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents_use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db = cmsms()->GetDb();
global $themeObject;
$aujourdhui = date('Y-m-d');

$gp_ops = new groups;
$adh_feu = new AdherentsFeu;
$feu = \cms_utils::get_module('FrontEndUsers');
debug_display($params, 'Parameters');

if(isset($params['obj']) && $params['obj'] != '')
{
	$obj = $params['obj'];
}
else
{
	//redir
}
switch($obj)
{
	//Supprime un groupe du module Adhérents (et donc de FEU)
	case "delete_group" :
		$db = cmsms()->GetDb();
		if(isset($params['record_id']) && $params['record_id'] != '')//le record_id est l'id du groupe ds le module adherents
		{
			$record_id = (int) $params['record_id'];
			//on supprime les utilisateurs du groupe en question ds adhérents et FEU
			$details = $gp_ops->details_groupe($record_id);//pour récupérer l'id du groupe ds FEU
			$feu_gid = $details['feu_gid'];
			$del_feusers = $adh_feu->RemoveAllUsersFromGroup($feu_gid);
			$del_adhusers = $gp_ops->delete_group_belongs ($record_id);
			//les appartenances ont été supprimées, on peut maintenant supprimer les groupes
			$gp_ops->delete_group($record_id);
			//on supprime aussi les relations entre les propriétés du groupe et le groupe ds FEU
			$feu->DeleteAllGroupPropertyRelations($feu_gid);
			$gp_ops->delete_group($record_id);
		}		
		
		$this->RedirectToAdminTab('groups');
	break;
	
		
	
}
