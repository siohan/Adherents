<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

if (!$this->CheckPermission('Adherents use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('adherents');
}
if( isset($params['cancel']) )
{
	$this->RedirectToAdminTab('adherents');
	return;
}
$db =& $this->GetDb();
global $themeObject;
$licence = '';
$edition = 0;
$OuiNon = array("Non"=>"0","Oui"=>"1");
$edit = 0;
if(isset($params['record_id']) && $params['record_id'] != '')
{
	
	$record_id = $params['record_id'];
	$as_adh = new Asso_adherents;
	$details = $as_adh->details_adherent($record_id);
	$edit = 1;
	$smarty->assign('genid',$this->CreateInputHidden($id,'genid', $details['genid']));
			
}

	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_edit_adherent', $returnid ) );

	$smarty->assign('licence',
				$this->CreateInputText($id,'licence',(isset($details['licence'])?$details['licence']: ""), 15,30));
	$smarty->assign('nom',
			$this->CreateInputText($id,'nom',(isset($details['nom'])?$details['nom']: ""), 150,300));
	$smarty->assign('prenom',
			$this->CreateInputText($id,'prenom',(isset($details['prenom'])?$details['prenom']: ""), 150,300));
	$smarty->assign('sexe',
			$this->CreateInputDropdown($id,'sexe',array("Masculin"=>"M", "Féminin"=>"F"),'',(isset($details['sexe'])?$details['sexe']:"M")));
	$smarty->assign('externe',
			$this->CreateInputDropdown($id,'externe',$OuiNon, '',(isset($details['externe'])?$details['externe']:"Non")));
	$smarty->assign('anniversaire',
			$this->CreateInputDate($id, 'anniversaire',(isset($details['anniversaire'])?$details['anniversaire']: "")));
	$smarty->assign('adresse',
			$this->CreateInputText($id,'adresse',(isset($details['adresse'])?$details['adresse']: ""), 100, 250));
	$smarty->assign('code_postal',
			$this->CreateInputText($id, 'code_postal',(isset($details['code_postal'])?$details['code_postal']: ""), 50, 200));		
	$smarty->assign('ville',
			$this->CreateInputText($id,'ville',(isset($details['ville'])?$details['ville']: ""),50,200));
	$smarty->assign('pays',
			$this->CreateInputText($id,'pays',(isset($details['pays'])?$details['pays']: ""),50,200));
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());
			
	//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('edit_adherent.tpl');

#
#EOF
#
?>