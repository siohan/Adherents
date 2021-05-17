<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon ecommerce">Commandes</h3>	
		<span class="description">Etat des commandes de ce membre</span>	
					{if $activation == true}
						{if $autorisation == true}
							<p><a href="{cms_action_url module=Commandes action=add_edit_cc_item genid=$genid}">Ajouter un article</a></p>
							{if $itemcount > 0}
								<ul>
								{foreach from=$items item=entry}

								  <li>{$entry->nb} article(s) {$entry->statut}</li>
								{/foreach}
								 </ul>	
								<p><a href="{cms_action_url module=Commandes action=view_client_orders record_id=$genid}">Voir tous les articles</a></p>
							{/if}
								
							{else}<p><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>{/if}
					{else}<p><strong>Le module Commandes n'est pas activé !</strong></p>{/if}
		</nav>
</div>