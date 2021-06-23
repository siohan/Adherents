<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$adh_feu = new AdherentsFeu;
$username =$adh_feu->get_genid($userid);
$licence = '';

if(!empty($_POST))
{
	if(isset($_POST['cancel']))
	{
		//redir
		//$this->Redirect($id, "view_contacts", $returnid, array("genid"=>$genid));
	}
	//debug_display($_POST, 'Parameters');
	$smarty->assign('validation', 'true');
	
	$error = 0;
	$message = '';
	
	
	if (isset($_POST['genid']) && $_POST['genid'] !='')
	{
		$genid = $_POST['genid'];
	}
	else
	{
		$error++;
	}
	$anniversaire = '';
	if (isset($_POST['anniversaire']) && $_POST['anniversaire'] !='')
	{
		$anniversaire = $_POST['anniversaire'];
	}
	$adresse = '';
	if (isset($_POST['adresse']) && $_POST['adresse'] !='')
	{
		$adresse = $_POST['adresse'];
	}
	$code_postal = '';
	if (isset($_POST['code_postal']) && $_POST['code_postal'] !='')
	{
		$code_postal = $_POST['code_postal'];
	}
			
	$ville = '';
	if (isset($_POST['ville']) && $_POST['ville'] !='')
	{
		$ville = $_POST['ville'];
	}
			
	//on calcule le nb d'erreur
	if($error>0)
	{
		$final_msg = 'Parametres requis manquants !';
		$success = false;
		
	}
	else // pas d'erreurs on continue
	{
		$service = new Asso_adherents;		
		$update_adherent = $service->fe_edit_adherent($username,$anniversaire,$adresse,$code_postal,$ville);
		
		if(false == $update_adherent)
		{
			$success = false;
			$final_msg = 'Une erreur est apparue !';
		}
		else
		{
			$success = true;
			$final_msg = 'Modification réussie !';
		}
	}
	$smarty->assign('final_msg', $final_msg);
	$smarty->assign('success', $success);
	//on redirige en fin de script via le tpl
	
}
else
{
	//debug_display($params, 'Parameters');
	require_once(dirname(__FILE__).'/include/fe_menu.php');

	$db = cmmsms()->GetDb();
	global $themeObject;
	$licence = '';
	$genid = '';
	$edition = 0;
	$OuiNon = array("Oui"=>"1","Non"=>"0");
	$licence= 0;
	$adresse = "";
	$code_postal = "";
	$ville = "";
	$anniversaire = date('Y-m-d');
	if(isset($params['genid']) && $params['genid'] != '' && $params['genid'] == $username)
	{
		$genid = $params['genid'];

		$query  = "SELECT genid,licence,actif, anniversaire,nom, prenom, adresse, code_postal, ville FROM ".cms_db_prefix()."module_adherents_adherents WHERE genid = ?";
		$dbresult = $db->Execute($query, array($genid));
		if($dbresult && $dbresult->recordCount() >0)
		{
			while ($dbresult && $row = $dbresult->FetchRow())
			{
				//$compt++;
		
				$licence = $row['licence'];
				$nom = $row['nom'];
				$prenom = $row['prenom'];
				$adresse = $row['adresse'];
				$code_postal = $row['code_postal'];
				$ville = $row['ville'];
				$anniversaire = $row['anniversaire'];
					
			}
			
		}
		

	}
	
}
$tpl = $smarty->CreateTemplate($this->GetTemplateResource('fe_edit_adherent.tpl', null, null, $smarty));
$tpl->assign('genid', $genid);
$tpl->assign('licence', $licence);
$tpl->assign('anniversaire', $anniversaire);
$tpl->assign('adresse', $adresse);
$tpl->assign('code_postal', $code_postal);
$tpl->assign('ville', $ville);
$tpl->display();
#
#EOF
#
?>
