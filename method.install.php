<?php
#-------------------------------------------------------------------------
# Module: Adherents
# Version: 0.5, AssoSimple
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
	genid I(11),
	maj D,
	actif I(1) DEFAULT 1,
	licence C(11),
	nom C(255),
	prenom C(255),
	anniversaire D,
	sexe C(1),
	certif C(255),
	validation D,
	echelon C(1),
	cat C(20),
	adresse C(255),
	code_postal C(5),
	ville C(200),
	pays C(255),
	role C(255),
	externe I(1) DEFAULT 0,
	image C(4),
	feu_id I(11),
	checked I(1) DEFAULT 1";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_adherents", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	genid I(11),
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
	actif I(1),
	public I(1) DEFAULT 0,
	auto_subscription I(1) DEFAULT 0,
	admin_valid I(1) DEFAULT 1,
	tag C(255),
	tag_subscription C(255), 
	pageid_aftervalid C(255),
	feu_gid I(11)";
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
	genid I(11)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_groupes_belongs", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
/*
// table schema description pour la table roles
$flds = "
	id I(11) AUTO KEY,
	id_group I(11),
	genid I(11)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_roles", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// table schema description pour la table roles
$flds = "
	id I(11) AUTO KEY,
	id_group I(11),
	genid I(11)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_adherents_roles_belongs", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );
*/
//on ajoute les propriétés par défaut des groupes du module FEU
$feu = \cms_utils::get_module('FrontEndUsers');

$name = "email";
$prompt = "Ton email";
$type = 2;//0 = text; 1 = checkbox; 2 = email;3 = textarea; 4,5 = count(options)?;6 = image;7= radiobuttons; 8= date
$length = 80;
$maxlength = 255;		
$add_prop1 = $feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = false, $encrypt = 0 );

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

		
//			
//
//les index
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'adherents',
	    cms_db_prefix().'module_adherents_adherents', 'genid',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);

# Mails templates
$fn = cms_join_path(dirname(__FILE__),'templates','orig_activationemailtemplate.tpl');
if( file_exists( $fn ) )
{
	$template = file_get_contents( $fn );
	$this->SetTemplate('newactivationemail_Sample',$template);
}


$this->SetPreference('admin_email', 'root@localhost.com');
$this->SetPreference('email_activation_subject', 'Ton compte est actif');
$this->SetPreference('feu_commandes',0);
$this->SetPreference('feu_fftt',0);
$this->SetPreference('feu_messages',0);
$this->SetPreference('feu_inscriptions',0);
$this->SetPreference('feu_contacts',1);
$this->SetPreference('feu_presences',0);
$this->SetPreference('feu_factures', 0);
$this->SetPreference('feu_compos', 0);
$this->SetPreference('feu_adhesions', 0);
$this->SetPreference('pageid_subscription', '');
//Préférences pour les photos
$this->SetPreference('max_size', 100000);
$this->SetPreference('max_width', 800);
$this->SetPreference('max_height', 800);
$this->SetPreference('allowed_extensions', 'jpg, gif, png, jpeg');
//Permissions
$this->CreatePermission('Adherents use', 'Utiliser le module Adhérents');
$this->CreatePermission('Adherents delete', 'Autoriser à supprimer');
$this->CreatePermission('Adherents prefs', 'Modifier les données du compte');

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
//fin de la liste des adhérents
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>
