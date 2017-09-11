<?php
if(!isset($gCms)) exit;
if(!$this->CheckPermission('Adherents use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
//debug_display($params, 'Parameters');
$idAppli = '';
$motdepasse = '';
$tm = '';//le timestamp non crypté
$error = 0;//on initialise un compteur d'erreurs 
$designation = '';//on initialise les messages d'erreurs
$ops = new adherents_spid();

if(isset($params['idAppli']) && $params['idAppli'] !='')
{
	$idAppli = $params['idAppli'];
	
}
else
{
	$error++;
	$designation.="Il manque l'Id de l'application.";
}
if(isset($params['motdepasse']) && $params['motdepasse'] !='')
{
	$motdepasse = $params['motdepasse'];
	//on crypte le mot de passe 
	$cde = hash('md5', $motdepasse, FALSE);
		
}
else
{
	$error++;
	$designation.=" Votre mot de passe est manquant.";
	
}

//echo $this->GetPreference('serie');
if($this->GetPreference('serie') =='' || $this->GetPreference('serie') == '0')
{
	
	$serie = $ops->random_serie(15);
}
else
{
	$serie = $this->GetPreference('serie');		
}

//echo 'le numéro de série est : '.$serie;
if($error>0)
{
	$this->SetMessage($designation);
	$this->RedirectToAdminTab('compte');
}
else
{
	//tt est ok, on peut commencer...
	//on met l'id de l'application et le mot de passe en préférence
	$this->SetPreference('idAppli',$idAppli);
	$this->SetPreference('motdepasse',$cde);
	$this->SetPreference('serie',$serie);
//	$this->SetPreference('club_number', $club_number);
	//on va d'abord tester si le numéro de club correspond à qqch
	
	
$this->Redirect($id, 'getInitialisation',$returnid);//, array("install"=>"1", "step"=>"1"));	
}
#
#EOF
#
?>