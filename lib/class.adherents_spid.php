<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class adherents_spid
{
  function __construct() {}


##
##





function liste_adherents_spid ()
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
			return FALSE;
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
							}
					}
				

				}// fin du foreach
			return TRUE;
		
	}
}//fin de la fonction

function ajouter_adherent_spid ($licence,$nom, $prenom)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_adherents_adherents (licence, nom, prenom ) VALUES (?, ?, ?)";
	$dbresultat = $db->Execute($query,array($licence,$nom, $prenom));
	
	if($dbresultat)
	{
		$this->infos_adherent_spid($licence);
	}
	
	
}
function maj_adherent_spid ($licence,$nom, $prenom)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET nom = ?, prenom = ? WHERE licence = ?";
	$dbresult = $db->Execute($query, array($nom,$prenom, $licence));
	
	if($dbresult)
	{
		$this->infos_adherent_spid($licence);
	}
}

function infos_adherent_spid ($licence)
{
	global $gCms;
	//$ping = cms_utils::get_module('Ping'); 
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	//$club_number = $ping->GetPreference('club_number');
	
	
		$page = "xml_licence";
		$service = new Servicen();
		//var_dump($service);
		//paramètres nécessaires 
		$var="licence=".$licence;
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
			$lignes = count($array['licence']);
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
			//on supprime l'existant ? Oui.
			

				$i =0;//compteur pour les nouvelles inclusions
				$a = 0;//compteur pour les mises à jour
				foreach($xml as $tab)
				{
					//$idlicence = (isset($tab->licence)?"$tab->licence":"");
					$licence = (isset($tab->licence)?"$tab->licence":"");
					$nom = (isset( $tab->nom)?"$tab->nom":"");
					$prenom = (isset($tab->prenom)?"$tab->prenom": "");
					$sexe = (isset($tab->sexe)?"$tab->sexe":"");
					$type = (isset($tab->type)?"$tab->type":"");
					$certif = (isset($tab->certif)?"$tab->certif":"");
					
					$validation1 = (isset($tab->validation)?"$tab->validation":"");
					//on modifie la date pour la rendre compatible avec MySQL
					$validation2 = array();
					$validation2 = explode('/', $validation1);
					$validation = $validation2[2].'-'.$validation2[1].'-'.$validation2[0];
					$echelon = (isset($tab->echelon)?"$tab->echelon":"");
					$place = (isset($tab->place)?"$tab->place":"");
					$point = (isset($tab->point)?"$tab->point":"");
					$cat = (isset($tab->cat)?"$tab->cat":"");
					
					if($certif=='')
					{
						$actif = 0;
						$validation = '';
					}
					else
					{
						$actif = 1;
					}


					//$designation = 'récupération des joueurs';

					
					{
						$this->maj_adherent_spid2($licence, $sexe, $type,$certif,$actif,$validation, $echelon, $place, $point, $cat);
						
					}		


				}// fin du foreach

		
	}
}//fin de la fonction

function maj_adherent_spid2 ($licence, $sexe, $type,$certif,$actif,$validation, $echelon, $place, $point, $cat)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET sexe = ?, type = ?, certif = ?,actif = ?, validation = ?, echelon = ?, place = ?, points = ?, cat = ? WHERE licence = ?";
	$dbresult = $db->Execute($query, array($sexe, $type, $certif,$actif,$validation, $echelon, $place, $point, $cat, $licence));
}

function edit_adherent($edit,$fftt,$licence,$nom,$prenom,$adresse, $code_postal, $ville)
{
	global $gCms;
	$db = cmsms()->GetDb();
	if($edit == '1')
	{
		$query = "INSERT INTO ".cms_db_prefix()."module_adherents_adherents (fftt,licence, nom, prenom, adresse, code_postal, ville) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($fftt,$licence,$nom, $prenom,$adresse, $code_postal, $ville));
	}
	else
	{
		$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET adresse = ?, code_postal = ?, ville = ? WHERE licence = ?";
		$dbresult = $db->Execute($query, array($adresse, $code_postal, $ville, $licence));
	}
	
}
function random_serie($car) {
$string = "";
$chaine = "ABCDEFGHIJKLMOPQRSTUVWXYZ0123456789";
srand((double)microtime()*1000000);
for($i=0; $i<$car; $i++) {
$string .= $chaine[rand()%strlen($chaine)];
}
return $string;
}
function maj_seq()
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents_seq SET id = LAST_INSERT_ID(id+1)";
	$dbresult = $db->Execute($query);
}
function refresh()
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE actif = 1 AND fftt = 1 AND certif IS NULL";
	$dbresult = $db->Execute($query);
	
	if($dbresult && $dbresult->RecordCount() >0)
	{
		while($row = $dbresult->FetchRow())
		{
			$licence = $row['licence'];
			$maj_joueurs = $this->infos_adherent_spid($licence);
		}
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