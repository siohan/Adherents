<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-check"></i> Présences</h3>		
			<span class="description">Les présences du membre.</span>		
					{if $activation == true}
						{if $autorisation == true}
							{if $itemcount >0}
								{foreach from=$items item=entry}
					  			{if $entry->user_choice == "3"}<p class="red">{$entry->nom} :  Pas de réponse {elseif $entry->user_choice == "1"}<p class="green">{$entry->nom} : Présent {else}<p class="red">{$entry->nom} : Absent{/if} <a href="{cms_action_url action='pres_user_reponse' genid=$genid id_presence=$entry->id_presence}">Voir</a></p>
 
								{/foreach}							
							{elseif $itemcount == 0}<p class="green">{$error_message}</p>
							{else}<p class="red">{$error_message}</p>{/if}
						{else}<p class="red"><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>{/if}
					{else}<p class="red">Le module Presence n'est pas activé !</p>{/if}
		</nav>
</div>