<?php

if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Adherents use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($_POST, 'Parameters');
$db = cmsms()->GetDb();
global $themeObject;
$gp_ops = new groups;
$adh_feu = new AdherentsFeu;
$asso_ops = new Asso_adherents;
$group = '';
if(isset($_POST['record_id']) && $_POST['record_id'] >0)
{
	$group = (int) $_POST['record_id'];
	$details = $gp_ops->details_groupe($group);
	$smarty->assign('group_name', $details['nom']);
}

//on va vérifier que les données du compte sont renseignées et le n° du club aussi.
include 'include/action.navigation.php';
$parms = array();
$aujourdhui = date('Y-m-d');

$liste_groupes = $gp_ops->liste_groupes_dropdown();
$liste_groupes += [ "0" => "Tous" ];

//on vérifie si des utilisateurs ne sont pas encore vérifiés (checked = 0)
$checked = $asso_ops->not_already_checked();
$smarty->assign('checked', $checked);

$smarty->assign('liste_groupes', $liste_groupes);

$smarty->assign('group', $group);
//$ping = new Ping();
$act = 1;//par defaut on affiche les actifs (= 1 )


	$req = 2;
	$query = "SELECT id, genid, licence, nom, prenom, actif, anniversaire, sexe, certif, validation, adresse, code_postal, ville, maj, image, checked FROM ".cms_db_prefix()."module_adherents_adherents AS adh";


$query.=" ORDER BY nom ASC ";
//echo $query;
$smarty->assign('act', $act);

	$dbresult = $db->Execute($query);	

$rowarray = array();
$rowclass = 'row1';
$contact_ops = new contact;
//$adh_ops = new adherents_spid;
if($dbresult && $dbresult->RecordCount() >0)
{
	$config = cmsms()->GetConfig();
	$base = $config['root_url'];
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->genid = $row['genid'];
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		$onerow->actif= $row['actif'];
		/*
		if($actif == 1)
		{
			$onerow->actif = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"desactivate", "genid"=>$row['genid']));
		}
		else
		{
			$onerow->actif = $this->CreateLink($id, 'chercher_adherents_spid',$returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"activate", "genid"=>$row['genid']));
		}
		* */
		$onerow->sexe= $row['sexe'];
		$onerow->certif= $row['certif'];
		$onerow->date_validation = $row['validation'];
		$onerow->anniversaire = $row['anniversaire'];
		$onerow->adresse = $row['adresse'];
		$onerow->code_postal = $row['code_postal'];
		$onerow->ville = $row['ville'];
		$email = $contact_ops->has_email($row['genid']);
		//var_dump($email);
		if(TRUE === $email)
		{
			$onerow->has_email = $this->CreateLink($id, 'view_contacts', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("genid"=>$row['genid']));
		}
		elseif(FALSE === $email)
		{
			$onerow->has_email = $this->CreateLink($id, 'add_edit_contact', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("genid"=>$row['genid'], "type_contact"=>'1'));
		}
		$mobile = $contact_ops->has_mobile($row['genid']);
		if(TRUE === $mobile)
		{
			$onerow->has_mobile = $this->CreateLink($id, 'view_contacts', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("genid"=>$row['genid']));
		}
		elseif(FALSE === $mobile)
		{
			$onerow->has_mobile = $this->CreateLink($id, 'add_edit_contact', $returnid,$themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("genid"=>$row['genid'], "type_contact"=>'2'));
		}
		$uid = $adh_feu->GetUserInfoByProperty($row['genid']);
	
		if(!false == $uid)
		{
			$onerow->has_feu_account = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
		}
		else
		{
			$onerow->has_feu_account = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon');
		}
	
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
		
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	$smarty->assign('form2start',
			$this->CreateFormStart($id,'mass_action',$returnid));
	$smarty->assign('form2end',
			$this->CreateFormEnd());
	$articles = array("Activer"=>"activate", "Désactiver"=>"desactivate");
	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
}
elseif(!$dbresult)
{
	echo $db->ErrorMsg();
}

//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('adherents.tpl');

?>
