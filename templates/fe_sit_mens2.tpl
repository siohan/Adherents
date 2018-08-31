<div class="pageoptions"><p class="pageoptions">{$itemcount2}&nbsp;{$itemsfound2} </p></div>
<h3>Mes situations </h3>
{if $itemcount2 > 0}
<table class="tablesorter table table-bordered" id="tablesorter">
 <thead>
	<tr class="header">
		<th>Mois/an</th>
		<th>Points</th>
		<th>Rang National</th>
		<th>Rang nat (Hors étranger)</th>
		<th>Rang reg</th>
		<th>Rang dép</th>
		<th>Prog mois</th>
		<th>Prog mois (places)</th>
		<th>Prog an</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items2 item=entry}
  <tr class="{$entry->rowclass} header">
    <td>{$entry->date_sit_mens}</td>
	<td>{$entry->apoint}</td>
	<td>{$entry->aclglo}</td>
	<td>{$entry->clnat}</td>
	<td>{$entry->rangreg}</td>
	<td>{$entry->rangdep}</td>
	<td>{$entry->progmois}</td>
	<td>{$entry->progmoisplaces}</td>
	<td>{$entry->progann}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}