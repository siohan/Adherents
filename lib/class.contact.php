<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class contact
{
  function __construct() {}

	function delete_contact($record_id)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_adherents_contacts WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));

	}
	
	function add_contact ($licence, $type_contact,$contact,$description)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_adherents_contacts (licence, type_contact,contact, description) VALUES (?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($licence, $type_contact,$contact,$description));
	}
	
	function update_contact ($type_contact,$contact,$description,$record_id)
	{
		
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_adherents_contacts SET type_contact = ?, contact =?, description = ? WHERE id = ?";
		$dbresult = $db->Execute($query, array($type_contact,$contact,$description,$record_id));
	}
	function has_email($licence)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE licence = ? AND type_contact = 1";
		$dbresult = $db->Execute($query, array($licence));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
##
##
#
#
#
}//end of class
#
# EOF
#
?>