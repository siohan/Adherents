<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

if (!$this->CheckPermission('Adherents use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('adherents');
}
if( isset($params['cancel']) )
{
	$this->RedirectToAdminTab('adherents');
	return;
}
$db =& $this->GetDb();
global $themeObject;
$licence = '';
$edition = 0;
$OuiNon = array("Non"=>"0","Oui"=>"1");
$edit = 0;
if(isset($params['genid']) && $params['genid'] != '')
{
	
	$genid = $params['genid'];
	$as_adh = new Asso_adherents;
	$details = $as_adh->details_adherent($genid);
	$edit = 1;
			
}

	

#
#EOF
#
?>