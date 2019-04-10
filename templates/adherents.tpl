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
</script><div class="pageoptions"><p class="pageoptions">{if $alert == "1"}<p class="warning">{$link_alert}</p>{elseif $alert == "2"}<p class="warning">{$link_alert}</p>{/if}{$itemcount}&nbsp;{$itemsfound}.&nbsp;&nbsp;| {$add_users} | {if $act ==0}{$actifs}{else} {$inactifs}{/if} | &nbsp;{$chercher_adherents_spid}</p></div>
{if $itemcount > 0}
{$form2start}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Genid</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>actif</th> 
			<th>Sexe</th> 
			<th>Naissance</th> 
			<th>Adresse</th>
			<th>Code Postal</th> 
			<th>Ville</th>
			<th>Email ?</th>
			<th>Portable ?</th>
			<th colspan="2">Actions</th>
			<th><input type="checkbox" id="selectall" name="selectall"></th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">		
		<td>{$entry->genid}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->actif}</td>
		<td>{$entry->sexe}</td>
		<td>{$entry->anniversaire|date_format:"%d-%m-%Y"}</td>
		<td>{$entry->adresse}</td>
		<td>{$entry->code_postal}</td>
		<td>{$entry->ville}</td>
		<td>{$entry->has_email}</td>
		<td>{$entry->has_mobile}</td>
		<td>{$entry->edit}</td>			
		<td>{$entry->view_contacts}</td>
		<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->genid}" class="select"></td>
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
	
