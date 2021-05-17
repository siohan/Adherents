<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class AdherentsFeu
{
  function __construct() {}

	function last_logged($record_id)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "SELECT refdate FROM ".cms_db_prefix()."module_feusers_history WHERE userid = ? AND action LIKE '%login%' ORDER BY refdate DESC LIMIT 1";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			if($dbresult->recordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$lastused = $row['refdate'];
				return $lastused;
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
	function GetUserInfoByProperty($genid)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT userid FROM ".cms_db_prefix()."module_feusers_properties up WHERE up.title = 'genid' AND data = ? LIMIT  1";
		
		$uid = $db->GetOne($query,array($genid));
		if(! $uid)
		{
			return false;
		}
		else
		{
			return (int) $uid;
		}
		
	}
	
	function count_groups()
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_feusers_groups";
		$dbresult = $db->Execute($query);
	}
	
	//ajoute le uid de FEU dans le module adherents
	 function feu_id($genid,$record_id)
	 {
	 	$db = cmsms()->GetDb();
	 	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET feu_id = ? WHERE genid = ?";
	 	$dbresult = $db->Execute($query, array($record_id, $genid));
	 }
	 
	 //ajoute le gid de FEU dans le module adherents
	 function feu_gid($id,$record_id)
	 {
	 	$db = cmsms()->GetDb();
	 	$query = "UPDATE ".cms_db_prefix()."module_adherents_groupes SET feu_gid = ? WHERE id = ?";
	 	$dbresult = $db->Execute($query, array($record_id, $id));
	 }
	
	function removefromallgroups($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_feusers_belongs WHERE userid = ?";
		$dbresult = $db->Execute($query, array($record_id));
	}
	
	//ajoute les propertyrelations pour chaque groupe
	function AddPropertyRelations($gid)
	{
		$feu = cms_utils::get_module('FrontEndUsers');
		$name = "email";
		$sortkey = 1;
		$required = 2; //2= requis, 1 optionnel, 0 = off
		// on peut assigner les propriétés au groupe  
		$add_rel1 = $feu->AddGroupPropertyRelation($gid,$name,$sortkey, $required);
		
		//On fait la même chose pour la deuxième propriété 
		$name = "nom";		
		$sortkey = 1;
		$required = 2; //2= requis, 1 optionnel, 0 = off
		// on peut assigner les propriétés au groupe  
		$add_rel2 = $feu->AddGroupPropertyRelation($gid,$name,$sortkey, $required);
		
		// On fait la même chose pour la troisième propriété 
		$name = "genid";
		$sortkey = 1;
		$required = 0; //2= requis, 1 optionnel, 0 = off
		// on peut assigner les propriétés au groupe 
		$add_rel3 = $feu->AddGroupPropertyRelation($gid,$name,$sortkey, $required);
	}
	//récupère le genid depuis le feu_id
	function get_genid($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT genid FROM ".cms_db_prefix()."module_adherents_adherents WHERE feu_id = ? LIMIT 1";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$row = $dbresult->FetchRow();
			$genid = $row['genid'];
			return $genid;
		}
		else
		{
			return false;
		}
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