<?php

#-------------------------------------------------------------------------
# Module : Adherents - 
# Version : 0.1, Sc
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
  function GetVersion() { return '0.1'; }  
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
	return array('Commandes'=>'0.2.2');
  }

  

  function MinimumCMSVersion()
  {
    return "2.0";
  }

  
  function SetParameters()
  { 
  	$this->RegisterModulePlugin();
	$this->RestrictUnknownParams();
	
	//form parameters
	//$this->SetParameterType('submit',CLEAN_STRING);
	//$this->SetParameterType('tourlist',CLEAN_INT);
	

}

function InitializeAdmin()
{
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
	//$obj[0] = new PingRecupFfttTask();
   	//$obj[1] = new PingRecupSpidTask();  
	//$obj[2] = new PingRecupRencontresTask();
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
	$chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
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
