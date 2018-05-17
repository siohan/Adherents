
<p class="info">{$new_command}</p>
{if $itemcount > 0}

<h3>Mes commandes validées</h3>
<table class="table table-bordered pagetable">
 <thead>
	<tr>
		<th>Date</th>
		<th>Fournisseur </th>
		<th>Référence</th>		
		<th>Prix total</th>
		<th>Paiement</th>
		<th>Détails</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->date_created|date_format:"%d-%m-%Y"}</td>
	<td>{$entry->fournisseur}</td>
    <td>{$entry->commande_number}</td>
	<td>{$entry->prix_total}</td>
	<td>{$entry->is_paid}</td>
	<td>{$entry->view}</td>	
  </tr>
{/foreach}
 </tbody>
</table>
<p class="search-button">{if $user_validation ==0}{$validate}{/if}</p>
{/if}

