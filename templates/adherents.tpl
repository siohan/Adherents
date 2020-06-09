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
$('#filter_btn').click(function(){
      $('#filter_zone').toggle();
});
//]]>
</script>

<fieldset id="filter_zone"><!-- style="display: none;"> -->
   <legend>Filtre</legend>
   {form_start}
   <div class="c_full cf">
       <label class="grid_2" for="filter_title">Groupe(s)</label>
       <select class="grid_4" id="filter_group"  name="record_id">{html_options options=$liste_groupes selected=$group}</select>
   
      <input type="submit" name="filter_submit" class="grid_2" value="{$mod->Lang('submit')}"/>
   </div>
   {form_end}
</fieldset>
<div class="pageoptions"><p class="pageoptions">{if $alert == "1"}<p class="warning">{$link_alert}</p>{elseif $alert == "2"}<p class="warning">{$link_alert}</p>{/if}{$itemcount}&nbsp;{$itemsfound}.&nbsp;&nbsp;| <a href="{module_action_url action=edit_adherent}">{admin_icon icon='newobject.gif'}Ajouter</a> | {if $act ==0}<a href="{module_action_url action=defaultadmin actif=1}">Actifs</a>{else} <a href="{module_action_url action=defaultadmin actif=0}">Inactifs</a>{/if} </p></div>
<p class="information">FEU : présent(ou non) dans le module d'authentification (voir aide sur le module)</p>
{if $itemcount > 0}
{$form2start}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Genid</th>
			<th>Trombine</th>
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
			<th>FEU ?</th>
			<th><input type="checkbox" id="selectall" name="selectall"></th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	{if $entry->activated =="0"}
	  <tr style="background:#DCDCDC;">
	{else}
	 <tr>
	{/if}		
		<td>{$entry->gen}</td>
		<td>{$entry->thumbnail}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->actif}</td>
		<td>{$entry->sexe}</td>
		<td>{if $entry->anniversaire !=''}{$entry->anniversaire|date_format:"%d-%m-%Y"}{/if}</td>
		<td>{$entry->adresse}</td>
		<td>{$entry->code_postal}</td>
		<td>{$entry->ville}</td>
		<td>{$entry->has_email}</td>
		<td>{$entry->has_mobile}</td>
		<td>{$entry->has_feu_account}</td>
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
	
