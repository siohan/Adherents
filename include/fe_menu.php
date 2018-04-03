<?php
$smarty->assign('infos_persos', $this->CreateLink($id, 'fe_edit_adherent', $returnid,'Mes infos (adresse, etc..)', array("record_id"=>$username)));
$smarty->assign('contacts', $this->CreateLink($id, 'fe_view_contacts', $returnid,'Mes contacts', array("record_id"=>$username)));
$smarty->assign('myresults', $this->CreateLink($id, 'fe_user_results', $returnid,'Mes résultats', array("record_id"=>$username)));
$smarty->assign('masitmens', $this->CreateLink($id, 'fe_sit_mens', $returnid,'Ma situation mensuelle', array("record_id"=>$username)));
$smarty->assign('spid', $this->CreateLink($id, 'fe_spid', $returnid,'Mon spid', array("record_id"=>$username)));
$smarty->assign('MesCommandes', $this->CreateLink($id, 'default', $returnid,'Mes commandes', array("display"=>"fe_commandes", "record_id"=>$username)));
$smarty->assign('EnvoiMessage', $this->CreateLink($id, 'default', $returnid,'Envoyer un message', array("display"=>"fe_envoi_message", "record_id"=>$username)));
echo $this->ProcessTemplate('fe_menu.tpl');
?>