<?php
if( !isset($gCms) ) exit;
//echo "Cool !";
debug_display($params, 'Parameters');
$designation = '';//le message de fin....
$feu = cms_utils::get_module('FrontEndUsers');

$gp_ops = new groups;

if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	$details = $gp_ops->details_groupe($record_id);
}

	//on fait le job
	//on ajoute le groupe
	$group_exists = $feu->GetGroupId($details['nom']);
//	var_dump($group_exists)

	if(FALSE === $group_exists || true == is_null($group_exists))
	{
		$feu->AddGroup($details['nom'], $details['description']);
		
		/* On récupère l'id du group créé  */
		$gid = $feu->GetGroupId($details['nom']);
		
		/*
		on créé les propriétés de ce groupe à savoir
		1- Ton email
		2- Ton nom
		*/
		$name = "email";
		$prompt = "Ton email";
		$type = 2;//0 = text; 1 = checkbox; 2 = email;3 = textarea; 4,5 = count(options)?;6 = image;7= radiobuttons; 8= date
		$length = 80;
		$maxlength = 255;		
	//	$feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = 0, $encrypt = 0 );
		
		$sortkey = 1;
		$required = 2; //2= requis, 1 optionnel, 0 = off
		/* on peut assigner les propriétés au groupe  */
		$feu->AddGroupPropertyRelation($gid,$name,$sortkey, -1, $required);
		
		/*On fait la même chose pour la deuxième propriété */
		$name = "nom";
		$prompt = "Ton nom";
		$type = 0;
		$length = 80;
		$maxlength = 255;		
	//	$feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = 0, $encrypt = 0 );
		
		$sortkey = 1;
		$required = 2; //2= requis, 1 optionnel, 0 = off
		/* on peut assigner les propriétés au groupe  */
		$feu->AddGroupPropertyRelation($gid,$name,$sortkey, -1, $required);
		
		/*On fait la même chose pour la troisième propriété */
		$name = "genid";
		$prompt = "Ton ID";
		$type = 0;
		$length = 10;
		$maxlength = 15;		
	//	$feu->AddPropertyDefn($name, $prompt, $type, $length,$maxlength,$attribs = '', $force_unique = 0, $encrypt = 0 );
		
		$sortkey = 1;
		$required = 0; //2= requis, 1 optionnel, 0 = off
		/* on peut assigner les propriétés au groupe */
		$feu->AddGroupPropertyRelation($gid,$name,$sortkey, -1, $required);
		
		
		//on y ajoute tous les utilisateurs actifs
		
		$query = "SELECT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$genid = (int) $row['genid'];
				$user_exists = $feu->GetUserInfoByProperty('genid', $genid);
				var_dump($user_exists);
				$uid = $user_exists[1]['id'];
				if(true == $user_exists[0])
				{
					// l'utilisateur est-il déjà ds le groupe en question ?
					$is_member = $feu->MemberOfGroup($uid, $gid);
					if(false == $is_member)
					{
						//on ajoute l'utilisateur au groupe
						$assign = $feu->AssignUserToGroup($uid, $gid);
					}
				}
				else
				{
					//on crée l'utilisateur
				}
			//	var_dump($user_exists);
			}
		}
		 
		$this->SetMessage('Le groupe a été créé ds le module authentification FEU');
		
	}
	else
	{
		$this->SetMessage('Le groupe a déjà été créé ds FEU');
	}
	
	
	
	
	$this->RedirectToAdminTab('groupes');
	



# EOF
#

?>