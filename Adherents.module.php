<?php

#-------------------------------------------------------------------------
# Module : Adherents - 
# Version : 0.3.4, Sc
# Auteur : Claude SIOHAN
#-------------------------------------------------------------------------
/**
 *
 * @author Claude SIOHAN
 * @since 0.1
 * @version $Revision: 1 $
 * @modifiedby $LastChangedBy: Claude
 * @lastmodified $Date: 2017-03-26 11:56:16 +0200 (Mon, 28 Juil 2015) $
 * @license GPL
 **/

class Adherents extends CMSModule
{
  
  function GetName() { return 'Adherents'; }   
  function GetFriendlyName() { return $this->Lang('friendlyname'); }   
  function GetVersion() { return '0.3.4.3'; }  
  function GetHelp() { return $this->Lang('help'); }   
  function GetAuthor() { return 'Claude SIOHAN'; } 
  function GetAuthorEmail() { return 'claude.siohan@gmail.com'; }
  function GetChangeLog() { return $this->Lang('changelog'); }
    
  function IsPluginModule() { return true; }
  function HasAdmin() { return true; }   
  function GetAdminSection() { return 'content'; }
  function GetAdminDescription() { return $this->Lang('moddescription'); }
 
  function VisibleToAdminUser()
  {
    	return 
		$this->CheckPermission('Adherents use');
	
  }
  
  
  function GetDependencies()
  {
	return array('FrontEndUsers'=>'3.0.1');
  }

  

  function MinimumCMSVersion()
  {
    return "2.0";
  }

  
  function SetParameters()
  { 
  	$this->RegisterModulePlugin();
	$this->RestrictUnknownParams();
	$this->SetParameterType('display',CLEAN_STRING);
	$this->SetParameterType('action',CLEAN_STRING);
	$this->SetParameterType('record_id', CLEAN_INT);
	$this->SetParameterType('licence', CLEAN_INT);
	$this->SetParameterType('phase', CLEAN_INT);
	$this->SetParameterType('edition', CLEAN_INT);
	//$this->SetParameterType('record_id', CLEAN_INT);
	$this->SetParameterType('type_contact',CLEAN_STRING);
	$this->SetParameterType('contact',CLEAN_STRING);
	$this->SetParameterType('description',CLEAN_STRING);
	$this->SetParameterType('commande_number',CLEAN_STRING);
	$this->SetParameterType('fournisseur',CLEAN_STRING);
	$this->SetParameterType('libelle_selected',CLEAN_STRING);
	$this->SetParameterType('libelle_commande',CLEAN_STRING);
	$this->SetParameterType('ep_manche_taille',CLEAN_STRING);
	$this->SetParameterType('couleur',CLEAN_STRING);
	$this->SetParameterType('produits',CLEAN_STRING);
	$this->SetParameterType('commande_id',CLEAN_INT);
	$this->SetParameterType('quantite',CLEAN_INT);
	$this->SetParameterType('destinataires',CLEAN_INT);//id du groupe 
	$this->SetParameterType('priority',CLEAN_INT);
	$this->SetParameterType('message',CLEAN_STRING);
	$this->SetParameterType('sujet',CLEAN_STRING);
	$this->SetParameterType('produit_id',CLEAN_INT);
	$this->SetParameterType('message_id', CLEAN_INT);
	$this->SetParameterType('id_cotisation', CLEAN_INT);
	$this->SetParameterType('obj', CLEAN_STRING);
	$this->SetParameterType('ref_action', CLEAN_STRING);	
	
	//form parameters
	$this->SetParameterType('submit',CLEAN_STRING);
	//$this->SetParameterType('tourlist',CLEAN_INT);
	

}

function InitializeAdmin()
{
  	return parent::InitializeAdmin();
	$this->SetParameters();
	//$this->CreateParameter('pagelimit', 100000, $this->Lang('help_pagelimit'));
}

public function HasCapability($capability, $params = array())
{
   if( $capability == 'tasks' ) return TRUE;
   return FALSE;
}

public function get_tasks()
{
   $obj = array();
	
	
return $obj; 
}

  function GetEventDescription ( $eventname )
  {
    return $this->Lang('event_info_'.$eventname );
  }
     
  function GetEventHelp ( $eventname )
  {
    return $this->Lang('event_help_'.$eventname );
  }

  function InstallPostMessage() { return $this->Lang('postinstall'); }
  function UninstallPostMessage() { return $this->Lang('postuninstall'); }
  function UninstallPreMessage() { return $this->Lang('really_uninstall'); }
  function random_string($car) {
	$string = "";
	$chaine = "abcdefghijklmnpqrstuvwxyz";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
  }
function random_int($car) {
	$string = "";
	$chaine = "123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
  }

  
  function _SetStatus($oid, $status) {
    //...
  }




} //end class
?>
