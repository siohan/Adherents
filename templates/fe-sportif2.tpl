<!-- DataTables Example -->
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table-tennis"></i>
              Mes résultats validés (FFTT)</div>
            <div class="card-body">
              <div class="table-responsive">
               	<!-- <p class="alert alert-info"> {$rafraichir}</p> -->
				{if $itemcount >0}
	
			
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
							<td>{$entry->nom}({$entry->advclaof})</td>
		    				<td>{$entry->victoire}</td>	
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