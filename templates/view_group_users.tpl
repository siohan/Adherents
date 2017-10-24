<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
  $('#selectall').click(function(){
    var v = $(this).attr('checked');
    if( v == 'checked' ) {
      $('.select').attr('checked','checked');
    } else {
      $('.select').removeAttr('checked');
    }
  });
  $('.select').click(function(){
    $('#selectall').removeAttr('checked');
  });
  $('#toggle_filter').click(function(){
    $('#filter_form').toggle();
  });
  {if isset($tablesorter)}
  $('#articlelist').tablesorter({ sortList:{$tablesorter} });
  {/if}
});
//]]>
</script><div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;&nbsp;</p></div>
{if $itemcount > 0}
{$form2start}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Licence</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>Email enregistré ?</th> 
			<th>Action</th>
			<th><input type="checkbox" id="selectall" name="selectall"></th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->licence}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->has_email}</td>
		<td>{$entry->deletefromgroup}</td>
		<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->licence}" class="select"></td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	<!-- SELECT DROPDOWN -->
	<div class="pageoptions" style="float: right;">
	<br/>{$actiondemasse}{$submit_massaction}
	  </div>
	{$form2end}	
{/if}
	
