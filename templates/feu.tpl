<p>Pour figurer ici, les adhérents doivent avoir une adresse email dans les contacts.</p>
{if $itemcount > 0}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Licence</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>Email</th>
			<th colspan="4">Actions</th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->licence}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->email}</td>
		<td>{$entry->push_customer} {$entry->send_another_email}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	
{/if}
	
