<div class="pageoptions"><p><a href="{module_action_url action='add_edit_group'}">{admin_icon icon='newobject.gif'}Ajouter un groupe</a></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<div class="pageoptions"><p class="information">Cliquez sur les chevrons pour modifier les options de vos groupes.</p></div>
{if $itemcount > 0}

<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
	<tr>
		<th>Id</th>
		<th>Groupe</th>
		<th>Description</th>
		<th>Utilisateurs</th>
		<th>Actif ?</th>
		<th>Public ?</th>
		<th>Auto-enregistrement ?</th>
		<th colspan="3">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td>{$entry->nom}</td>
	<td>{$entry->description}</td>
	<td>{$entry->nb_users}</td>
	<td>{$entry->actif}</td>
	<td>{$entry->public}</td>
	<td>{$entry->auto_subscription}</td>
	<td><a href="{cms_action_url action='assign_users' record_id=$entry->id }">{admin_icon icon="newobject.gif"}</a></td>
	<td><a href="{cms_action_url action='add_edit_group' record_id=$entry->id}">{admin_icon icon="edit.gif"}</a>
	<td><a href="{cms_action_url action='view_group_users' group=$entry->id}">{admin_icon icon="view.gif"}</a>
  </tr>
{/foreach}
 </tbody>
</table>

{/if}

