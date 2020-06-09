<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class groups
{
  function __construct() {}

##
##

	

//Tous les détails d'un groupe
function details_groupe($record_id)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id,nom, description, actif, public, auto_subscription, admin_valid, tag, tag_subscription, pageid_aftervalid FROM ".cms_db_prefix()."module_adherents_groupes WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	$details_groupe = array();
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$details_groupe['id'] = $row['id'];
			$details_groupe['nom'] = $row['nom'];
			$details_groupe['description'] = $row['description'];
			$details_groupe['actif'] = $row['actif'];
			$details_groupe['public'] = $row['public'];
			$details_groupe['auto_subscription'] = $row['auto_subscription'];
			$details_groupe['admin_valid'] = $row['admin_valid'];
			$details_groupe['tag'] = $row['tag'];
			$details_groupe['tag_subscription'] = $row['tag_subscription'];
			$details_groupe['pageid_aftervalid'] = $row['pageid_aftervalid'];
		}
		return $details_groupe;
	}
	else
	{
		return FALSE;
	}
	
}
//ajoute un nouveau groupe
function add_group($nom, $description, $actif, $public, $auto_subscription, $admin_valid, $pageid_aftervalid)
{
	$db = cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_adherents_groupes (nom, description, actif, public, auto_subscription, admin_valid, pageid_aftervalid) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($nom, $description, $actif, $public, $auto_subscription, $admin_valid, $pageid_aftervalid));
	if($dbresult)
	{
	 	$insertid = $db->Insert_ID();
		return $insertid;
	}
	else
	{
		return false;
	}
}
//modifie un groupe existant
function edit_group($nom, $description, $actif, $public,$auto_subscription, $admin_valid,$pageid_aftervalid, $record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET nom = ?, description = ?, actif = ?, public = ?, auto_subscription = ?, admin_valid = ?, pageid_aftervalid = ? WHERE id = ?";
	$dbresult = $db->Execute($query, array($nom, $description, $actif, $public,$auto_subscription, $admin_valid,$pageid_aftervalid, $record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//supprime un groupe completement
function delete_group($record_id)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes WHERE id = ?";
	$dbresult = $db->Execute($query,array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
	
	
}
//supprime tous les abonnements d'un groupe particulier
function delete_group_belongs ($record_id)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
	$dbresult = $db->Execute($query, array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
//compte le nb d'utilisateurs d'un groupe particulier
function count_users_in_group($id_group)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
	$dbresult = $db->Execute($query, array($id_group));
	$row = $dbresult->FetchRow();
	$nb = $row['nb'];
	return $nb;
}
//supprime un utilisateur d'un groupe particulier
function delete_user_from_group($record_id, $genid)
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ? AND genid = ?";
	$dbresult = $db->Execute($query, array($record_id,$genid));
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
	
}
//assigne un adhérent à un groupe
function assign_user_to_group($id_group, $genid)
{
	$db = cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_adherents_groupes_belongs (id_group,genid) VALUES ( ?, ?)";
	$dbresult = $db->Execute($query, array($id_group,$genid));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//assigne un nouvel utilisateur au groupe adherents( groupe par défaut)
function assign_to_adherent($genid)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id FROM ".cms_db_prefix()."module_adherents_groupes WHERE nom LIKE 'adherents' LIMIT 1";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		$row = $dbresult->fetchRow();
		$id_group = $row['id'];
		$this->assign_user_to_group($id_group, $genid);
		return $id_group;
	}
	else
	{
		return false;
	}
}
//retire un adhérent de tous les groupes où il est présent
function delete_user_from_all_groups($genid)
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
	
}
//supprime l'accès à l'espace privé
function delete_user_feu($genid)
{
	$feu = cms_utils::get_module('FrontEndUsers');	
	$supp_user = $feu->DeleteUserFull($genid);
	if(true == $supp_user)
	{
		return true;
	}
	else
	{
		return false;
	}
	
}
//créé une liste de tous les groupes actifs
function liste_groupes()
{
	
	$liste = array();
	$db = cmsms()->GetDb();
	$query = "SELECT id, nom FROM ".cms_db_prefix()."module_adherents_groupes WHERE actif = 1 ORDER BY nom ASC";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		while($row = $dbresult->fetchRow())
		{
			$liste[$row['nom']] = $row['id'];
		}
		
		//$this->assign_user_to_group($id_group, $licence);
		return $liste;
	}
	else
	{
		return false;
	}
}
//crée une liste des groupes actifs pour un formulaire dropdown
function liste_groupes_dropdown()
{
	
	$liste = array();
	$db = cmsms()->GetDb();
	$query = "SELECT id, nom FROM ".cms_db_prefix()."module_adherents_groupes WHERE actif = 1 ORDER BY nom ASC";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		while($row = $dbresult->fetchRow())
		{
			$liste[$row['id']] = $row['nom'];
		}
		
		//$this->assign_user_to_group($id_group, $licence);
		return $liste;
	}
	else
	{
		return false;
	}
}
//Fais la liste des genids d'un groupe donné
function liste_licences_from_group($id_group)
{
	$db = cmsms()->GetDb();
	$query = "SELECT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
	$dbresult = $db->Execute($query, array($id_group));
	$liste_licences = array();
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$genid = $row['genid'];
			$liste_genids[] = $row['genid'];
		}
		return $liste_genids;
	}
	else
	{
		return false;
	}
	
}
//
//Fais la liste des genids et nom d'un groupe donné (pour formulaire)
function liste_nom_genid_from_group($id_group)
{
	$db = cmsms()->GetDb();
	$query = "SELECT be.genid, CONCAT_WS(' ', adh.nom, adh.prenom) AS joueur FROM ".cms_db_prefix()."module_adherents_groupes_belongs AS be, ".cms_db_prefix()."module_adherents_adherents AS adh WHERE adh.genid = be.genid AND  be.id_group = ? ORDER BY adh.nom ASC";
	$dbresult = $db->Execute($query, array($id_group));
	$liste_genids = array();
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$ass_ops = new Asso_adherents;
		
		while($row = $dbresult->FetchRow())
		{
			$genid = $row['genid'];
			$nom = $ass_ops->get_name($genid);
			
			$liste_genids[$row['genid']] = $row['joueur'];
		}
		return $liste_genids;
	}
	
	
}
//liste les groupes auxquels appartient un utilisateur
function member_of_groups($genid)
{
	$db = cmsms()->GetDb();
	$query = "SELECT DISTINCT id_group FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			$groups = array();
			while($row = $dbresult->FetchRow())
			{
				$groups[] = $row['id_group'];
			}
			return $groups;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
//détermine si un utilisateur appartient à un groupe particulier
function is_member($genid, $id_group)
{
	$db = cmsms()->GetDb();
	$query = "SELECT DISTINCT id_group FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE genid = ? AND id_group = ?";
	$dbresult = $db->Execute($query, array($genid, $id_group));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//créé un tag pour afficher la liste en Frontend
function create_tag($record_id)
{
	$db = cmsms()->GetDb();
	$tag = "{Adherents display=\"liste\" record_id=\"$record_id\"}";
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET tag = ? WHERE id = ?";
	$dbresult = $db->Execute($query, array($tag, $record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//créé un tag pour l'auto-enregistrement en frontend la liste en Frontend
function create_tag_auto($record_id)
{
	$db = cmsms()->GetDb();
	$tag = "{Adherents display=\"crea\" record_id=\"$record_id\"}";
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET tag_subscription = ? WHERE id = ?";
	$dbresult = $db->Execute($query, array($tag, $record_id));
}
//delete the existing tag
function delete_tag_auto($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET tag_subscription = '' WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//delete the existing tag
function delete_tag($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET tag = '' WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult && $dbresult->RecordCount() >0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//check if the list is private or public
function public_private($record_id)
{
	//
	$db = cmsms()->GetDb();
	$query = "SELECT public FROM ".cms_db_prefix()."module_adherents_groupes WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	$row = $dbresult->FetchRow();
	$public = $row['public'];
	return $public;
}
//Active un groupe
function activate_group($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET actif = 1 WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult && $dbresult->RecordCount() >0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//Désactive un groupe
function desactivate_group($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET actif = 0 , public = 0 , auto_subscription = 0, tag = '' , tag_subscription = '' WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult && $dbresult->RecordCount() >0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//rend un groupe public et génére un tag pour l'affichage
function publish_group($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET  public = 1  WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//dépublie un groupe 
function unpublish_group($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET  public = 0, tag = ''  WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//Permet l'auto-enregistrement dans un groupe 
function ok_auto($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET  auto_subscription = 1  WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//Supprime l'auto-enregistrement à un groupe

function ko_auto($record_id)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET  auto_subscription = 0  WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
#
#
#
}//end of class
#
# EOF
#
?>