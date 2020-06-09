<?php
if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
####################################################################
##                                                                ##
####################################################################
//debug_display($params, 'Parameters');
$type_compet = '';
$idepreuve = '';
$designation = '';
$record_id = '';
$rowarray = array();

	
	if(!isset($params['record_id']) || $params['record_id'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('groups');
	}
	else
	{
		$record_id = $params['record_id'];
	}

	
$db = $this->GetDb();
$query = "SELECT j.genid, CONCAT_WS(' ',j.nom, j.prenom ) AS joueur FROM ".cms_db_prefix()."module_adherents_adherents AS j WHERE actif = 1 ORDER BY nom ASC ";
//echo $query;
$dbresult = $db->Execute($query);

	if(!$dbresult)
	{
		$designation.= $db->ErrorMsg();
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('groups');
	}

	$smarty->assign('formstart',
			$this->CreateFormStart( $id, 'do_assign_users', $returnid ) );
	$smarty->assign('record_id',
			$this->CreateInputHidden($id,'record_id',$record_id,10,15));	
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$gp_ops = new groups;
		while($row = $dbresult->FetchRow())
		{
			//var_dump($row);
			$onerow = new StdClass();
			$onerow->joueur = $row['joueur'];
			$onerow->id_group = $record_id;
			$onerow->genid = $row['genid'];
			$participe = $gp_ops->is_member($row['genid'], $record_id);
			if(true === $participe)
			{
				$onerow->participe = 1;
			}
			else
			{
				$onerow->participe = 0;
			}
			
			$rowarray[]= $onerow;			
			
		}
			
			
	}
	$smarty->assign('items',$rowarray);
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));
	$smarty->assign('back',
			$this->CreateInputSubmit($id,'back',
						$this->Lang('back')));

	$smarty->assign('formend',
			$this->CreateFormEnd());
echo $this->ProcessTemplate('assign_users.tpl');
#
#EOF
#
?>