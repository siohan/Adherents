<?php

$db = cmsms()->GetDb();
$query = "SELECT genid, contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE type_contact = 1 ";
$dbresult = $db->Execute($query);
echo '<ul>';
if($dbresult && $dbresult->RecordCount() >0)
{
	$adh = new Asso_adherents;
	while($row = $dbresult->FetchRow())
	{
		$contact = $row['contact'];
		$genid = $adh->get_name($row['genid']);
		$is_real_email = is_email($contact);
		//var_dump($is_real_email);
		if(false == $is_real_email)
		{
			$reponse = 'email HS';
		}
		else
		{
			$reponse = $contact;
		}
		echo '<li>'.$genid.' : '.$reponse.'</li>';
	}
}
echo '</ul>';
?>