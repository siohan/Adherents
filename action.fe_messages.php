<?php
if (!isset($gCms)) exit;
//debug_display($params,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//$username = $feu->GetUserName($userid);
//$username 
require_once(dirname(__FILE__).'/include/fe_menu.php');
//echo "FEU : le user est : ".$username." ".$userid;
//$properties = $feu->GetUserProperties($userid);
//$email = $feu->LoggedInEmail();
//echo $email;
//var_dump($email);
$del = '<img src="modules/Adherents/images/delete.gif" class="systemicon" alt="Supprimer" title="Supprimer">';
$view = '<img src="modules/Adherents/images/view.gif" class="systemicon" alt="Modifier" title="Modifier">';
$vrai = 'Oui';//'<img src="modules/Adherents/images/true.gif" class="systemicon" alt="Vrai" title="Vrai">';
$faux = 'Non';//'<img src="modules/Adherents/images/false.gif" class="systemicon" alt="Faux" title="Faux">';

$designation = '';
$smarty->assign('fe_envoi_message',
		$this->CreateLink($id, 'fe_envoi_message', $returnid, 'Ecrire un nouveau message', array("record_id"=>$username,$inline='true')));
	
	$query = " SELECT mess.id AS id_message,mess.sender, mess.senddate, mess.sendtime, mess.replyto, mess.group_id, mess.subject, mess.message, recip.genid, recip.id AS mess_id, recip.ar FROM ".cms_db_prefix()."module_messages_messages AS mess, ".cms_db_prefix()."module_messages_recipients AS recip  WHERE mess.id = recip.message_id AND recip.genid = ? AND mess.sent = '1' AND recip.actif = '1' ORDER BY senddate DESC, sendtime DESC";
	$dbresult = $db->Execute($query, array($username));
	
	if($dbresult && $dbresult->recordCount() >0)
	{
		$rowclass = array();
		while($row = $dbresult->FetchRow())
		{
					
			$lu = $row['ar'];
			$mess_id = $row['mess_id'];
			$onerow = new StdClass();
			$onerow->id_message= $row['id_message'];
			$onerow->sender = $row['sender'];
			$onerow->senddate = $row['senddate'];
			$onerow->sendtime =  $row['sendtime'];
			$onerow->replyto = $row['replyto'];
			$onerow->group_id = $row['group_id'];
			$onerow->subject = $row['subject'];
		//	$onerow->message = $row['message'];
			if($lu == 1)
			{
				$onerow->lu =$vrai;
			}
			else
			{
				$onerow->lu =$faux;
			}
			$onerow->delete = $this->CreateLink($id, 'fe_delete',$returnid, 'Supprimer',array("licence"=>$username,"obj"=>"message","record_id"=>$row['mess_id']));
			$onerow->view = $this->CreateLink($id, 'fe_view_message', $returnid,'Voir',array("licence"=>$username, "message_id"=>$row['id_message'], "recip_id"=>$row['mess_id']),$warn_message='',$onlyhref='',$inline='true');
			
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
				
				


		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
			
	}
		

	echo $this->ProcessTemplate('fe_messages.tpl');	
#
# EOF
#

?>