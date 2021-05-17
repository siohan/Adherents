<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class contact
{
  function __construct() {}

	//récupère les détails d'un contact
	function details_contact($record_id)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "SELECT id, genid, type_contact, contact, description FROM ".cms_db_prefix()."module_adherents_contacts WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$details = array();
			while($row = $dbresult->fetchRow())
			{
				$details['id'] = $row['id'];
				$details['genid'] = $row['genid'];
				$details['type_contact'] = $row['type_contact'];
				$details['contact'] = $row['contact'];
				$details['description'] = $row['description'];
			}
			return $details;
		}
		
		
	}
	
	
	//récupère les détails d'un contact à partir de son genid
	function details_contact_by_genid($record_id)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "SELECT id, genid, type_contact, contact, description FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$details = array();
			while($row = $dbresult->fetchRow())
			{
				$details['id'] = $row['id'];
				$details['genid'] = $row['genid'];
				$details['type_contact'] = $row['type_contact'];
				$details['contact'] = $row['contact'];
				$details['description'] = $row['description'];
			}
			return $details;
		}
		
		
	}
	
	function delete_contact($record_id)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_adherents_contacts WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));

	}
	
	function add_contact($genid, $type_contact,$contact,$description)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_adherents_contacts (genid, type_contact,contact, description) VALUES (?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($genid, $type_contact,$contact,$description));
		if($dbresult)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function update_contact($type_contact,$contact,$description,$record_id)
	{
		
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_adherents_contacts SET type_contact = ?, contact =?, description = ? WHERE id = ?";
		$dbresult = $db->Execute($query, array($type_contact,$contact,$description,$record_id));
		if($dbresult)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	//Cette fonction vérifie si le licencié a une adresse email répertoriée
	function has_email($genid)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ? AND type_contact = 1";
		$dbresult = $db->Execute($query, array($genid));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	//vérifie si l'adhérent a un mobile répertorié
	function has_mobile($genid)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ? AND type_contact = 2";
		$dbresult = $db->Execute($query, array($genid));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	function email_address($genid)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ? AND type_contact = 1";
		$dbresult = $db->Execute($query, array($genid));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$email = $row['contact'];
			return $email;
		}
		else
		{
			return FALSE;
		}
		
	}
	//récupère le N° de portable d'un licencié
	function mobile($genid)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ? AND type_contact = 2";
		$dbresult = $db->Execute($query, array($genid));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$email = $row['contact'];
			return $email;
		}
		else
		{
			return FALSE;
		}
		
	}
	//récupère tous les groupes actifs
	function liste_groupes()
	{
		$db = cmsms()->GetDb();
		$query = "SELECT id,nom  FROM ".cms_db_prefix()."module_adherents_groupes WHERE actif = 1";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$retour[$row['nom']] = $row['id'];				
				
			}
			return $retour;
		}
		else
		{
			return FALSE;
		}
	}
	//récupère tous les groupes actifs pour les formulaires
	function liste_groupes_dropdown()
	{
		$db = cmsms()->GetDb();
		$query = "SELECT id,nom  FROM ".cms_db_prefix()."module_adherents_groupes WHERE actif = 1";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$retour[$row['id']] = $row['nom'];				
				
			}
			return $retour;
		}
		else
		{
			return FALSE;
		}
	}
	//récupère la liste des groupes contactables depuis l'espace privé (public =1)
	function liste_groupes_publiques()
	{
		$db = cmsms()->GetDb();
		$query = "SELECT id,nom  FROM ".cms_db_prefix()."module_adherents_groupes WHERE actif = 1 AND public = 1";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$retour[$row['nom']] = $row['id'];				
				
			}
			return $retour;
		}
		else
		{
			return FALSE;
		}
	}

	//récupère les détails d'un groupe
	function details_group($id_group)
	{
		$db = cmsms()->GetDb();
		$details = array();
		$query = "SELECT id, nom, description, actif FROM ".cms_db_prefix()."module_adherents_groupes WHERE actif = 1 AND id = ?";
		$dbresult = $db->Execute($query, array($id_group));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$details['id'] = $row['id'];
				$details['nom'] = $row['nom'];
				$details['description'] = $row['description'];
				$details['actif'] = $row['actif'];
			}
			return $details;
		}
		else
		{
			return FALSE;
		}
	}
	//Cette fonction récupère les genid des adhérents commun à plusieurs groupes
	function UsersFromGroups($id_group)
	{
		$db = cmsms()->GetDb();
		//on regarde s'il y a plusieurs groupes, présence d'au moins une virgule
		$tab = explode(',', $id_group);
		//var_dump($tab);
		$parms = array();
		if(is_array($tab))
		{
			
			$iteration = count($tab);
		//	echo $iteration;
			$i = 1;
			$query = "SELECT DISTINCT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE genid   ";
			foreach ($tab as $value)
			{
				
				
				if($i == 1)
				{
					$query.=" IN (SELECT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?)";
				}
				else
				{
					$query.=" AND genid IN (SELECT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?)";
				}
				
				$parms[] = $value;
				
				$i++;
				
			}
			var_dump($parms);
			echo $query;
			
			$dbresult = $db->Execute($query,$parms);
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$licencies[] = $row['genid'];
				}
				return $licencies;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			//on 
			$query = "SELECT DISTINCT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group   ";
			$dbresult = $db->Execute($query, array($id_group));
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$licencies[] = $row['genid'];
				}
				return $licencies;
			}
			else
			{
				return FALSE;
			}
		}
		
	}
	//Cette fonction récupère les genid des adhérents d'un groupe donné
	function UsersFromGroup($id_group)
	{
		$db = cmsms()->GetDb();
		
		$query = "SELECT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
		$dbresult = $db->Execute($query, array($id_group));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$licencies[] = $row['genid'];
			}
			return $licencies;
		}
		else
		{
			return FALSE;
		}
	}
	function CountUsersFromGroup($id_group)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
		$dbresult = $db->Execute($query, array($id_group));
		if($dbresult)
		{
			$row = $dbresult->FetchRow();
			$nb = $row['nb'];
				}
		else
		{
			 $nb = 0;
		}
		return $nb;
	}
	
	
##
##
#
#
#
}//end of class
#
# EOF
#
?>