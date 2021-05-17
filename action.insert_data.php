<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('AssoSimple use'))
{
		echo $this->ShowErrors($this->Lang('needpermission'));
	return;

}


$db = cmsms()->GetDb();

/*
$query = "INSERT INTO ".cms_db_prefix()."module_news (`news_id`, `news_category_id`, `news_title`, `news_data`, `news_date`, `summary`, `start_time`, `end_time`, `status`, `icon`, `create_date`, `modified_date`, `author_id`, `news_extra`, `news_url`, `searchable`) VALUES
(1,	1,	'Travaux',	'<p>L\'espace de d&eacute;mo est momentan&eacute;ment ferm&eacute; pour travaux. A bient&ocirc;t</p>',	'2015-04-09 18:54:49',	'<p>L\'espace de d&eacute;mo est momentan&eacute;ment ferm&eacute; pour travaux. A bient&ocirc;t</p>',	NULL,	NULL,	'published',	NULL,	'2015-04-09 18:55:45',	'2017-09-13 08:34:18',	1,	'',	'',	0),
(2,	1,	'Installer AssoSimple',	'<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>\r\n<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>',	'2017-09-11 10:03:07',	'<p>Vous voulez installer la solution mais vous n\'avez pas le temps ou m&ecirc;me les comp&eacute;tences pour le faire ? Pas de panique ! Asso Simple peut vous aider &agrave; surmonter cet obstacle tr&egrave;s simple au final.</p>',	NULL,	NULL,	'published',	NULL,	'2017-09-11 10:03:51',	'2020-07-17 15:45:42',	1,	'',	'',	1),
(3,	1,	'Espace démo',	'<p><img style=\"float: left; margin: 5px;\" src=\"uploads/images/blade_new_timo_boll_forte.png\" alt=\"blade_new_timo_boll_forte\" width=\"135\" height=\"135\" />Connectez-vous &agrave; l\'adresse suivante <a title=\"Espace D&eacute;mo\" href=\"admin/\" target=\"_blank\" rel=\"noopener\">espace d&eacute;mo</a> en utilisant l\'identifiant \"utilisateur\" (sans les apostrophes) avec le mot de passe suivant : \"utilisateur\". Cet espace est actuellement rempli avec les donn&eacute;es de la deuxi&egrave;me phase 2018-2019 du club de tennis de table de Fouesnant, vous r&eacute;cup&eacute;rez vos &eacute;quipes et les rencontres qui vont avec alors le classement apparait. Idem pour les parties de vos adh&eacute;rents. Vous avez besoin d\'aide ? Consultez les vid&eacute;os d\'explications sur la page facebook de la solution :&nbsp;<a href=\"https://www.facebook.com/modulesT2T/\">https://www.facebook.com/AssoSimple1/</a></p>\r\n<p>A bient&ocirc;t !</p>',	'2017-09-11 10:11:55',	'<p>Afin d\'utiliser pleinement cet espace, merci de bien vouloir suivre les instructions suivantes :&nbsp;</p>',	NULL,	NULL,	'published',	NULL,	'2017-09-11 10:18:06',	'2020-07-17 12:28:36',	1,	'',	'',	1)";
$dbresult = $db->Execute($query);
if($dbresult)
{
	echo 'Ok news insérées';
}
else
{
	echo 'Ko news non insérées';
}
*/
$query = "INSERT INTO ".cms_db_prefix()."module_news_fielddefs (`id`, `name`, `type`, `max_length`, `create_date`, `modified_date`, `item_order`, `public`, `extra`) VALUES
(2,	'image_article',	'file',	255,	'2017-09-11 11:03:31',	'2020-07-17 13:30:33',	1,	1,	'a:1:{s:7:\"options\";N;}')";
$dbresult = $db->Execute($query);
if($dbresult)
{
	echo 'Ok fielddef news';
}
else
{
	echo 'Ko news fielddef';
}


$query = "INSERT INTO ".cms_db_prefix()."module_news_fieldvals (`news_id`, `fielddef_id`, `value`, `create_date`, `modified_date`) VALUES
(3,	2,	'lenoir.png',	'2017-09-11 11:42:47',	'2017-09-11 11:42:47'),
(2,	2,	'test.jpeg',	'2017-09-11 20:18:35',	'2017-09-11 20:18:35'),
(1,	2,	'us_plouay_tt.png',	'2020-07-17 13:31:34',	'2020-07-17 13:31:34')";
$dbresult = $db->Execute($query);
if($dbresult)
{
	echo 'Ok fielddef values';
}
else
{
	echo 'Ko news fields values';
}

$query = "INSERT INTO ".cms_db_prefix()."module_news_seq (`id`) VALUES (3)";
$dbresult = $db->Execute($query);
if($dbresult)
{
	echo 'Ok news seq';
}
else
{
	echo 'Ko news seq';
}

$query = "INSERT INTO ".cms_db_prefix()."module_marqueesmgr_marquees (id, nom, description, actif, direction, scrollamount, scrolldelay) VALUES
(1, 'accueil', 'le bandeau d\'accueil', 1, 'left', 10, 2)";
$dbresult = $db->Execute($query);
if($dbresult)
{
	echo 'Ok bandeau défilant ajouté';
}
else
{
	echo 'Ko bandeau défilant';
}
# 
#EOF
#
?>