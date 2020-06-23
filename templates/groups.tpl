<div class="pageoptions"><p><a href="{module_action_url action='add_edit_group'}">{admin_icon icon='newobject.gif'}Ajouter un groupe</a></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<div class="pageoptions"><p class="information">FEU : groupe présent (ou non) dans le module d'authentification FrontEndUsers (FEU)<br />Cliquez sur les chevrons pour modifier les options de vos groupes.</p></div>
{if $itemcount > 0}

<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
	<tr>
		<th>Id</th>
		<th>Groupe</th>
		<th>Description</th>
		<th>Nb utilisateurs</th>
		<th>Actif ?</th>
		<th>Public ?</th>
		<th>Auto-enregistrement ?</th>
		<th>FEU</th>
		<th colspan="4">Actions</th>
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
	<td>{$entry->feu}</td>
	<td><a href="{cms_action_url action='assign_users' record_id=$entry->id}">{admin_icon icon="groupassign.gif"}</a></td>
	<td><a href="{cms_action_url action='add_edit_group' record_id=$entry->id}">{admin_icon icon="edit.gif"}</a></td>
	<td><a href="{cms_action_url action='view_group_users' group=$entry->id}">{admin_icon icon="view.gif"}</a></td>
	<td><a href="{cms_action_url action='chercher_adherents_spid' obj=delete_group record_id=$entry->id}">{admin_icon icon="delete.gif"}</a></td>
  </tr>
{/foreach}
 </tbody>
</table>

{/if}

