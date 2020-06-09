<pre>{}</pre><div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-user-check"></i>
              Mes inscriptions</div>
            <div class="card-body">
              <div class="table-responsive">
					{if true == $nb_results}
						{if $itemcount >0}

						
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
								    <td>{if true == $entry->is_inscrit}</td>	
									<td><a href="{cms_action_url action='fe_details_inscription' affichage=1 record_id={$entry->id_inscription}}">M'inscrire</a></td>{else}</td><td><a href="{cms_action_url action='fe_details_inscription' affichage=0 record_id={$entry->id_inscription}}">Détails</a></td>{/if}
								  </tr>
								{/foreach}
								 </tbody>
								</table>
							{/if}
					{else}
						<p class="alert alert-danger">Vous n'avez pas l'autorisation de voir ce contenu</p>
					{/if}
			</div>
		</div>
	</div>
</div>