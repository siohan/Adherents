<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;|&nbsp;{$add_edit_contact}</p></div>


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
	
