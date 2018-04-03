<?php
set_time_limit(300);
header_remove();
if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db =& $this->GetDb();
$record_id = 0;
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = (int) $params['record_id'];
}
global $themeObject;
$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE fftt = '1' LIMIT ?,10 ";
//echo $query;
$dbresult = $db->Execute($query, array($record_id));
if ($dbresult)
{
	$adh_ops = new adherents_spid;
	if($dbresult->recordCount()>0)
	{
		while($row= $dbresult->FetchRow())
		{
			$licence = $row['licence'];
			$details = $adh_ops->infos_adherent_spid($licence);
			
			//ToAdminTab('adherents');
		}
		$record_id = $record_id + 10;
		$this->Redirect($id, 'details_adherents' , $returnid, array("record_id"=>$record_id));
	}
	else
	{
		//c'est la fin du script
		$this->SetMessage('fin du script');
		$this->RedirectToAdminTab('adherents');
	}

}
else
{ 
	echo "erreur de requete !";
}
