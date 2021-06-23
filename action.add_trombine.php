<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Adherents use'))
{

	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'parameters');
$db =& $this->GetDb();
global $themeObject;

$edit = 0;
if(isset($params['genid']) && $params['genid'] != '')
{
	$genid = $params['genid'];
}
else
{
	//on renvoie à une erreur
	$genid = '292271';
}



	// On affiche un formulaire vierge
	
	$smarty->assign('genid',$genid);
	

echo $this->ProcessTemplate('uploadfile2.tpl');
?>