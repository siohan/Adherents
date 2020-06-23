<?php

if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$pres_ops = new T2t_presence;
if(!empty($_POST))
{
	if(isset($_POST['cancel']))
	{
		//redir 
		$this->Redirect($id, 'view_adherent_details', $returnid, array('genid'=>$genid));
	}
	$error = 0;
	if(isset($_POST['id_presence']) && $_POST['id_presence'] >0)
	{
		$id_presence = (int) $_POST['id_presence'];
	}
	else
	{
		$error++;
	}
	if(isset($_POST['genid']) && $_POST['genid'] != '')
	{
		$genid = $_POST['genid'];
	}
	else
	{
		$error++;
	}
	if(isset($_POST['id_option']) && $_POST['id_option'] != '')
	{
		$id_option = $_POST['id_option'];
	}
	else
	{
		$error++;
	}
	if($error < 1)
	{
		$del_rep = $pres_ops->delete_reponse($id_presence, $genid);
		$add = $pres_ops->add_reponse($id_presence,$genid, $id_option);
		//on redirige
		$this->SetMessage('Réponse ajoutée !');
	}
	else
	{
		$this->SetMessage('Réponse non ajoutée !!');
	}
	$this->Redirect($id, 'view_adherent_details', $returnid, array('record_id'=>$genid));
}
else
{
	//debug_display($params, 'Parameters');
	$db =& $this->GetDb();
	global $themeObject;
	$error = 0;
	$user_choice = 0;
	if(isset($params['genid']) && $params['genid'] >0)
	{
		$genid = $params['genid'];
	}
	else
	{
		$error++;
	}
	if(isset($params['id_presence']) && $params['id_presence'] !='')
	{
		$id_presence = $params['id_presence'];
		//details de la présence
	
		$pres_ops = new T2t_presence;
		$details_pres = $pres_ops->details_presence($id_presence);
		$groupe = $details_pres['groupe'];
		$titre = $details_pres['nom'];
		$smarty->assign('titre', $titre);
		$has_expressed = $pres_ops->has_expressed($id_presence,$genid);
		if(true == $has_expressed)
		{
			//on va chercher la valeur de l'id_option retenue
			$user_choice = $pres_ops->user_choice($id_presence, $genid);
		}
	
	
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('reponses.tpl'), null, null, $smarty);
		$tpl->assign('id_presence', $id_presence);
		$tpl->assign('genid', $genid);
		$tpl->assign('user_choice', $user_choice);
		$tpl->display();
	
	}
	else
	{
		$error++;
		//redir
	}
}

#
# EOF
#
?>