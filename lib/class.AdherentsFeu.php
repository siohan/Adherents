<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class AdherentsFeu
{
  function __construct() {}

	function last_logged($record_id)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "SELECT refdate FROM ".cms_db_prefix()."module_feusers_history WHERE userid = ? AND action = 'login' ORDER BY refdate DESC LIMIT 1";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			if($dbresult->recordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$lastused = $row['refdate'];
				return $lastused;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
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