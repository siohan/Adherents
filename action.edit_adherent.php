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
$OuiNon = array("Oui"=>"1","Non"=>"0");
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$edition = 1;
	$valeur = 1;
	$record_id = $params['record_id'];
	
	$query  = "SELECT licence,actif,fftt, nom, prenom, adresse, code_postal, anniversaire, ville FROM ".cms_db_prefix()."module_adherents_adherents WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			//$compt++;
			
			$licence = $row['licence'];
			$nom = $row['nom'];
			$prenom = $row['prenom'];
			$fftt = $row['fftt'];
			$adresse = $row['adresse'];
			$code_postal = $row['code_postal'];
			$ville = $row['ville'];
			$anniversaire = $row['anniversaire'];
			
				
			
			
		}
		$smarty->assign('formstart',
				    $this->CreateFormStart( $id, 'do_edit_adherent', $returnid ) );
		$smarty->assign('edit',$this->CreateInputHidden('edit',$edition));
		$smarty->assign('licence',
					$this->CreateInputHidden($id,'licence',$licence));
		$smarty->assign('anniversaire',$this->CreateInputDate($id, 'anniversaire', $anniversaire));
		$smarty->assign('adresse',
				$this->CreateInputText($id,'adresse',$adresse, 100, 250));
		$smarty->assign('code_postal',
				$this->CreateInputText($id, 'code_postal',$code_postal, 50, 200));		
		$smarty->assign('ville',
				$this->CreateInputText($id,'ville',$ville,50,200));
		$smarty->assign('submit',
				$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
		$smarty->assign('cancel',
				$this->CreateInputSubmit($id,'cancel',
							$this->Lang('cancel')));


		$smarty->assign('formend',
				$this->CreateFormEnd());
				
		//$query.=" ORDER BY date_compet";
	echo $this->ProcessTemplate('edit_adherent.tpl');
	}
	elseif(!$dbresult)
	{
		echo $db->ErrorMsg();
	}
	
}
else
{
	$valeur = 0;
	$smarty->assign('edition',$valeur);
	$smarty->assign('edit',$this->CreateInputHidden('edit',$valeur));
	//on renvoie à un formulaire vierge
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_edit_adherent', $returnid ) );

	$smarty->assign('licence',
				$this->CreateInputText($id,'licence',$licence, 15,30));
	$smarty->assign('nom',
			$this->CreateInputText($id,'nom','', 15,30));
	$smarty->assign('prenom',
			$this->CreateInputText($id,'prenom','', 15,30));
	$smarty->assign('fftt',
			$this->CreateInputDropdown($id,'fftt',$OuiNon, '',''));
	$smarty->assign('anniversaire',
			$this->CreateInputDate($id, 'anniversaire'));
	$smarty->assign('adresse',
			$this->CreateInputText($id,'adresse','', 100, 250));
	$smarty->assign('code_postal',
			$this->CreateInputText($id, 'code_postal','', 50, 200));		
	$smarty->assign('ville',
			$this->CreateInputText($id,'ville','',50,200));
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());
			
	//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('edit_adherent.tpl');
}


	







#
#EOF
#
?>