<?php
#-------------------------------------------------------------------------
# Module: Newsletter Made Simple (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide a flexible
#  mailing list solution.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
$db = $this->GetDb();

// remove the database tables
$dict = NewDataDictionary( $db );
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_adherents" );
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_adherents_seq" );
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_contacts" );
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_groupes" );
$dict->ExecuteSQLArray($sqlarray);


$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_groupes_belongs" );
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_roles" );
$dict->ExecuteSQLArray($sqlarray);


$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_adherents_roles_belongs" );
$dict->ExecuteSQLArray($sqlarray);

// templates
$this->DeleteTemplate();

try {
    $types = CmsLayoutTemplateType::load_all_by_originator($this->GetName());
    if( is_array($types) && count($types) ) {
        foreach( $types as $type ) {
            $templates = $type->get_template_list();
            if( is_array($templates) && count($templates) ) {
                foreach( $templates as $template ) {
                    $template->delete();
                }
            }
            $type->delete();
        }
    }
}
catch( Exception $e ) {
    // log it
    audit('',$this->GetName(),'Uninstall Error: '.$e->GetMessage());
} 

// remove the permissions
$this->RemovePermission('Adherents use');
$this->RemovePermission('Adherents prefs');


// remove the preference
$this->RemovePreference();


// Events
/*
$this->RemoveEvent( 'OnUserAdded' );
$this->RemoveEvent( 'OnUserDeleted' );
*/


// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));
?>