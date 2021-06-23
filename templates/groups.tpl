<div class="pageoptions"><p><a href="{module_action_url action='add_edit_group'}">{admin_icon icon='newobject.gif'}Ajouter un groupe</a></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<!--<div class="pageoptions"><p class="information">Cliquez sur les chevrons pour modifier les options de vos groupes.</p></div>-->
{if $itemcount > 0}

<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
	<tr>
		
		<th>Groupe</th>
		<th>Description</th>
		<th>Utilisateurs</th>
		<!--<th>Actif ?</th>
		<th>Public ?</th>
		<th>Auto-enregistrement ?</th>-->
		<th colspan="2">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	
	<td><a href="{cms_action_url action='view_group_details' group=$entry->id}">{$entry->nom}</a></td>
	<td>{$entry->description}</td>
	<td>{$entry->nb_users}</td>
	<!--<td>{$entry->actif}</td>
	<td>{$entry->public}</td>
	<td>{$entry->auto_subscription}</td>
	<td><a href="{cms_action_url action='assign_users' record_id=$entry->id }">{admin_icon icon="groupassign.gif"}</a></td>
	<td><a href="{cms_action_url action='add_edit_group' record_id=$entry->id}">{admin_icon icon="edit.gif"}</a>-->
	<td><a href="{cms_action_url action='view_group_details' group=$entry->id}">{admin_icon icon="view.gif"}</a>
	<td><a href="{cms_action_url action='misc_actions' obj=delete_group record_id=$entry->id}">{admin_icon icon="delete.gif"}</a>
  </tr>
{/foreach}
 </tbody>
</table>

{/if}

