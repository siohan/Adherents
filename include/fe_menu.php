<?php
/*
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$username = $params['record_id'];
}
*/
if($this->GetPreference('feu_commandes') == 1)
{
	$com_ops = new commandes_ops;
	$nb_commandes = $com_ops->nb_commandes_per_user($username);
	$smarty->assign('nb_commandes', $nb_commandes);
	
}
if($this->GetPreference('feu_messages') == 1)
{
	$mess_ops = new T2t_messages;
	$nb_messages = $mess_ops->nb_messages_per_user($username);
	$smarty->assign('nb_messages', $nb_messages);
}
$asso_ops = new Asso_adherents;
$details = $asso_ops->details_adherent_by_genid($username);
$prenom = $details['prenom'];
$smarty->assign('username', $username);
$smarty->assign('prenom', $prenom);
$smarty->assign('feu_contacts', $this->GetPreference('feu_contacts'));
$smarty->assign('feu_commandes', $this->GetPreference('feu_commandes'));
$smarty->assign('feu_messages', $this->GetPreference('feu_messages'));
$smarty->assign('feu_inscriptions', $this->GetPreference('feu_inscriptions'));
$smarty->assign('feu_presences', $this->GetPreference('feu_presences'));
$smarty->assign('feu_factures', $this->GetPreference('feu_factures'));
$smarty->assign('feu_fftt', $this->GetPreference('feu_fftt'));
$smarty->assign('feu_compos', $this->GetPreference('feu_compos'));
$smarty->assign('feu_adhesions', $this->GetPreference('feu_adhesions'));

//echo $username;
echo $this->ProcessTemplate('fe_menu2.tpl');
?>