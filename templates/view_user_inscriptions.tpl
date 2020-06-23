<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-user-plus"></i> Inscriptions</h3>		
			<span class="description">Les inscriptions du membre.</span>		
					{if $activation == true}
						{if $autorisation == true}
							{if $itemcount >0}
								{foreach from=$items item=entry}
					  			<p>{$entry->nom}   <a href="{cms_action_url module=Inscriptions  action=assign_user_idoption details='1' genid=$genid id_inscription=$entry->id_inscription}">{if $entry->participe == 1}Voir{else}Modifier{/if}</a></p>
 
								{/foreach}							
							{elseif $itemcount == 0}<p class="green">{$error_message}</p>
							{else}<p class="red">{$error_message}</p>{/if}
						{else}<p class="red"><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>{/if}
					{else}<p class="red">Le module Cotisations n'est pas activé !<:p>{/if}
		</nav>
</div>