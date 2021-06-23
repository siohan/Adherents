<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-user-friends"></i>
              Mes convocations</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info"><a href="{module_action_url action='fe_compos'}"><= Revenir</a></p>
{if $itemcount >0}

<h3>Mon équipe</h3>
		<table class="table table-bordered">
		 <thead>
		  <tr>
			<th>Equipe </th>		
		  </tr>
		 </thead>
		 <tbody>
		{foreach from=$items item=entry}
		  <tr class="{$entry->rowclass}">
			<td>{$entry->genid}</td>
		  </tr>
		{/foreach}
		 </tbody>
		</table>
{/if}
</div>
</div>
</div>
</div>