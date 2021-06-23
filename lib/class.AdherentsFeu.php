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
	
	//ajoute(modifie) le uid de FEU dans le module adherents
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
	//Vérifie si les toutes propriétés de base existent
	function propertiesExist()
	{
		$error = 0;
		$prop1 = $this->propertyExists('email');
		if(false == $prop1)
		{
			$error++;
		}	
		$prop2 = $this->propertyExists('nom');
		if(false == $prop2)
		{
			$error++;
		}	
		$prop3 = $this->propertyExists('genid');
		if(false == $prop3)
		{
			$error++;
		}
		return $error;	
	}
	// Vérifie si une propriété par défaut existe
	function propertyExists($prop)
	{
		$db = cmsms()->GetDb();
		$feu = cms_utils::get_module('FrontEndUsers');
		$query = "SELECT ? FROM ".cms_db_prefix()."module_feusers_propdefn";
		$dbresult = $db->Execute($query,array($prop));
		if($dbresult)
		{
			return true;
		}
		else
		{
			//on crée? 
			if($prop == 'email')
			{
				$name = "email";
				$prompt = "Ton email";		
				$type = 2;//0 = text; 1 = checkbox; 2 = email;3 = textarea; 4,5 = count(options)?;6 = image;7= radiobuttons; 8= date
				$length = 80;
				$maxlength = 255;		
				$add_prop1 = $feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = false, $encrypt = 0 );
				
				if(false == $add_prop1)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			elseif($prop == 'nom')
			{
				$name = "nom";
				$prompt = "Ton nom";
				$type = 0;
				$length = 80;
				$maxlength = 255;		
				$add_prop2 = $feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = false, $encrypt = 0 );
				
				if(false == $add_prop2)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			elseif($prop == 'genid')
			{
				$name = "genid";
				$prompt = "Ton ID";			
				$type = 0;
				$length = 10;
				$maxlength = 15;		
				$add_prop3 = $feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = false, $encrypt = 0 );
				
				if(false == $add_prop3)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			
		}
	}
	
	//ajoute les propriétés  nécessaires aux groupes
	function AddProperties()
	{
		//les propriétés sont les suivantes : email, nom, genid
		$feu = cms_utils::get_module('FrontEndUsers');
		$error = 0;
		$name = "email";
		$prompt = "Ton email";
		
		$type = 2;//0 = text; 1 = checkbox; 2 = email;3 = textarea; 4,5 = count(options)?;6 = image;7= radiobuttons; 8= date
		$length = 80;
		$maxlength = 255;		
		$add_prop1 = $feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = false, $encrypt = 0 );
		var_dump($add_prop1);
		
		//On fait la même chose pour la deuxième propriété 
		$name = "nom";
		$prompt = "Ton nom";
		
		$type = 0;
		$length = 80;
		$maxlength = 255;		
		$add_prop2 = $feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = false, $encrypt = 0 );
		
		// On fait la même chose pour la troisième propriété 
		$name = "genid";
		$prompt = "Ton ID";
		
		$type = 0;
		$length = 10;
		$maxlength = 15;		
		$add_prop3 = $feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = false, $encrypt = 0 );	
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
	//retire tous les utilisateurs d'un groupe FEU
	function RemoveAllUsersFromGroup($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_feusers_belongs WHERE groupid = ?";
		$dbresult = $db->Execute($query, array($record_id));
		
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
