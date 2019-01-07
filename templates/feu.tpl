<p>Pour figurer ici, les adhérents doivent avoir une adresse email dans les contacts.</p>
{if $itemcount > 0}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>Dernière connexion</th>
			<th>Email</th>
			<th colspan="4">Actions</th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->last_logged}</td>
		<td>{$entry->email}</td>
		<td>{$entry->push_customer} {$entry->delete_user_feu}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	
{/if}
	
