<p class="info">{$fe_add_cc}</p>
{*if $itemcount > 0*}
<h3>Mes articles en cours</h3>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
 <thead>
	<tr>
		<th>Date</th>
		<th>Article</th>
		<th>Statut</th>
		<th>Prix</th>
		<th>Détails</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->date_created|date_format:"%d-%m-%Y"}</td>
	<td>{$entry->fournisseur}/{$entry->quantite}*{$entry->libelle_commande}/{$entry->ep_manche_taille}/{$entry->couleur}</td>
    <td>{if $entry->statut_commande == '0'}Non envoyé {elseif $entry->statut_commande == '1'}Envoyé{elseif $entry->statut_commande == '2'}Reçu{elseif $entry->statut_commande == '3'}Payé{elseif $entry->statut_commande == '4'}Payée et déstocké{/if}</td>
	<td>{$entry->prix_total}</td>	
	{if $entry->statut_commande < 1}
	<td>{$entry->fe_edit} {$entry->fe_delete} {$entry->fe_confirm}</td>
	{/if}
  </tr>
{/foreach}
 </tbody>
</table>
{*/if*}
