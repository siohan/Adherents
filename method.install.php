<?php
#-------------------------------------------------------------------------
# Module: Adherents
# Version: 0.2.6, Claude SIOHAN
# Method: Install
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


/** 
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Install() method in the module body.
 */

$db = $gCms->GetDb();

// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	maj D,
	actif I(1) DEFAULT 1,
	fftt I(1) DEFAULT 1,
	licence I(11),
	nom C(255),
	prenom C(255),
	anniversaire D,
	sexe C(1),
	type C(1),
	certif C(255),
	validation D,
	echelon C(1),
	place I(4),
	points I(4),
	cat C(20),
	adresse C(255),
	code_postal C(5),
	ville C(200),
	maj D";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_adherents", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	licence I(11),
	type_contact I(2),
	contact C(255),
	description C(255)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_contacts", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	nom C(100),
	description C(255),
	actif I(1)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_groupes", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	id_group I(11),
	licence I(11)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_groupes_belongs", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_adherents_seq", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//			
//
//les index
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'adherents',
	    cms_db_prefix().'module_adherents_adherents', 'licence',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);

# Mails templates
$fn = cms_join_path(dirname(__FILE__),'templates','orig_activationemailtemplate.tpl');
if( file_exists( $fn ) )
{
	$template = file_get_contents( $fn );
	$this->SetTemplate('newactivationemail_Sample',$template);
}

$this->SetPreference('admin_email', 'root@localhost.com');
$this->SetPreference('email_activation_subject', 'Votre compte T2T est actif');
$this->SetPreference('LastVerifAdherents', 'Votre compte T2T est actif', time());
//$this->SetPreference('mail_activation_body', );
//Permissions
$this->CreatePermission('Adherents use', 'Utiliser le module Adhérents');
$this->CreatePermission('Adherents prefs', 'Modifier les données du compte');


// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>