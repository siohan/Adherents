<!-- DataTables Example -->
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-chart-line"></i>
              Mes résultats virtuels (Estimation)</div>
            <div class="card-body">
              <div class="table-responsive">
				<p class="alert alert-info"> {$rafraichir}</p>

				{if $itemcount >0}

						<table  class="table table-bordered">
						 <thead>
						  <tr>
							<th>Date</th>
							<th>Epreuve</th>
							<th>Adv</th>
							<th>Vic/Def</th>
							<th>Coeff</th>
							<th>Pts</th>
						  </tr>
						 </thead>
						 <tbody>
						{foreach from=$items item=entry}
						  <tr class="{$entry->rowclass}">
						    <td>{$entry->date_event|date_format:"%d/%m"}</td>
							<td>{$entry->epreuve}</td>
						    <td class="name">{$entry->nom}({$entry->classement})</td>
							<td>{$entry->victoire}</td>
							<td>{$entry->coeff}</td>
							<td>{$entry->pointres}</td>
						  </tr>
						{/foreach}
						 </tbody>
						</table>	
				{else}
							<p>Aucun résultat</p>
				{/if}
	</div>
</div>
</div>
</div>