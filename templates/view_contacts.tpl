<div class="dashboard-box last">
	<nav class="dashboard-inner cf">
		<h3 class="dashboard-icon"><i class="fa fa-phone"> </i> Contacts</h3>
			<span class="description">Les contacts disponibles pour ce membre.</span><br />
			<a href="{cms_action_url action=add_edit_contact genid=$genid}">Ajouter un contact</a>
	
			{if $itemcount > 0}
				<ul>
				{foreach from=$items item=entry}
	
				  <li>{$entry->contact} {if isset($entry->description)}({$entry->description}){/if} <a href="{cms_action_url action=add_edit_contact genid=$genid record_id=$entry->id}">Modifier</a> - <a href="{cms_action_url action=chercher_adherents_spid obj=delete_contact genid=$genid record_id=$entry->id}">Supp</a></li>
				{/foreach}
				 </ul>	
			{else}<p class="red">Pas de contact pour ce membre !</p>{/if}
		</nav>
</div>