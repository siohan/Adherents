<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-check"></i> Présences</h3>		
			<span class="description">Les présences du membre.</span>		
					{if $activation == true}
						{if $autorisation == true}
							{if $itemcount >0}
								{foreach from=$items item=entry}
					  			<p>{$entry->nom}   <a href="{cms_action_url module=Presence  action=assign_user_idoption details='1' genid=$genid id_presence=$entry->id_inscription}">{if $entry->participe == 1}Voir{else}Modifier{/if}</a></p>
 
								{/foreach}							
							{else}<p class="red">{$error_message}</p>{/if}
						{else}<p class="red"><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>{/if}
					{else}<p class="red">Le module Presence n'est pas activé !</p>{/if}
		</nav>
</div>