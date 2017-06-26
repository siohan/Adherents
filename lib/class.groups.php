<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class groups
{
  function __construct() {}


##
##





function add_group ()
{
	global $gCms;
	$adherents = cms_utils::get_module('Adherents'); 
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	$club_number = $adherents->GetPreference('club_number');
	
	
		$page = "xml_liste_joueur_o";
		$service = new Servicen();
		//var_dump($service);
		//paramètres nécessaires 
		$var="club=".$club_number;
		$lien = $service->GetLink($page,$var);
		//var_dump( $lien );
		//var_dump($lien);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			$array = 0;
			$lignes = 0;
			return FALSE;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['joueur']);
		}
		//echo "le nb de lignes est : ".$lignes;
		if($lignes == 0)
		{
			$message = "Pas de lignes à récupérer !";
			//$this->SetMessage("$message");
			//$this->RedirectToAdminTab('joueurs');
		}
		else
		{
			
			

				$i =0;//compteur pour les nouvelles inclusions
				$a = 0;//compteur pour les mises à jour
				foreach($xml as $tab)
				{
					//$licence = (isset($tab->licence)?"$tab->licence":"");
					$i++;
					$licence = (isset($tab->licence)?"$tab->licence":"");
					$nom = (isset( $tab->nom)?"$tab->nom":"");
					$prenom = (isset($tab->prenom)?"$tab->prenom": "");
					$nclub = (isset($tab->nclub)?"$tab->nclub":"");
					$clast = (isset($tab->clast)?"$tab->clast":"");
					


					//$designation = 'récupération des joueurs';

					$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE licence = ?";
					$dbresult = $db->Execute($query, array($licence));

					if($dbresult  && $dbresult->RecordCount() == 0) 
					{
						$this->ajouter_adherent_spid($licence, $nom, $prenom);
							if($i %2)
							{
								sleep(1);
							}//$this->
					}
					/*
					else
					{
						$this->maj_adherent_spid($licence,$nom, $prenom);
						if($i %2)
						{
							sleep(1);
						}
					}		
					*/

				}// fin du foreach

		
	}
}//fin de la fonction

function delete_group ($record_id)
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


#
#
#
}//end of class
#
# EOF
#
?>