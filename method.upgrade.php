<?php
#-------------------------------------------------------------------------
# Module: Adhérents
# Version: 0.5
# Method: Upgrade
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------

/**
 * For separated methods, you'll always want to start with the following
 * line which check to make sure that method was called from the module
 * API, and that everything's safe to continue:
*/ 
if (!isset($gCms)) exit;

$db = $this->GetDb();			/* @var $db ADOConnection */
$dict = NewDataDictionary($db); 	/* @var $dict ADODB_DataDict */
/**
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Upgrade() method in the module body.
 */
$now = trim($db->DBTimeStamp(time()), "'");
$current_version = $oldversion;
switch($current_version)
{
  // we are now 1.0 and want to upgrade to latest
 
	
	case "0.1" : 	
	
	{
		
		$dict = NewDataDictionary( $db );

		// table schema description
		$flds = "
			id I(11) AUTO KEY,
			nom C(100),
			description C(255),
			actif I(1)";
			$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_groupes", $flds, $taboptarray);
			$dict->ExecuteSQLArray($sqlarray);
		
		$dict = NewDataDictionary( $db );

		// table schema description
		$flds = "
			id I(11) AUTO KEY,
			id_group I(11),
			licence I(11)";
			$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_groupes_belongs", $flds, $taboptarray);
			$dict->ExecuteSQLArray($sqlarray);
		//on créé un index pour cette table
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'groupes_belongs',
			    cms_db_prefix().'module_adherents_groupes_belongs', 'id_group, licence',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
	}
		


	case "0.1.1" :
	{
		# Mails templates
		$fn = cms_join_path(dirname(__FILE__),'templates','orig_activationemailtemplate.tpl');
		if( file_exists( $fn ) )
		{
			$template = file_get_contents( $fn );
			$this->SetTemplate('newactivationemail_Sample',$template);
		}
		$dict = NewDataDictionary( $db );
		$flds = "fftt I(1) DEFAULT 1 NOT NULL";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
		$dict->ExecuteSQLArray($sqlarray);

	}
	
	case "0.2":
	case "0.2.1":
	case "0.2.2" :
	case "0.2.3" :
	case "0.2.4" :
	case "0.2.4.1" :
	{
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'adherents',
			    cms_db_prefix().'module_adherents_adherents', 'licence',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
	}
	case "0.2.5" :
	{
		//on rajoute une colonne maj pour savoir qd le joueur a été mis à jour
		$dict = NewDataDictionary( $db );
		$flds = "maj ". CMS_ADODB_DT ."";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on ajoute une préférence pour la vérification des adhérents
		$this->SetPreference('LastVerifAdherents', time());
	}
	case "0.2.6" :
	case "0.2.7" :
	case "0.2.8" : 
	{
		//on installe un groupe par défaut
		$insert_sql = "INSERT INTO ".cms_db_prefix()."module_adherents_groupes (`nom`, `description`, `actif`) VALUES (?, ?, ?)";
		$dbresult = $db->Execute($insert_sql, array('adherents', 'Les adhérents actifs du club', '1'));
		if($dbresult)
		{
			$id_group = $db->Insert_ID();
			$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE actif = 1";
			$dbresult1 = $db->Execute($query);
			if($dbresult1 && $dbresult1->RecordCount()>0)
			{
				$gp_ops = new groups;
				while($row = $dbresult1->FetchRow())
				{
					$gp_ops->assign_user_to_group($id_group, $row['licence']);
				}
			}
		}
	}
	case "0.2.9" :
	
	{
			//on rajoute une colonne maj pour savoir qd le joueur a été mis à jour
			$dict = NewDataDictionary( $db );
			$flds = "public I(1)";
			$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_groupes", $flds);
			$dict->ExecuteSQLArray($sqlarray);
			
			$dict = NewDataDictionary( $db );
			$flds = "externe I(1) DEFAULT 0";
			$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
			$dict->ExecuteSQLArray($sqlarray);
			
			
	}
	case "0.2.10" :
	{
	
		//on créé un nouveau champ genid I(11) pour la table adhérents
		$dict = NewDataDictionary( $db );
		$flds = "genid I(11), pays C(255)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on supprime certains champs inutiles de la table adherents
		
		//on supprime le champ FFTT ?
		$dict = NewDataDictionary( $db );
		$flds = "fftt";
		$sqlarray = $dict->DropColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on incrémente le genid dans la table adherents
		$query = "SELECT id FROM ".cms_db_prefix()."module_adherents_adherents";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$genid = $this->random_int(9);
				$query2 = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET genid = ? WHERE id = ?";
				$dbresult2 = $db->Execute($query2, array($genid, $row['id']));
			}
		}
		
		//on créé un index unique pour la table adherents
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'genid',
			    cms_db_prefix().'module_adherents_adherents', 'genid',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
		//maintenant on remplace licence par genid dans toutes les autres tables
		
		//on créé un nouveau champ genid I(11) pour la table contacts
		$dict = NewDataDictionary( $db );
		$flds = "genid I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_contacts", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on remplace les licences par le genid
		$query = "SELECT adh.genid, cont.licence FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_contacts AS cont WHERE adh.licence = cont.licence";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			while($row = $dbresult->FetchRow())
			{
				$genid = $row['genid'];
				$query2 = "UPDATE ".cms_db_prefix()."module_adherents_contacts SET genid = ? WHERE licence = ?";
				$dbresult2 = $db->Execute($query2, array($genid, $row['licence']));
			
			}
		}
		//on supprime l'index sur la licence
		
		
		$sqlarray = $dict->DropIndexSQL(cms_db_prefix().'licence',
			    cms_db_prefix().'module_adherents_adherents');
		$dict->ExecuteSQLArray($sqlarray);
		
		//on change aussi le type du champ on passe de int(11) à varchar 11
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_adherents_adherents",
						     "licence C(11)");
		$dict->ExecuteSQLArray($sqlarray);
		
		//on supprime le champ licence ?
		$dict = NewDataDictionary( $db );
		$flds = "licence";
		$sqlarray = $dict->DropColumnSQL( cms_db_prefix()."module_adherents_contacts", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		
		//on créé un nouveau champ genid I(11) pour la table groupes_belongs
		$dict = NewDataDictionary( $db );
		$flds = "genid I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_groupes_belongs", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on remplace les licences par le genid
		$query = "SELECT adh.genid, be.licence FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_adherents_groupes_belongs AS be WHERE adh.licence = be.licence";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			while($row = $dbresult->FetchRow())
			{
				$genid = $row['genid'];
				$query2 = "UPDATE ".cms_db_prefix()."module_adherents_groupes_belongs SET genid = ? WHERE licence = ?";
				$dbresult2 = $db->Execute($query2, array($genid, $row['licence']));
			
			}
		}
		
		//on supprime le champ licence ?
		$dict = NewDataDictionary( $db );
		$flds = "licence";
		$sqlarray = $dict->DropColumnSQL( cms_db_prefix()."module_adherents_groupes_belongs", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on supprime la table adherents_seq
		//on supprime la table ping_comm devenue obsolete
		$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_adherents_seq",
						   $flds);
						
		//on créé une nouvelle propriété genid pour le groupe adhérents dans FEU
		
		$feu = cms_utils::get_module('FrontEndUsers');
		
		$gid = $feu->GetGroupId('adherents');
		//On fait la même chose pour la troisième propriété 
		$name = "genid";
		$prompt = "Ton ID";
		$type = 0;
		$length = 10;
		$maxlength = 15;		
		$feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = 0, $encrypt = 0 );
		
		$sortkey = 1;
		$required = 0; //2= requis, 1 optionnel, 0 = off
		// on peut assigner les propriétés au groupe adhérents 
		$feu->AddGroupPropertyRelation($gid,$name,$sortkey, -1, $required);
		
		//idéalement on complete la table 
		$query = "SELECT adh.licence, adh.genid, adh.nom, adh.prenom FROM ".cms_db_prefix()."module_adherents_adherents AS adh";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			while($row = $dbresult->fetchRow())
			{
				$licence = $row['licence'];
				$genid = $row['genid'];
				$prenom = $row['prenom'];
				$nom = str_replace("&#39;", "", $row['nom']);
				
				$user = $prenom.''.$nom;				
				$nom_complet = strtolower(str_replace (" ", "", $user));
				//on récupère le id ou uid de chaque utilisateur
				$uid = $feu->GetUserID($licence);
				//on change le username d'abord
				$query2 = "UPDATE ".cms_db_prefix()."module_feusers_users SET username = ? WHERE username = ?";
				$dbresult2 = $db->Execute($query2, array($nom_complet, $licence));
				
				//puis on ajoute le genid comme nouvelle propriété
				$feu->SetUserPropertyFull('genid',$genid, $uid);
							
			}
		}
		
		$this->SetPreference('feu_commandes',0);
		$this->SetPreference('feu_fftt',0);
		$this->SetPreference('feu_messages',1);
		$this->SetPreference('feu_inscriptions',1);
		$this->SetPreference('feu_contacts',1);
		$this->SetPreference('feu_presences',1);
		$this->SetPreference('feu_factures', 1);
	}
	case "0.3":
	case "0.3.1":
	{
		$this->RemovePreference('LastVerifAdherents');
	}
	case "0.3.2":
	case "0.3.3":
	{
		$this->SetPreference('feu_compos', 1);
	}
	
	case "0.3.3.1" :
	{
		//ajout de nouveaux champs
		//role
		$dict = NewDataDictionary( $db );
		$flds = "role C(255), description C(255)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
	
	}
	case "0.3.4":
	{
		$this->SetPreference('feu_adhesions', 0);
	}
	case "0.3.4.1" :
	case "0.3.4.2" :
	case "0.3.4.3" :
	case "0.3.4.4" :
	case "0.3.4.5" :
	case "0.3.4.6" :
	{
		$uid = null;
		if( cmsms()->test_state(CmsApp::STATE_INSTALL) ) {
		  $uid = 1; // hardcode to first user
		} else {
		  $uid = get_userid();
		}
		//Design pour la liste des adhérents
		try {
		    $adh_type = new CmsLayoutTemplateType();
		    $adh_type->set_originator($this->GetName());
		    $adh_type->set_name('liste_adherents');
		    $adh_type->set_dflt_flag(TRUE);
		    $adh_type->set_description('Template pour liste des membres');
		    $adh_type->set_lang_callback('Adherents::page_type_lang_callback');
		    $adh_type->set_content_callback('Adherents::reset_page_type_defaults');
		    $adh_type->reset_content_to_factory();
		    $adh_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_liste_adherents.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Adherents Liste'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($adh_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
	}
	case "0.3.5" :
	{
		
		//on crée le nouveau champ tag ds la table groupes
		$dict = NewDataDictionary( $db );
		$flds = "auto_subscription I(1) DEFAULT 0, admin_valid I(1) DEFAULT 1, tag C(255), tag_subscription C(255), pageid_aftervalid C(255)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_groupes", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on modifie un  champ dans la table adhérents 
		$dict = NewDataDictionary( $db );
		
		$sqlarray = $dict->AlterColumnSQL( cms_db_prefix()."module_adherents_adherents", "certif D");
		$dict->ExecuteSQLArray($sqlarray);
		
		//on créé un nouveau champ dans la table adhérents =>external
		$dict = NewDataDictionary( $db );
		$flds = "image C(4)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		
		//fin de la liste des adhérents
		
		$this->SetPreference('max_size', 100000);
		$this->SetPreference('max_width', 800);
		$this->SetPreference('max_height', 800);
		$this->SetPreference('allowed_extensions', 'jpg, gif, png, jpeg');
		$this->SetPreference('pageid_subscription', '');
	}
	
	case "0.4" :
	case "0.4.0.1" :
	{
		
		$gp_ops = new groups;
		$adh_ops = new AdherentsFeu;
		$asso_ops = new Asso_adherents;
		
		//on crée un nouveau champ ds la table adherents_groupes
		//: feu_gid QUI VA STOCKER LE NUMÉRO DU GROUPE DE FEU
		$feu = \cms_utils::get_module('FrontEndUsers');
		$dict = NewDataDictionary( $db );
		$flds = "feu_gid I(11) ";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_groupes", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		$query = "SELECT id, nom, description FROM ".cms_db_prefix()."module_adherents_groupes";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			
			while($row = $dbresult->FetchRow())
			{
				$group_exists = $feu->GetGroupId($row['nom']);//int

				if(FALSE === $group_exists || true == is_null($group_exists)) //le groupe n'existe pas ds FEU
				{
					$create_gp = $feu->AddGroup($row['nom'], $row['description']);//returne true et le int ou false et mess erreur
					var_dump($create_gp);
					if(true == $create_gp[0])
					{
						$maj = $adh_ops->feu_gid($row['id'],$create_gp[1]);
						//il faut aussi ajouter les propriétés par défaut à ce groupe
						$adh_ops->AddPropertyRelations($create_gp[1]);
					}
				}
				else
				{
					//on met le groupid de FEU ds la base adherents
					$adh_ops->feu_gid($row['id'],$group_exists);
				}
			}
		}
		
		//on crée un nouveau champ  qui va stocker l'uid de FEU ds Adherents_adherents
		
		$dict = NewDataDictionary( $db );
		$flds = "feu_id I(11),checked I(1) DEFAULT 1 ";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_adherents_adherents", $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		//deuxième requete, on "verse" les utilisateurs vers FEU
		$query = "SELECT genid, nom, prenom FROM ".cms_db_prefix()."module_adherents_adherents";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				//on prend le genid pour savoir si l'utilisateur est déjà inscrit ds feu
				//ou le nom complet
				
				$nom = $row['nom'];
				$nom = mb_convert_encoding($nom, "UTF-8", "Windows-1252");
				$nom = stripslashes($nom);
				$nom = str_replace("&#39;", "", $nom);
				$nom = str_replace(" ", "",$nom);
	
				$prenom = $row['prenom'];
				$prenom = str_replace("&#39", "",$prenom);
				$prenom = $asso_ops->clean_name($prenom);
				$nom_complet = strtolower($prenom. ''.$nom);
				
				$user = $feu->GetUserID($nom_complet);
				if(!is_int($user)) //l'utilisateur n'est pas ds FEU
				{
					
					$day = date('j');
					$month = date('n');
					$year = date('Y')+5;
					$expires = mktime(0,0,0,$month, $day,$year);
					
					$mot1 = $this->random_string(7);
					$motdepasse = 'A'.$mot1.'1';
					
					$add_user = $feu->AddUser($nom_complet, $motdepasse,$expires);
					$uid = $add_user[1];
					$adh_ops->feu_id($row['genid'], $uid);
				}
				else
				{
					//l'utilisateur est dans FEU on ajoute son feu_id
					$adh_ops->feu_id($row['genid'], $user);
				}
			}
		}
		//troisème chose : il faut ajouter les appartenances de chaque utilisateur	
		
		$query = "SELECT genid, nom, prenom FROM ".cms_db_prefix()."module_adherents_adherents WHERE actif = 1";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$user_groups = $gp_ops->member_of_groups($row['genid']);//false ou array avec int
	
				if(false !== $user_groups)
				{
					$feu_user = $adh_ops->GetUserInfoByProperty($row['genid']);
					
					if(false != $feu_user)
					{
					
						//on boucle sur la variable $user_groups
						foreach( $user_groups AS $value)
						{
							//il faut chercher le nom des groupes ds le module adherents
							$details = $gp_ops->details_groupe($value);
							$nom_gp = $details['nom'];
							$assign = $feu->AssignUserToGroup( $feu_user, $value );
						}
					}
				}
			}
		}	
	}
	
	

}
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>
