<div class="pageoptions"><p class="pageoptions"><a href="{cms_action_url action="defaultadmin"}">{admin_icon icon="back.gif"} Retour</a></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;|&nbsp;<a  href="{cms_action_url action="add_edit_contact" genid=$genid}">{admin_icon icon="newobject.gif"} Nouveau contact</a></p></div>
{if $itemcount > 0}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Type</th>
			<th>Contact</th>
			<th>Description</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	
	  <tr class="{$entry->rowclass}">
		<td>{$entry->type_contact}</td>
		<td>{$entry->contact}</td>
		<td>{$entry->description}</td>
		<td>{$entry->edit}</td>
		<td>{$entry->delete}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	
{/if}
	
