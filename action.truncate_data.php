<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Adherents use'))
{
		echo $this->ShowErrors($this->Lang('needpermission'));
	return;

}


$db = cmsms()->GetDb();

$query="TRUNCATE ".cms_db_prefix()."module_news";

$dbresult = $db->Execute($query);
if($dbresult)
{
	echo 'Ok';
}
else
{
	echo 'Ko !';
}	

?>