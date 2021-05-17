<?php
$lang['add'] = 'Ajouter ';
$lang['apply'] = 'Appliquer';
$lang['apply_to_selection'] = 'Appliquer à la sélection ?';
$lang['areyousure_actionmultiple'] = 'Appliquer cette action à toute la sélection ?';
$lang['back'] = 'Revenir';
$lang['cancel'] = 'Annuler';
$lang['delete'] = 'Supprimer';
$lang['edit'] = 'Modifier';
$lang['false'] = 'Faux';
$lang['friendlyname'] = 'Asso Adhérents';
$lang['groupmembers'] = 'Membres du groupe';
$lang['moddescription'] = 'Les adhérents de votre association.';
$lang['needpermission'] = 'Une permission est nécessaire';
$lang['postinstall'] = 'Merci d\avoir installer ce module. Deux permissions ajoutées.';
$lang['postuninstall'] = 'Module désinstallé.';
$lang['really_uninstall'] = 'Etes-vous certain de vouloir désinstaller ce module ?';
$lang['resultsfoundtext'] = 'Résultats trouvés';
$lang['push']= 'Ajouter l\'utilisatuer l\'espace privé';
$lang['send_emails'] = 'Envoyer des mails';
$lang['submit'] = 'Envoyer';
$lang['true'] = 'Vrai';
$lang['view_contacts'] = ' Voir les contacts';
$lang['welcome_text'] = '<p>Bienvenue dans le module de gestion des adhérents de votre association</p>';
$lang['help_public_group'] = 'Mettez Oui si vous souhaitez afficher ce groupe dans une page de votre site';
$lang['help_admin_valid'] = 'Si Oui l\'admin valide chaque inscription au groupe. Si Non, les codes sont automatiquement envoyés par email et le nouveau membre peut se logguer dans son espace privé.';
$lang['help_auto_enregistrement'] = 'Si Oui tout le monde peut s\'enregistrer depuis le frontal. Si non, seul l\'admin peut enregistrer les utilisateurs';
$lang['help_pageid_aftervalid'] = 'Indiquez l\'alias de la page où rediriger vos nouveaux inscrits. Si nul pas de redirection.';



$lang['help'] = '<h3>Que fait ce module ?</h3>

