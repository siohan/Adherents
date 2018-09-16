<?php
#-------------------------------------------------------------------------
# Module: Adhérents
# Version: 0.4.6
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
		$dbresult = $db->execute($insert_sql, array('adherents', 'Les adhérents actifs du club', '1'));
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
	

}
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>