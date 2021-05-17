{form_start action='admin_config_tab'}
<fieldset>
	<legend>Configuration principale</legend>
	<p class="pagetext">Alias de la page de contenu du module Adhérents</p>
	<input type="text" name="pageid_subscription" value="{$pageid_subscription}">
	<p class="information">Pour l'activation des membres</p>
<div class="pageoverflow">
	<p class="pagetext">Email du gestionnaire de l'espace privé</p>
	<p class="pageinput"><input type="text" name="admin_email" value="{$admin_email}" size="40" /></p>
</div>
</fieldset>
<fieldset>
<legend>Activation d'un compte</legend>
<div class="pageoverflow">
	<p class="pagetext">Le sujet du mail</p>
	<p class="pageinput"><input type="text" name="email_activation_subject" value="{$email_activation_subject}" size="40" /></p>
</div>
<div class="warning"><p> Le modèle du mail envoyé pour l'activation du compte se trouve dans le répertoire "templates" du module, il s'intitule "orig_activationemailtemplate.tpl" (voir aide sur le module).</p></div>

</fieldset>
<fieldset>
	<legend>Activation des éléments de l'espace privé</legend>
	<p class="warning">Les modules doivent être installés et activés (voir aide)</p>
		
			<p class="pagetext">Messagerie interne ? (module Messages)</p>
			<select name="feu_messages">{cms_yesno selected=$feu_messages}</select>
		
		<div class="pageoverflow">
			<p class="pagetext">Contacts ?</p>
			<select name="feu_contacts">{cms_yesno selected=$feu_contacts}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Factures ? (Pour les cotisations, commandes etc; module Paiements)</p>
			<select name="feu_factures">{cms_yesno selected=$feu_factures}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Commandes ? (module Commandes)</p>
			<select name="feu_commandes">{cms_yesno selected=$feu_commandes}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Inscriptions ? (module Inscriptions)</p>
			<select name="feu_inscriptions">{cms_yesno selected=$feu_inscriptions}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Pré-inscriptions ? (module Cotisations)</p>
			<select name="feu_adhesions">{cms_yesno selected=$feu_adhesions}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Présences ? (module Presence)</p>
			<select name="feu_presences">{cms_yesno selected=$feu_presences}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Convocations ? (module Compositions)</p>
			<select name="feu_compos">{cms_yesno selected=$feu_compos}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Résultats FFTT ? (module Ping)</p>
			<select name="feu_fftt">{cms_yesno selected=$feu_fftt}</select>
		</div>
	</fieldset>
	<fieldset>
		<legend>Activation des éléments du panneau adhérent</legend>
		<p class="warning">Les modules doivent être installés et activés (voir aide)</p>
			<div class="pageoverflow">
				<p class="pagetext">Factures ? (Pour les cotisations, commandes etc; module Paiements)</p>
				<select name="pann_paiements">{cms_yesno selected=$pann_paiements}</select>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">Commandes ? (module Commandes)</p>
				<select name="pann_commandes">{cms_yesno selected=$pann_commandes}</select>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">Inscriptions ? (module Inscriptions)</p>
				<select name="pann_inscriptions">{cms_yesno selected=$pann_inscriptions}</select>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">Cotisations ? (module Cotisations)</p>
				<select name="pann_cotisations">{cms_yesno selected=$pann_cotisations}</select>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">Présences ? (module Presence)</p>
				<select name="pann_presences">{cms_yesno selected=$pann_presences}</select>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">Convocations ? (module Compositions)</p>
				<select name="pann_compos">{cms_yesno selected=$pann_compos}</select>
			</div>
		
</fieldset>
<fieldset>
	<legend>Réglages des paramètres images</legend>

		<p class="warning">Ce sont les photos de vos membres.</p>
		<p class="pagetext">Extensions autorisées</p>
		<input type="text" name="allowed_extensions" value="{$allowed_extensions}"/>
		
		<div class="pageoverflow">
			<p class="pagetext">Poids maximal de l'image (en octets)</p>
			<input type="text" name="max_size" value="{$max_size}"/>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Largeur maximale de l'image</p>
			<input type="text" name="max_width" value="{$max_width}"/>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Hauteur maximale de l'image</p>
			<input type="text" name="max_height" value="{$max_height}"/>
		</div>
</fieldset>

	<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<input type="submit" name="submit" value="Envoyer"/>
		</div>


{form_end}
