<div class="pageoptions"><p><a href="{module_action_url action='add°edit_group'}">{admin_icon icon='newobject'}Ajouter un groupe</a></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

{if $itemcount > 0}

<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
	<tr>
		<th>Id</th>
		<th>Groupe</th>
		<th>Description</th>
		<th>Nb utilisateurs</th>
		<th>Actif ?</th>
		<th>Gp public ?</th>
		<th colspan="5">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td> {$entry->nom}</td>
	<td>{$entry->description}</td>
	<td>{$entry->nb_users}</td>
	<td>{$entry->actif}</td>
	<td>{$entry->public}</td>
	<td>{$entry->send_emails}</td>
	<td>{$entry->send_sms}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->delete}</td>
	<td>{$entry->add_users}</td>
  </tr>
{/foreach}
 </tbody>
</table>

{/if}

