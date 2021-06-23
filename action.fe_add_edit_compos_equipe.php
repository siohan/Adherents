<?php
if( !isset($gCms) ) exit;
debug_display($_POST,'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
require_once(dirname(__FILE__).'/include/fe_menu.php');
$db =& $this->GetDb();
$comp_ops = new compositionsbis;
$gp_ops = new groups;
$eq_comp = new equipes_comp;
if (!$this->CheckPermission('Adherents use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('adherents');
}
if( !empty($_POST) ) 
{
        if( isset($_POST['cancel']) ) 
	{
            $this->RedirectToAdminTab();
        }
	$error = 0;
	if (isset($_POST['ref_action']) && $_POST['ref_action'] != '')
	{
		$ref_action = $_POST['ref_action'];
	}
	else
	{
		$error++;
	}
	if (isset($_POST['ref_equipe']) && $_POST['ref_equipe'] != '')
	{
		$ref_equipe = $_POST['ref_equipe'];
		//var_dump($ref_equipe);
		$details = $eq_comp->details_equipe($ref_equipe);
		$nb_joueurs_mini = $details['nb_joueurs'];
	}
	else
	{
		$error++;
	}

	if($error == 0)
	{
		$message = '';
		//on vire toutes les données de cette compo avant 
		$query = "DELETE FROM ".cms_db_prefix()."module_compositions_compos_equipes WHERE ref_action = ? AND ref_equipe = ?";
		$dbquery = $db->Execute($query, array($ref_action, $ref_equipe));

		//la requete a fonctionné ?

		if($dbquery)
		{
			$genid = '';
			if (isset($_POST['genid']))
			{
				$genid = $_POST['genid'];
			}
			$i = 0;
			foreach($genid as $key=>$value)
			{
				$query2 = "INSERT INTO ".cms_db_prefix()."module_compositions_compos_equipes (ref_action, ref_equipe, genid) VALUES (?, ?, ?)";
			//	echo $query2;
				$dbresultat = $db->Execute($query2, array($ref_action, $ref_equipe,$key));
				$i++;
			}
			if($i < $nb_joueurs_mini)
			{
				$message.= "Attention équipe incomplete !";
			}
			$message.= 'participants ajoutés !';
			$this->SetMessage($message);
			$this->Redirect($id, 'fe_view_compos', $returnid, array("ref_action"=>$ref_action, "ref_equipe"=>$ref_equipe));
		}
		else
		{
			echo "la requete de suppression est down !";
		}
	}
}
else
{
	//debug_display($params, 'Parameters');
	

	$error = 0;
	$ref_action = 0;
	$ref_equipe = 0;
	$edit = 0;//on edite donc on refait l'équipe, on choisit les licences non verrouillées
	// edit = 1, on sélectionne les joueurs de cette équipe
	if(isset($params['edit']) && $params['edit'] != '')
	{
		$edit = $params['edit'];
	}
	//$edit = 0; //par défaut, pour savoir si on édite une compo existante ou s'il s'agit d'une nouvelle
	//il faut les parametres suivants : idepreuve, saison, ref_action, et peut-être ref_action

	if(isset($params['ref_action']) && $params['ref_action'] != '')
	{
		$ref_action = $params['ref_action'];
		$idepreuve = $comp_ops->get_idepreuve($ref_action);
		$smarty->assign('ref_action', $ref_action);
	}
	else
	{
		$error++;
	}
	if(isset($params['ref_equipe']) && $params['ref_equipe'] != '')
	{
		$ref_equipe = $params['ref_equipe'];
		//quelle est le groupe associé à cette équipe ?
		$eq_comp = new equipes_comp;
		$details = $eq_comp->details_equipe($ref_equipe);
		$liste_id = $details['liste_id'];//on a le numéro de la liste concernée par cette équipe
		$liste_membres = $gp_ops->liste_nom_genid_from_group($liste_id);
		$smarty->assign('ref_equipe', $ref_equipe);
	}
	else
	{
		$error++;
	}
	if($error <1)//pas d'erreur
	{

		$nb = 0;//on instancie une variable pour limiter les licences 
		$licences = $comp_ops->licences_disponibles($ref_action, $ref_equipe);
		$already_used = $comp_ops->already_used_licences($ref_action);
		if (FALSE !== $licences)
		{
			$nb = count($licences);
			$licens = implode(',',$licences);
		}

		$query = "SELECT j.genid, CONCAT_WS(' ',j.nom, j.prenom ) AS joueur, j.sexe, j.cat FROM ".cms_db_prefix()."module_adherents_adherents AS j, ".cms_db_prefix()."module_adherents_groupes_belongs as be WHERE be.genid = j.genid  AND be.id_group = ? AND j.actif = 1";


		if($nb >0)
		{
			$query.=" AND j.genid NOT IN ($licens)";
		}

		$query.=" ORDER BY joueur ASC";

			$dbresult = $db->Execute($query, array($liste_id));


			if($dbresult)
			{		
				$rowarray = array();			
				while($row = $dbresult->FetchRow())
				{
					$onerow = new StdClass();
					$onerow->ref_action = $ref_action;
					$onerow->ref_equipe = $ref_equipe;
					$onerow->genid = $row['genid'];
					$onerow->joueur = $row['joueur'];
					$onerow->participe = 0;
					$participe = $comp_ops->participe($row['genid'], $ref_action, $ref_equipe);
					if(true == $participe)
					{
						$onerow->participe = 1;
					}
					$rowarray[] = $onerow;
				}

				$smarty->assign('items', $rowarray);
				echo $this->ProcessTemplate('fe_ma_compo.tpl');
			}
	}
	
}

?>