<?php
if (!isset($gCms)) exit;
debug_display($params, 'Parameters');

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
$edit = 0;
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
	
	$query  = "SELECT licence,actif, nom, prenom, adresse, code_postal, ville FROM ".cms_db_prefix()."module_adherents_adherents WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult)
	{
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			//$compt++;
			
			$nom = $row['nom'];
			$prenom = $row['prenom'];
			$adresse = $row['adresse'];
			$code_postal = $row['code_postal'];
			$ville = $row['ville'];
			//$description = $row['description'];
			
				
			
			
		}
		$smarty->assign('formstart',
				    $this->CreateFormStart( $id, 'do_edit_adherent', $returnid ) );

		$smarty->assign('licence',
					$this->CreateInputHidden($id,'licence',$licence));

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
	//on renvoie à une erreur
}


	







#
#EOF
#
?>