<div class="pageoptions"><p class="pageoptions">{$mois_precedent}&nbsp;{$mois_suivant} </p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} </p></div>
<h3>Ma situation actuelle : {$sit_mens}</h3>
{if $itemcount > 0}
<h3> Situation officielle du mois de {$mois_choisi}</h3>
<table class="tablesorter table table-bordered" id="tablesorter">
 <thead>
	<tr class="header">
		<th>Joueur</th>
		<th>Points</th>
		<th>Rang National</th>
		<th>Rang nat (Hors étranger)</th>
		<th>Rang reg</th>
		<th>Rang dép</th>
		<th>Prog mois</th>
		<th>Prog an</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass} header">
    <td>{$entry->joueur}</td>
    <td>{$entry->points}</td>
	<td>{$entry->clglob}</td>
	<td>{$entry->clnat}</td>
	<td>{$entry->rangreg}</td>
	<td>{$entry->rangdep}</td>
	<td>{$entry->progmois}</td>
	<td>{$entry->progann}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}