<?php


if(isset($params['record_id']) && $params['record_id'] != '')
{
	$username = $params['record_id'];
}
$com_ops = new commandes_ops;
$nb_commandes = $com_ops->nb_commandes_per_user($username);

$cotis_ops = new cotisationsbis;
//$cotis_ref_action = $cotis_ops->cotis_

$smarty->assign('nb_commandes', $nb_commandes);
$smarty->assign('username', $username);

$smarty->assign('missing', $this->CreateLink($id, 'default', $returnid, 'Article manquant ?', array("record_id"=>$username, "display"=>"fe_add_item")));
$smarty->assign('Retour', $this->CreateLink($id, 'default', $returnid, ' RP Fouesnant : mon compte', array("display"=>"default","record_id"=>$username), $addtext='class="navbar-brand mr-1"' ));
$smarty->assign('infos_persos', $this->CreateLink($id, 'default', $returnid,'Mes infos', array("record_id"=>$username, "display"=>"infos"),'' ,'', true, 'class="nav-link"'));
$smarty->assign('contacts', $this->CreateLink($id, 'fe_view_contacts', $returnid,'Mes contacts', array("record_id"=>$username, "display"=>"infos"),'' ,'', true, $addtext='class="list-group-item"'));
$smarty->assign('myresults', $this->CreateLink($id, 'fe_user_results', $returnid,'Mes résultats', array("record_id"=>$username, "display"=>"infos"),'' ,'', true, $addtext='class="list-group-item"'));
$smarty->assign('masitmens', $this->CreateLink($id, 'fe_sit_mens', $returnid,'Ma situation mensuelle', array("record_id"=>$username, "display"=>"infos"),'' ,'', true, $addtext='class="list-group-item"'));
$smarty->assign('spid', $this->CreateLink($id, 'fe_spid', $returnid,'Mon spid', array("record_id"=>$username, "display"=>"infos"),'' ,'', true, $addtext='class="list-group-item"'));
$smarty->assign('MesCommandes', $this->CreateLink($id, 'fe_commandes', $returnid,'Mes commandes', array("display"=>"fe_commandes", "record_id"=>$username, "display"=>"infos"),'' ,'', true, $addtext='class="list-group-item"'));
$smarty->assign('EnvoiMessage', $this->CreateLink($id, 'default', $returnid,'Envoyer un message', array("display"=>"fe_envoi_message", "record_id"=>$username, "display"=>"infos"),'' ,'', true, $addtext='class="list-group-item"'));
echo $this->ProcessTemplate('fe_menu2.tpl');
?>