<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-chart-area"></i>
              Ma situation actuelle(10 du mois)</div>
            <div class="card-body">
              <div class="table-responsive">
					<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} </p></div>
					<h3>Ma situation actuelle : {$sit_mens}</h3>
					{if $itemcount > 0}
					
				
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
					</div>
					</div>
					</div>
					</div>