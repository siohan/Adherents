<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;&nbsp;</p></div>
{if $itemcount > 0}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Licence</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>actif</th> 
			<th>Sexe</th> 
			<th>Certif(date)</th> 
			<th>Points</th> 
			<th>Cat</th> 
			<th>Adresse</th>
			<th>Code Postal</th>
			<th>Ville</th>
			<th colspan="4">Actions</th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->licence}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->actif}</td>
		<td>{$entry->sexe}</td>
		<td>{$entry->certif}({$entry->date_validation|date_format:"%d-%m-%Y"})</td>
		<td>{$entry->points}</td>
		<td>{$entry->cat}</td>
		<td>{$entry->adresse}</td>
		<td>{$entry->code_postal}</td>
		<td>{$entry->ville}</td>
		<td>{$entry->refresh}</td>
		<td>{$entry->edit}</td>
		<td><a href="{root_url}/admin/moduleinterface.php?mact=Commandes,m1_,view_client_orders,0&amp;m1_licence={$entry->licence}&amp;_sk_={$smarty.cookies._sk_}">{$shopping}</a></td>
		<td>{$entry->view_contacts}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	
{/if}
	
