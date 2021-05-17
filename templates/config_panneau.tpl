{form_start action='admin_panneau_adherent_tab'}

	<legend>Activation des éléments du panneau adhérent</legend>
	<p class="warning">Les modules doivent être installés et activés (voir aide)</p>
		<div class="pageoverflow">
			<p class="pagetext">Factures ? (Pour les cotisations, commandes etc; module Paiements)</p>
			<select name="pann_factures">{cms_yesno selected=$pann_factures}</select>
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
			<p class="pagetext">Pré-inscriptions ? (module Cotisations)</p>
			<select name="pann_adhesions">{cms_yesno selected=$pann_adhesions}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Présences ? (module Presence)</p>
			<select name="pann_presences">{cms_yesno selected=$pann_presences}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Convocations ? (module Compositions)</p>
			<select name="pann_compos">{cms_yesno selected=$pann_compos}</select>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Résultats FFTT ? (module Ping)</p>
			<select name="pann_fftt">{cms_yesno selected=$pann_fftt}</select>
		</div>


	<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<input type="submit" name="submit" value="Envoyer"/>
		</div>
</fieldset>

{form_end}
