
<p>{$rafraichir}</p>
{if $affiche=='1'}
<h3>Résumé de mes résultats : </h3>
<p>{$phase1} | {$phase2}</p>
<table class="table table-responsive table-bordered">
 <tbody>
	<thead>
		<tr>
			<th>Vic</th>
			<th>Total</th>
			<th>Pts</th>
		</tr>
	</thead>
 </tbody>
{foreach from=$items1 item=entree}
  <tr class="{$entree->rowclass}">
    <td>{$entree->vic}</td>
	<td>{$entree->total}</td>
	<td>{$entree->pts}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
{if $itemcount >0}
	{if $affiche=='0'}
<h3>Résumé de mes résultats du mois précédent</h3>
		<table class="table table-bordered">
		 <thead>
		  <tr>
			<th>Date</th>
			<th>Adv</th>
			<th>Vic/Def</th>
			<th>Pts</th>
		  </tr>
		 </thead>
		 <tbody>
		{foreach from=$items item=entry}
		  <tr class="{$entry->rowclass}">
			<td>{$entry->date_event|date_format:"%d/%m"}</td>
			<td>{$entry->advnompre}({$entry->advclaof})</td>
		    <td>{$entry->vd}</td>		
			<td>{$entry->pointres}</td>
		  </tr>
		{/foreach}
		 </tbody>
		</table>
	<p>{$resultats}</p>
	{else}
		<h3>Le détail de mes résultats officiels</h3>
		<table  class="table table-bordered">
		 <thead>
		  <tr>
			<th>Date</th>
			<th>Adv</th>
			<th>Vic/Def</th>
			<th>Pts</th>
		  </tr>
		 </thead>
		 <tbody>
		{foreach from=$items item=entry}
		  <tr class="{$entry->rowclass}">
		    <td>{$entry->date_event|date_format:"%d/%m"}</td>
		    <td class="name">{$entry->advnompre}({$entry->advclaof})</td>
			<td>{$entry->vd}</td>
			<td>{$entry->pointres}</td>
		  </tr>
		{/foreach}
		 </tbody>
		</table>
	{/if}	
{else}
			<p>Aucun résultat</p>
{/if}
	
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
