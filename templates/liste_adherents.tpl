<h3>{$nom_liste} : La liste</h3>

	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Trombine</th>
			<th>Nom</th>
			<th>Prénom</th> 
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">	
		<td>{$entry->thumb}	
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>	

	
