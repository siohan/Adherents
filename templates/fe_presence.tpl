<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-user-check"></i>
              Mes présences</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info">{*$fe_add_cc*}</p>
					{if true == $nb_result}
						{if $itemcount >0}

							<p>Clique  sur les cases correspondantes à tes choix.</p>
								<table class="table table-bordered">
								 <thead>
								  <tr>
									<th>Nom</th>
									<th>Date</th>
									<th>Présent ?</th>
									<th>Action</th>
								  </tr>
								 </thead>
								 <tbody>
								{foreach from=$items item=entry}
								  <tr class="{$entry->rowclass}">
									<td>{$entry->nom}</td>
									<td>{$entry->date_debut|date_format:"%d/%m"}</td>
								    <td>{$entry->present} / {$entry->absent}</td>
									<td>{$entry->delete}</td>
								  </tr>
								{/foreach}
								 </tbody>
								</table>
							{/if}
						{else}
							<p class="alert alert-danger">Vous n'avez pas l'autorisation de voir ce contenu</p>{/if}
					</div>
				</div>
		</div>
</div>