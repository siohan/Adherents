<!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
              Data Table Example</div>
            <div class="card-body">
              <div class="table-responsive">
                
{if $itemcount >0}
	
	<h3>Mes résultats</h3>
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
</div>
</div>