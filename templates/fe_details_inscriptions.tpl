<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-user-check"></i>
              Mes inscriptions</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info">{$fe_add_cc}</p>
{if $itemcount >0}

<h3></h3>
		<table class="table table-bordered">
		 <thead>
		  <tr>
			<th>Nom</th>
			<th>Date</th>
			<th>Inscrit ?</th>
		
		  </tr>
		 </thead>
		 <tbody>
		{foreach from=$items item=entry}
		  <tr class="{$entry->rowclass}">
			<td>{$entry->nom}</td>
			<td>{$entry->date_debut|date_format:"%d/%m"}</td>
		    <td>{$entry->is_inscrit}</td>	
			<td>{$entry->details} {$entry->delete}</td>
		  </tr>
		{/foreach}
		 </tbody>
		</table>
{/if}
</div>
</div>
</div>
</div>