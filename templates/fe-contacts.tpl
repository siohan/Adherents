<!-- DataTables Example -->
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-user-plus"></i>
              Mes contacts</div>
            <div class="card-body">
              <div class="table-responsive"><p><a role="button" class="btn btn-primary" href="{cms_action_url action='fe_add_edit_contact' genid=$genid}">Ajouter un contact</a></p>


					{if $itemcount > 0}
					<div class="table-responsive">
						<table class="table table-bordered tablesorter">
						 <thead>
							<tr>
								<th>Type</th>
								<th>Contact</th>
								<th>Description</th>
								<th colspan="2">Action</th>
							</tr>
						</thead>
						 <tbody>
						{foreach from=$items item=entry}
	
						  <tr class="{$entry->rowclass}">
							<td>{$entry->type_contact}</td>
							<td>{$entry->contact}</td>
							<td>{$entry->description}</td>
							<td>{$entry->edit}</td>
							<td>{$entry->delete}</td>
						   </tr>
						{/foreach}
						 </tbody>
						</table>
					</div>	
					{/if}
					</div>
				</div>
				</div>
				</div>
