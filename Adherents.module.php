<?php

#-------------------------------------------------------------------------
# Module : Adherents - 
# Version : 0.5, Sc
# Auteur : AssoSimple
#-------------------------------------------------------------------------
/**
 *
 * @author AssoSimple
 * @since 0.1
 * @version $Revision: 1 $
 * @modifiedby $LastChangedBy: Claude
 * @license GPL
 **/

class Adherents extends CMSModule
{
  
  function GetName() { return 'Adherents'; }   
  function GetFriendlyName() { return $this->Lang('friendlyname'); }   
  function GetVersion() { return '0.5'; }  
  function GetHelp() { return $this->Lang('help'); }   
  function GetAuthor() { return 'AssoSimple'; } 
  function GetAuthorEmail() { return 'contact@asso-simple.fr'; }
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
	return array('FrontEndUsers'=>'3.2.2');
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
	$this->SetParameterType('genid', CLEAN_INT);
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
	$this->SetParameterType('recip_id', CLEAN_INT);
	$this->SetParameterType('id_cotisation', CLEAN_INT);
	$this->SetParameterType('id_inscription', CLEAN_INT);
	$this->SetParameterType('id_group', CLEAN_INT);
	$this->SetParameterType('obj', CLEAN_STRING);
	$this->SetParameterType('ref_action', CLEAN_STRING);
	$this->SetParameterType('ref_equipe', CLEAN_INT);
	$this->SetParameterType('statut', CLEAN_INT);
	$this->SetParameterType('reponse', CLEAN_INT);
	$this->SetParameterType('affichage', CLEAN_INT);
	$this->SetParameterType('letter', CLEAN_STRING);
	//$this->SetParameterType('valid', CLEAN_INT);
	
	
	//form parameters
	$this->SetParameterType('submit',CLEAN_STRING);
	//$this->SetParameterType('tourlist',CLEAN_INT);
	

}

function InitializeAdmin()
{
  	return parent::InitializeAdmin();
	$this->SetParameters();
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

  final public static function page_type_lang_callback($str)
    {
        $mod = cms_utils::get_module(__CLASS__);
        if( is_object($mod) ) return $mod->Lang('type_'.$str);
    }

    public static function reset_page_type_defaults(CmsLayoutTemplateType $type)
    {
        if( $type->get_originator() != __CLASS__ ) throw new CmsLogicException('Cannot reset contents for this template type');

        $fn = null;
        switch( $type->get_name() ) {
        case 'liste_adherents':
            $fn = 'orig_liste_adherents.tpl';
            break;
        

        }

        $fn = cms_join_path(dirname(__FILE__),'templates',$fn);
        if( file_exists($fn) ) return @file_get_contents($fn);
    }



} //end class
?>
