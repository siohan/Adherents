{form_start action='admin_config_espace_tab'}

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


	<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<input type="submit" name="submit" value="Envoyer"/>
		</div>
</fieldset>

{form_end}
