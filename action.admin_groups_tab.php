<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}


$smarty->assign('add_edit_group',
		$this->CreateLink($id, 'add_edit_group', $returnid,$contents='Ajouter un groupe'));
$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_adherents_groupes";


		$dbresult= $db->Execute($query);
	
	//echo $query;
	$rowarray= array();
	$rowclass = '';
	$group_ops = new groups();
	$contact_ops = new contact();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;

				//les champs disponibles : 
				$actif = $row['actif'];
				//$licence = $row['licence'];
				$onerow->id= $row['id'];
				$nb = $group_ops->count_users_in_group($row['id']);
				$onerow->nom = $row['nom'];
				
				//$onerow->nom = $row['nom'];
				$onerow->description = $row['description'];
				$onerow->nb_users = $this->CreateLink($id, 'view_group_users',$returnid,'Voir les '.$nb.' utilisateurs', array("group"=>$row['id']));
				if($actif == 1)
				{
					$onerow->actif = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('delete'), '', '', 'systemicon');
				}
				else
				{
					$onerow->actif = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('delete'), '', '', 'systemicon');
				}
				
				// = $row['actif'];			
				
				//$onerow->view= $this->createLink($id, 'view_item', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view_results'), '', '', 'systemicon'),array('active_tab'=>'CC',"record_id"=>$row['client_id'])) ;
				$onerow->editlink= $this->CreateLink($id, 'add_edit_group', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				$onerow->delete = $this->CreateLink($id, 'chercher_adherents_spid',$returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('obj'=>'delete_group','record_id'=>$row['id']));
				$onerow->add_users = $this->CreateLink($id, 'assign_users',$returnid, $themeObject->DisplayImage('icons/system/groupassign.gif', $this->Lang('add'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
      			}
			
  		}

		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		
		

echo $this->ProcessTemplate('groups.tpl');


#
# EOF
#
?>