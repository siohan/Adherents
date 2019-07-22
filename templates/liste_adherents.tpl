<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}.&nbsp;&nbsp</p></div>
{if $itemcount > 0}

	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Genid</th>
			<th>Nom</th>
			<th>Prénom</th> 
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">	
		<td>{$entry->thumb}	
		<td>{$entry->genid}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>	
{/if}
	
