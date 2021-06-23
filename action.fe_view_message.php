<?php
if (!isset($gCms)) exit;
debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
require_once(dirname(__FILE__).'/include/fe_menu.php');
//echo "FEU : le user est : ".$username." ".$userid;
//$properties = $feu->GetUserProperties($userid);
//$email = $feu->LoggedInEmail();
//echo $email;
//var_dump($email);
$delete = '<img src="modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$view = '<img src="modules/Adherents/images/view.gif" class="systemicon" alt="Modifier" title="Modifier">';
$vrai = '<img src="modules/Adherents/images/true.gif" class="systemicon" alt="Vrai" title="Vrai">';
$faux = '<img src="modules/Adherents/images/false.gif" class="systemicon" alt="Faux" title="Faux">';
if(isset($params['recip_id']) && $params['recip_id'] !='')
{
	$recip_id = $params['recip_id'];
	$mess_ops = new T2t_messages;
	$mess_ops->ar($recip_id, $username);
	
}
else
{
	$this->SetMessage('Pas de message sélectionné !');
	$this->Redirect($id, 'fe_messages',$returnid, array("record_id"=>$username));
}
if(isset($params['message_id']) && $params['message_id'] !='')
{
	$message_id = $params['message_id'];
	
}
else
{
	$this->SetMessage('Pas de message sélectionné !');
	$this->Redirect($id, 'fe_messages', $returnid,array("record_id"=>$username));
}
//on va changer le statut du message à "Lu"

$designation = '';
$smarty->assign('fe_add_cc',
		$this->CreateLink($id, 'default', $returnid, 'Ajouter un article', array("record_id"=>$username,"display"=>"add_cc_items")));
	
	$query = "SELECT mess.id AS id_message,mess.sender, mess.senddate, mess.sendtime, mess.replyto, mess.group_id, mess.subject, mess.message, recip.genid FROM ".cms_db_prefix()."module_messages_messages AS mess, ".cms_db_prefix()."module_messages_recipients AS recip  WHERE mess.id = recip.message_id AND mess.id = ? AND recip.genid = ?";
	$dbresult = $db->Execute($query, array($message_id,$username));
	
	if($dbresult && $dbresult->recordCount() >0)
	{
		$rowclass = array();
		while($row = $dbresult->FetchRow())
		{
		
			$onerow = new StdClass();
			$onerow->sender = $row['sender'];
			$onerow->senddate = $row['senddate'];
			$onerow->sendtime =  $row['sendtime'];
			$onerow->replyto = $row['replyto'];
			$onerow->group_id = $row['group_id'];
			$onerow->subject = $row['subject'];
			$onerow->message = $row['message'];			
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;	

		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
			
	}		

	echo $this->ProcessTemplate('fe_view_message.tpl');	
#
# EOF
#

?>