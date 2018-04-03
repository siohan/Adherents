<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserName($userid);
$db =& $this->GetDb();
global $themeObject;
$licence = '';
$edition = 0;
$OuiNon = array("Oui"=>"1","Non"=>"0");
if(isset($params['record_id']) && $params['record_id'] != '' && $params['record_id'] == $username)
{
	$edition = 1;
	$record_id = $params['record_id'];
	
	$query  = "SELECT licence,actif,fftt, anniversaire,nom, prenom, adresse, code_postal, ville FROM ".cms_db_prefix()."module_adherents_adherents WHERE licence = ?";
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
				    $this->CreateFormStart( $id, 'fe_do_edit_adherent', $returnid ) );

		$smarty->assign('licence',
					$this->CreateInputHidden($id,'licence',$record_id));
		$smarty->assign('anniversaire',$this->CreateInputDate($id, 'anniversaire',(isset($anniversaire)?$anniversaire:"")));
		$smarty->assign('adresse',
				$this->CreateInputText($id,'adresse',(isset($adresse)?$adresse:""), 100, 250));
		$smarty->assign('code_postal',
				$this->CreateInputText($id, 'code_postal',(isset($code_postal)?$code_postal:""), 50, 200));		
		$smarty->assign('ville',
				$this->CreateInputText($id,'ville',(isset($ville)?$ville:""),50,200));
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
	echo "une erreur s'est produite !";
}


	







#
#EOF
#
?>