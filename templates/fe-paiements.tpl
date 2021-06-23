<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-euro-sign"></i>
              Mes factures</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info">{$fe_add_cc}</p>

					{if $itemcount > 0}

					<table cellpadding="0" class="table  table-bordered" id="datatable" width="100%" cellspacing="0">
					 <thead>
						<tr>
							<!--<th>Date</th>-->
							<th>Date</th>
							<th>Libellé</th>
							<th>Référence interne</th>
							<th>Tarif</th>
							<th>Restant</th>
							<th>Réglé ?</th>
						<!--	<th>Action(s)</th>-->
						</tr>
					 </thead>
					 <tbody>
					{foreach from=$items item=entry}
					  <tr class="{$entry->rowclass}">
						<td>{$entry->date_created|date_format:"%d-%m-%Y"}</td>
						<td> {$entry->nom}</td>
						<td>{$entry->ref_action}</td>
						<td>{$entry->tarif}</td>
						<td>{$entry->restant_du}</td>
						<td>{$entry->statut}</td>
						<!--
						<td>{if $entry->module =='Cotisations'}<a href="{root_url}/admin/moduleinterface.php?mact=Cotisations,m1_,view_adherent_cotis,0&amp;m1_licence={$entry->licence}&amp;_sk_={$smarty.cookies._sk_}">{$details_facture}</a>{elseif $entry->module =='Commandes'}<a href="{root_url}/admin/moduleinterface.php?mact=Commandes,m1_,view_cc,0&amp;m1_commande_number={$entry->ref_action}&amp;_sk_={$smarty.cookies._sk_}">{$details_facture}</a>{/if} {$entry->editlink} {$entry->view_reglement} {$entry->add_reglement} {$entry->relance} {*$entry->delete*}</td>-->
					  </tr>
					{/foreach}
					 </tbody>
					</table>

					{/if}
					</div>
				</div>
			</div>
		</div>