<p>Ce module vous permet de gérer les membres de votre structure. Il rassemble les informations essentielles. Vous pouvez ensuite y ajouter leurs adresses et contacts.</p>
<h3>Pré-requis pour l\'espace privé</h3>
<p>RGPD oblige, un espace privé a été créé. Il permet à vos membres d\'accéder, de modifier voire de supprimer les informations les concernant.<br />
<h5>Voici les différentes étapes :</h5>
Pour agrémenter cet espace,un thème visuel Bootstrap 4 appelé "SB ADMIN" a été utilisé. Il est disponible en téléchargement (fichier xml) ici : <a href="http://dev.cmsmadesimple.org/project/files/1395">SB Admin</a><br />Dans le menu principal, allez dans "Disposition" puis "Gestion du design", puis "Design" et cliquez sur "Importer un design" et sélectionner le fichier préalablement téléchargé. Le tour est joué !	
<br />Créez une nouvelle page et nommez-la "Mon compte".<br />
Dans l\'onglet "Principal", mettez le tag suivant : {cms_module module=\'Adherents\' display=\'default\'}. <br />
<strong> !! IMPORTANT !!</strong> Cette page doit avoir comme alias : mon-compte<br />
Dans l\'onglet "logique" de cette page, mettez les tags suivants dans les "balises spécifiques de cette page" : 
<ul>
<li>{cms_module_hint module=FrontEndUsers logintemplate=\'newloginform.tpl\'}</li>
<li>{cms_module_hint module=FrontEndUsers verifycodetemplate=\'verifycode.tpl\'}</li>
<li>{cms_module_hint module=FrontEndUsers forgotpwtemplate=\'forgotpassword.tpl\'}</li>
<li>{cms_module_hint module=FrontEndUsers logouttemplate=\'logoutform.tpl\'}</li>
</ul>
Ce sont des gabarits prêts à l\'emploi que vous pouvez télécharger  <a href="http://www.agi-webconseil.fr/uploads/Archive.zip">ici</a><br />
Pour éviter des modifications lors de mises à jour du module, vous pouvez mettre ces fichiers dans un nouveau répertoire dont le chemin doit être le suivant : racine_de_votre_site/assets/module_custom/FrontEndUsers/templates
<br />Enfin, insérez cette ligne : <code>$config[\'username_is_email\'] = \'false\';</code> dans le fichier config.php à la racine de votre site.<br />
 Pour prévenir vos membres de cet espace quand ils sont acceptés, le gabarit de courriel s\'intitule "orig_newactivationemail.tpl" et se situe dans le répertoire "templates" du module.
<h3>Module Adherents et FrontEndUsers (FEU)</h3>
<p>AssoSimple utilise le module FrontEndUsers (module tiers) pour authentifier les personnes. Le module Adherents est ainsi relié à FEU. C\'est pourquoi les manipulations des utilisateurs et groupes doivent se faire depuis le module Adherents.</p>
<h3>Fonctionnement optimal</h3>
<p>AssoSimple est une suite de modules conçue pour fonctionner en relation les uns avec les autres. Pour un fonctionnement optimal, vous devriez installer les autres modules de la suite. Renseignements sur www.agi-webconseil.fr/</p>
<h3>Utilisation des photos</h3>
<p>Créez un répertoire dans l\'arborescence de votre site à l\'emplacement suivant : uploads/images et nommez-le trombines pour obtenir le chemin suivant : uploads/images/trombines.
Collectez les photos de vos membres en cliquant sur le chevron trombines de l\'onglet Adhérents, et choisissez une photo (formats acceptés : jpg, jpeg, png, gif)cela créera une vignette avec le genid du membre.</p>
<h3>Groupe privé</h3>
<p>Constituez des groupes afin d\'affiner votre communication, ces groupes seront repris dans les autres modules de la suite. Le statut privé (ou non) sera utilisé pour un affichage sur le site et pour la communication. En clair, si le groupe est privé, vous ne pourrez pas l\'afficher plus tard sur votre site.
<h3>Groupe(s) public(s)</h3>
<p>Un groupe public est un groupe qui pourra être affiché sur le site grâce au tag pour affichage dans une page de contenu. Cet affichage peut être modifié selon vos besoins depuis la gestion du design, le gabarit est intitulé "Liste Adhérents".</p>
<h3>Groupe(s) commun(s)</h3>
<p>Avec les groupes communs, vous pouvez créer en frontal (côté internaute) des pages de contenu protégé uniquement accessible à ces groupes. Un groupe commun est un groupe où plusieurs membres accède à la même information (après authentification avec FrontEndUsers : FEU).</p>
<p>Pour créer un groupe commun, il suffit de cocher le pour pousser le groupe depuis le module Adherents vers le module d\'authentification (FEU), les membres de ce groupe sont automatiquement poussés également.</p> <h3>Bogues et Github</h3>
<p>Certaines corrections de bogues mineurs ne font pas l\'objet d\'une version officielle mais peuvent toutefois se trouver sur le github dont l\'adresse figure ci-dessous.<br />Il vous suffit alors de télécharger le fichier zip disponible(via le bouton vert "Clone or download") et de le déployer si votre serveur.</p><ul>
<li>Pour obtenir la dernière version en cours (avant release officielle)
<a href="https://github.com/siohan/adherents" target="_blank">Version github</a>.</li>
<li>Enfin, vous pouvez aussi m\'envoyer un mail.</li>  
</ul>
<p>En tant que licence GPL, ce module est livré tel quel. Merci de lire le texte complet de la license pour une information complête.</p>
<h3>Copyright et License</h3>
<p>Copyright &amp;copy; 2014, <a href="mailto:contact@asso-simple.fr">AssoSimple</a>. Tous droits réservés.</p>
<p>Ce module est sous licence <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. Vous devez accepter la licence avant d\'utiliser ce module.</p>
<p>Ce module a été distribué dans l\'espoir d\'être utile, mais sans
AUCUNE GARANTIE. Il vous appartient de le tester avant toute mise en
production, que ce soit dans le cadre d\'une nouvelle installation ou
d\'une mise à jour du module. L\'auteur du module ne pourrait être tenu
pour responsable de tout dysfonctionnement du site provenant de ce
module. Pour plus d\'informations, <a
href=\"http://www.gnu.org/licenses/licenses.html#GPL\" target=\"_blank\">consultez
la licence GNU GPL</a>.</p>
';
$lang['type_liste_adherents'] = "Gabarit pour liste des membres";
$lang['type_Coordonnees'] = 'Coordonnées';
$lang['type_Adherents'] = 'Adhérents';
?>