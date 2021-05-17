<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_adherents_groupes";
$feu = \cms_utils::get_module('FrontEndUsers');
$dbresult= $db->Execute($query);
	
	//echo $query;
	$rowarray= array();
	$rowclass = '';
	$group_ops = new groups();
	$contact_ops = new contact();
	$dir = dirname(__FILE__);
	//	$img_sms = '<img src="../Adherents/images/sms2.png" class="systemicon" alt="Envoyer des SMS" title="Envoyer des SMS">';
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;

				//les champs disponibles : 
				$actif = $row['actif'];
				$public = $row['public'];
				$auto_subscription = $row['auto_subscription'];
				$id = $row['id'];
				$onerow->id= $row['id'];
				$smarty->assign("id", $row['id']);
				$nb = $group_ops->count_users_in_group($row['id']);
				$onerow->nom = $row['nom'];
				$frontEnd = $feu->GetGroupId($row['nom']);
				
				//$onerow->nom = $row['nom'];
				$onerow->description = $row['description'];
				$onerow->nb_users = $nb;
				if($actif == 1)
				{
					$onerow->actif = $this->CreateLink($id, 'chercher_adherents_spid', $returnid,$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"desactivate_group", "record_id"=>$row['id']));
					if($public == 1)
					{
						$onerow->public = $this->CreateLink($id, 'chercher_adherents_spid', $returnid,$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"unpublish_group", "record_id"=>$row['id']));
					}
					else
					{
						$onerow->public = $this->CreateLink($id, 'chercher_adherents_spid', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"publish_group", "record_id"=>$row['id']));
					}
					if($auto_subscription == 1)
					{
						$onerow->auto_subscription = $this->CreateLink($id, 'chercher_adherents_spid', $returnid,$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"ko_auto", "record_id"=>$row['id']));
					}
					else
					{
						$onerow->auto_subscription = $this->CreateLink($id, 'chercher_adherents_spid', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"ok_auto", "record_id"=>$row['id']));
					}
					
				}
				else
				{
					$onerow->actif = $this->CreateLink($id, 'chercher_adherents_spid', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"activate_group", "record_id"=>$row['id']));
					if($public == 1)
					{
						$onerow->public = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
					}
					else
					{
						$onerow->public = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('delete'), '', '', 'systemicon');
					}
					if($auto_subscription == 1)
					{
						$onerow->auto_subscription = $this->CreateLink($id, 'chercher_adherents_spid', $returnid,$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"ko_auto", "record_id"=>$row['id']));
					}
					else
					{
						$onerow->auto_subscription = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon');
					}
				}
				
				if($frontEnd >0)
				{
					$onerow->feu = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
				}
				else
				{
					$onerow->feu = $this->CreateLink($id, 'push_group', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				}
				
				$onerow->tag= $row['tag'];
				$onerow->editlink= $this->CreateLink($id, 'add_edit_group', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				// = $row['actif'];			
				
			//	$onerow->send_emails= $this->CreateLink($id, 'envoi_emails', $returnid, $themeObject->DisplayImage('icons/topfiles/cmsmailer.gif', $this->Lang('send_emails'), '', '', 'systemicon'),array("group"=>$row['id'])) ;
			//	$onerow->send_sms= $this->CreateLink($id, 'envoi_sms', $returnid, 'SMS',array("group"=>$row['id'])) ;
				$onerow->push_feu= $this->CreateLink($id, 'push_group', $returnid, $themeObject->DisplayImage('icons/topfiles/usersgroups.png', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				if($id >1)
				{
					$onerow->delete = $this->CreateLink($id, 'chercher_adherents_spid',$returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('obj'=>'delete_group','record_id'=>$row['id']));
				}
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