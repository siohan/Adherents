<?php

if( !isset($gCms) ) exit;

	if (!$this->CheckPermission('Adherents use'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('adherents');
    		return;
  	}
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//s'agit-il d'une modif ou d'une créa ?
$club_number = '';
$numero_club = $this->GetPreference('club_number');
if(isset($numero_club) && $numero_club != '')
{
	$club_number = $numero_club;
}



	
	//on construit le formulaire
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_add_club_number', $returnid ) );
		
	$smarty->assign('club_number',
			$this->CreateInputText($id,'club_number',(isset($club_number)?$club_number:""),50,200));
	
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());
	
	



echo $this->ProcessTemplate('add_edit_club_number.tpl');

#
# EOF
#
?>
