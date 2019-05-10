<?php
if (!isset($gCms)) exit;
debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
//global $themeObject;
require_once(dirname(__FILE__).'/include/fe_menu.php');
$db =& $this->GetDb();

//on récupère les valeurs
//pour l'instant pas d'erreur
$aujourdhui = date('Y-m-d ');
$error = 0;
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
$alert = 0;//pour savoir si certains champs doivent contenir une valeur ou non
	
		
		
	
		
	
		if (isset($params['id_inscription']) && $params['id_inscription'] !='')
		{
			$id_inscription = $params['id_inscription'];
		}
		
		$nom = '';
		if (isset($params['nom']) && $params['nom'] !='')
		{
			$nom = $params['nom'];
			$insc_ops = new T2t_inscriptions;
			//le nom est un tableau
			if(is_array($nom))
			{
				foreach($nom AS $item)
				{
					$id_option = $insc_ops->search_id_option($id_inscription, $item);
					if(false !== $id_option)
					{
						$add_rep = $insc_ops->add_reponse($id_inscription, $id_option, $username);
						//$query = "INSERT INTO ".cms_db_prefix()."module_inscriptions_belongs (id_inscription, id_option, genid) VALUES (?, ?, ?)";
						//$dbresult = $db->Execute($query, array($id_inscription, $id_option, $username));
					}

				}
			}
			else
			{
					$add_rep = $insc_ops->add_reponse($id_inscription, $nom, $username);
				//	$query = "INSERT INTO ".cms_db_prefix()."module_inscriptions_belongs (id_inscription, id_option, genid) VALUES (?, ?, ?)";
				//	$dbresult = $db->Execute($query, array($id_inscription, $nom, $username));
				
			}
			
		}
	
		
	
			
		

$this->SetMessage('Inscription ajoutée/modifiée.');
$this->Redirect($id,'fe_inscriptions', $returnid, array("record_id"=>$username));

?>