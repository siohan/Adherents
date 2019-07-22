<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class groups
{
  function __construct() {}

##
##

function add_group()
{
	
}
	

//Tous les détails d'un groupe
function details_groupe($record_id)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id,nom, description, actif, public FROM ".cms_db_prefix()."module_adherents_groupes WHERE id = ?";
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
		}
		return $details_groupe;
	}
	else
	{
		return FALSE;
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
	//$feu_ops = new FrontEndUsersManipulator;//cms_utils::get_module('FrontEndUsers');
	//on récupére le id de l'utilisateur
	$id = $feu->GetUserProperty($genid);
	$supp_user = $feu->DeleteUserFull($id);
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
//Fais la liste des genids d'un groupe donné'
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
#
#
#
}//end of class
#
# EOF
#
?>