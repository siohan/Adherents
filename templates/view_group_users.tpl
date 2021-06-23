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
</script>
<h3>{$nom_groupe} : Les membres du groupe</h3>

<br /><a href="{cms_action_url action='defaultadmin' active_tab=groups}">{admin_icon icon="back.gif"}Revenir</a>

<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;&nbsp;</p></div>
{if $itemcount > 0}
{*$form2start*}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>Actif ?</th>
			<th>Email ?</th> 
			<th>Portable ?</th> 
			<th>Action</th>
	<!--		<th><input type="checkbox" id="selectall" name="selectall"></th>-->
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->genid}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->actif}</td>
		<td>{$entry->has_email}</td>
		<td>{$entry->has_mobile}</td>
		<td>{$entry->deletefromgroup}</td>
<!--		<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->genid}" class="select"></td>-->
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	<!-- SELECT DROPDOWN -->
<!--	
	<div class="pageoptions" style="float: right;">
	<br/>{$actiondemasse}{$submit_massaction}
	  </div>-->
	{*$form2end*}	
{/if}
	
