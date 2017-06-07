<?php
#-------------------------------------------------------------------------
# Module: Adherents
# Version: 0.1, Claude SIOHAN Agi webconseil
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
	actif I(1) DEFAULT 1,
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
	ville C(200)";
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
//
//les index
/*
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'compos',
	    cms_db_prefix().'module_livescoring_compositions', 'renc_id, id_joueur',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);
*/
# Mails templates
$fn = cms_join_path(dirname(__FILE__),'templates','orig_activationemailtemplate.tpl');
if( file_exists( $fn ) )
{
	$template = file_get_contents( $fn );
	$this->SetTemplate('newactivationemail_Sample',$template);
}

$this->SetPreference('admin_email', 'root@localhost.com');
$this->SetPreference('email_activation_subject', 'Votre compte T2T est activé');
//$this->SetPreference('mail_activation_body', );
//Permissions
$this->CreatePermission('Adherents use', 'Utiliser le module Adhérents');


// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>