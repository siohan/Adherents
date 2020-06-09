{*<a href="{cms_action_url action=check_emails}">Vérifier les emails</a>*}
{form_start action=admin_emails_tab}
<div class="pageoverflow">
	<p class="pagetext">Email du gestionnaire de l'espace privé</p>
	<p class="pageinput"><input type="text" name="admin_email" value="{$admin_email}" /></p>
</div>
<fieldset>
<legend>Activation d'un compte</legend>
<div class="pageoverflow">
	<p class="pagetext">Le sujet du mail</p>
	<p class="pageinput"><input type="text" name="email_activation_subject" value="{$email_activation_subject}" /></p>
</div>
<div class="warning"><p> Le modèle du mail envoyé pour l'activation du compte se trouve dans le répertoire "templates" du module, il s'intitule "orig_activationemailtemplate.tpl" (voir aide sur le module).</p></div>

</fieldset>
<input type="submit" name="submit" value="Envoyer">
{form_end}