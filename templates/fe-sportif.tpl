<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount >0}
	
	<h3>Mes résultats</h3>
		<table class="table table-bordered">
		 <thead>
		  <tr>
			<th>Date</th>
			<th>Epreuve</th>
			<th>Adv</th>
			<th>Vic/Def</th>
			
			<th>Pts</th>
		  </tr>
		 </thead>
		 <tbody>
		{foreach from=$items item=entry}
		  <tr class="{$entry->rowclass}">
			<td>{$entry->date_event|date_format:"%d/%m"}</td>
			<td>{$entry->epreuve}</td>
			<td>{$entry->nom}({$entry->classement})</td>
		    <td>{$entry->victoire}</td>		
		  </tr>
		{/foreach}
		 </tbody>
		</table>
	
{else}
			<p>Aucun résultat</p>
{/if}
