<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Adherents use'))
{

	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$db =& $this->GetDb();
global $themeObject;
$licence = '';
$edit = 0;
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
}
else
{
	//on renvoie à une erreur
}
if(isset($params['edit']) && $params['edit'] != '')
{
	$edit = $params['edit'];
}
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
}

$libelle = array("Tél"=>0,"Mail"=>1);
//Deux cas : 
// edit = 1 modification d'un contact existant ->On affiche le formulaire avec le contact à modifier
// edit = 0 Ajout d'un nouveau contact -> on affiche un formulaire vierge

if($edit == 0)
{
	// On affiche un formulaire vierge, sauf pour la licence
	
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_add_contact', $returnid ) );
	
	$smarty->assign('licence',
				$this->CreateInputHidden($id,'licence',$licence));
	
	$smarty->assign('type_contact',
			$this->CreateInputDropdown($id,'type_contact',$libelle));
	$smarty->assign('contact',
			$this->CreateInputText($id, 'contact','', 50, 200));		
	$smarty->assign('description',
			$this->CreateInputText($id,'description','',50,200));
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());
	
}
else
{
	$query  = "SELECT id, licence, type_contact, contact, description FROM ".cms_db_prefix()."module_adherents_contacts WHERE licence = ? AND id = ?";
	$dbresult = $db->Execute($query, array($licence, $record_id));
	if($dbresult)
	{
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			//$compt++;
			$record_id = $row['id'];
			$licence = $row['licence'];
			//$commande_number = $row['commande_number'];
			$type_contact = $row['type_contact'];
			$contact = $row['contact'];
			$description = $row['description'];
			
				
			
			
		}
		$smarty->assign('formstart',
				    $this->CreateFormStart( $id, 'do_add_contact', $returnid ) );

		$smarty->assign('record_id',
					$this->CreateInputHidden($id,'record_id',$record_id));
		$smarty->assign('licence',
					$this->CreateInputHidden($id,'licence',$licence));

		$smarty->assign('type_contact',
				$this->CreateInputDropdown($id,'type_contact',$libelle));
		$smarty->assign('contact',
				$this->CreateInputText($id, 'contact',$contact, 50, 200));		
		$smarty->assign('description',
				$this->CreateInputText($id,'description',$description,50,200));
		$smarty->assign('submit',
				$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
		$smarty->assign('cancel',
				$this->CreateInputSubmit($id,'cancel',
							$this->Lang('cancel')));


		$smarty->assign('formend',
				$this->CreateFormEnd());
	}
	elseif(!$dbresult)
	{
		echo $db->ErrorMsg();
	}
}

//on prépare un lien pour ajouetre un nouveau contact
$smarty->assign('add_edit_contact', $this->CreateLink($id, 'add_edit_contact', $returnid, $contents='Nouveau contact',array("licence"=>$licence,"edit"=>"0")));


//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('add_edit_contact.tpl');
?>