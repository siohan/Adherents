<?php
if (!isset($gCms)) exit;

$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUserProperty('genid');
$insc_ops = new T2t_inscriptions;
//debug_display($_POST,'Parameters');
if(!empty($_POST))
{
	if(isset($_POST['cancel']))
	{
		//on redir
	}
	$smarty->assign('validation', 'true');
	$smarty->assign('url_param', '?'.$params['_R']);

	if (isset($_POST['id_inscription']) && $_POST['id_inscription'] !='')
	{
		$id_inscription = $_POST['id_inscription'];
	}
	//on supprime les choix précedemment effectués
	$del = $insc_ops->delete_user_choice($id_inscription, $username);
	$nom = '';
	if (isset($_POST['nom']) && $_POST['nom'] !='')
	{
		$nom = $_POST['nom'];
		
		//le nom est un tableau
		if(is_array($nom))
		{
			foreach($nom AS $item)
			{
				$id_option = $insc_ops->search_id_option($id_inscription, $item);
				if(false !== $id_option)
				{
					$add_rep = $insc_ops->add_reponse($id_inscription, $id_option, $username);
				}

			}
		}
		else
		{
				$add_rep = $insc_ops->add_reponse($id_inscription, $nom, $username);			
		}
		//$this->Redirect($id,'fe_adhesions', $returnid, array("record_id"=>$username));
		
		
	}
	echo $this->ProcessTemplate('fe_edit_inscription.tpl');
}
else
{
	//debug_display($params,'Parameters');
	require_once(dirname(__FILE__).'/include/fe_menu.php');

	if(isset($params['id_inscription']) && $params['id_inscription'] !='')
	{
		$id_inscription = $params['id_inscription'];
		//choix multi ou pas ?
		$insc_ops = new T2t_inscriptions;
		$details = $insc_ops->details_inscriptions($id_inscription);
		$choix_multi = $details['choix_multi'];
		var_dump($choix_multi); 
	}
	$details=1;
	if(isset($params['details']) && $params['details'] !='')
	{
		$details = $params['details'];
	}

	$db = cmsms()->GetDb();
	$query = "SELECT id,nom, description, date_debut, tarif FROM ".cms_db_prefix()."module_inscriptions_options AS opt WHERE id_inscription = ? AND actif = 1 ";
	$dbresult = $db->Execute($query, array($id_inscription));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		if($details ==1)//on affiche le détail sans permettre de changer
		{

			$insc_ops = new T2t_inscriptions;
			$rowarray= array();
			$rowclass = '';
			while($row = $dbresult->FetchRow())
			{
				$onerow = new StdClass();
				$onerow->nom = $row['nom'];

				$onerow->description = $row['description'];
				$onerow->date_debut =  $row['date_debut'];
				$inscrit = $insc_ops->is_inscrit_opt($row['id'], $username);
				if(FALSE ===$inscrit )
				{
					$onerow->is_inscrit = $faux;

				}
				else
				{
					$onerow->is_inscrit = $vrai;

				}

				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
			}
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);
			echo $this->ProcessTemplate('fe_details_inscriptions.tpl');
		}
		
	}
}



#
# EOF
#

?>