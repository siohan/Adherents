<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org
#Claude SIOHAN, claude.siohan@gmail.com


class Asso_adherents
{
  function __construct() {}


##
##


function details_adherent($record_id)
{
	$db = cmsms()->getDb();
	$query  = "SELECT id, genid,licence, actif, nom, prenom, sexe, cat, certif, validation, adresse, code_postal, anniversaire, ville, pays, externe, maj FROM ".cms_db_prefix()."module_adherents_adherents WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		$details_adherent = array();
		 while ($dbresult && $row = $dbresult->FetchRow())
		{
			$details_adherent['id'] = $row['id'];
			$details_adherent['genid'] = $row['genid'];
			$details_adherent['actif'] = $row['actif'];
			$details_adherent['licence'] = $row['licence'];
			$details_adherent['certif'] = $row['certif'];
			$details_adherent['validation'] = $row['validation'];
			$details_adherent['nom'] = $row['nom'];
			$details_adherent['prenom'] = $row['prenom'];
			$details_adherent['sexe'] = $row['sexe'];
			$details_adherent['cat'] = $row['cat'];
			$details_adherent['adresse'] = $row['adresse'];			
			$details_adherent['code_postal'] = $row['code_postal'];
			$details_adherent['ville'] = $row['ville'];
			$details_adherent['pays'] = $row['pays'];			
			$details_adherent['anniversaire'] = $row['anniversaire'];
			$details_adherent['externe'] = $row['externe'];
			$details_adherent['maj'] = $row['maj'];			
		}		
		return $details_adherent;	
			
	}
}
function details_adherent_by_genid($record_id)
{
	$db = cmsms()->GetDb();
	$query  = "SELECT id, genid,licence, actif, nom, prenom, sexe, cat, certif, validation, adresse, code_postal, anniversaire, ville, pays, externe, maj FROM ".cms_db_prefix()."module_adherents_adherents WHERE genid = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		$details_adherent = array();
		 while ($dbresult && $row = $dbresult->FetchRow())
		{
			$details_adherent['id'] = $row['id'];
			$details_adherent['genid'] = $row['genid'];
			$details_adherent['actif'] = $row['actif'];
			$details_adherent['licence'] = $row['licence'];
			$details_adherent['certif'] = $row['certif'];
			$details_adherent['validation'] = $row['validation'];
			$details_adherent['nom'] = $row['nom'];
			$details_adherent['prenom'] = $row['prenom'];
			$details_adherent['sexe'] = $row['sexe'];
			$details_adherent['cat'] = $row['cat'];
			$details_adherent['adresse'] = $row['adresse'];			
			$details_adherent['code_postal'] = $row['code_postal'];
			$details_adherent['ville'] = $row['ville'];
			$details_adherent['pays'] = $row['pays'];			
			$details_adherent['anniversaire'] = $row['anniversaire'];
			$details_adherent['externe'] = $row['externe'];
			$details_adherent['maj'] = $row['maj'];			
		}		
		return $details_adherent;	
			
	}
}
function clean_name($texte)
{

	    $texte = mb_strtolower($texte, 'UTF-8');
	    $texte = str_replace(
	        array(
	            'à', 'â', 'ä', 'á', 'ã', 'å',
	            'î', 'ï', 'ì', 'í', 
	            'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
	            'ù', 'û', 'ü', 'ú', 
	            'é', 'è', 'ê', 'ë', 
	            'ç', 'ÿ', 'ñ' , "'"
	        ),
	        array(
	            'a', 'a', 'a', 'a', 'a', 'a', 
	            'i', 'i', 'i', 'i', 
	            'o', 'o', 'o', 'o', 'o', 'o', 
	            'u', 'u', 'u', 'u', 
	            'e', 'e', 'e', 'e', 
	            'c', 'y', 'n', ""
	        ),
	        $texte
	    );

	    return $texte;        

}
//génère un entier aléatoire
function random_int($car) {
	$string = "";
	$chaine = "123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
  }

function add_adherent($genid,$actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe )
{
	
	$db = cmsms()->GetDb();
	$maj = date('Y-m-d');
	$query = "INSERT INTO ".cms_db_prefix()."module_adherents_adherents (genid,actif, nom, prenom, sexe, anniversaire, licence, adresse, code_postal, ville, pays, externe, maj) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($genid, $actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe, $maj));
	if($dbresult)
	{
		return true;
	}
	else
	{
		echo $db->ErrorMsg();
	}
	

}//fin de la fonction
//ajoute un adhérent depuis le module Ping
function add_adherent_from_ping($genid,$actif, $nom, $prenom, $sexe, $licence)
{
	
	$db = cmsms()->GetDb();
	$maj = date('Y-m-d');
	$query = "INSERT INTO ".cms_db_prefix()."module_adherents_adherents (genid,actif, nom, prenom, sexe, licence) VALUES (?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($genid, $actif, $nom, $prenom, $sexe, $licence));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
	

}//fin de la fonction
 function update_adherent($actif, $nom, $prenom, $sexe, $anniversaire, $licence,$adresse, $code_postal, $ville, $pays,$externe, $maj, $genid)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET licence = ?, actif = ?, nom = ?, prenom = ?, sexe = ?, adresse = ?, code_postal = ?, anniversaire = ?, ville = ?, pays = ?, externe = ?, maj = ? WHERE genid = ?";
	$dbresult = $db->Execute($query, array($licence,$actif, $nom, $prenom, $sexe,$adresse, $code_postal,$anniversaire, $ville, $pays,$externe, $maj, $genid));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function get_name($genid)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_adherents_adherents WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$row = $dbresult->FetchRow();
		$joueur = $row['joueur'];
		return $joueur;
	}
	else
	{
		return FALSE;
	}
}
//détermine si un membre ayant une licence est déjà présent en bdd
function already_exists($licence)
{
	$db = cmsms()->GetDb();
	$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function activate ($genid)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET actif = 1 WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult)
	{
		$gp_ops = new groups;
		$id_group = $gp_ops->assign_to_adherent($genid);
	}
	
}
function desactivate ($genid)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET actif = 0 WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult)
	{
		$gp_ops = new groups;
		$id_group = $gp_ops->assign_to_adherent($genid);
		//maintenant on peut désactiver
		$gp_ops->delete_user_from_group($id_group,$genid);
	}
	
}
//retourne la liste des adhérents
function liste_adherents()
{
	$db = cmsms()->GetDb();
	//on fait une requete pour completer l'input dropdown du formulaire
	$query = "SELECT genid as client_id, CONCAT_WS(' ',nom, prenom) AS joueur FROM ".cms_db_prefix()."module_adherents_adherents WHERE actif = 1 ORDER BY nom ASC, prenom ASC";
	$dbresult = $db->Execute($query);

		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row= $dbresult->FetchRow())
			{
				$nom[$row['joueur']] = $row['client_id'];
				//$indivs = $row['indivs'];
			}
		return $nom;	
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