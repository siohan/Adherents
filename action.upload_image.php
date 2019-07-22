<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if(isset($params['genid']) && $params['genid'] !='')
{
	$genid = $params['genid'];
}
/************************************************************
 * Definition des constantes / tableaux et variables
 *************************************************************/
 
// Constantes
    // Repertoire cible




 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
/*
if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
*/
$tpl = $smarty->CreateTemplate( $this->GetTemplateResource('upload_image.tpl'), null, null, $smarty );
    $tpl->assign('genid',$genid);
    $tpl->display();
?>
