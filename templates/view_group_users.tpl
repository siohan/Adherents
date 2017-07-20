<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;&nbsp;</p></div>
{if $itemcount > 0}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Licence</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>Email enregistré ?</th> 
			<th>Action</th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->licence}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->has_email}</td>
		<td>{$entry->deletefromgroup}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	
{/if}
	
