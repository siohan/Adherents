<h3>Appartenance aux groupes</h3>
<p>Vous pouvez aussi utiliser l'onglet groupes</p>
<div class="pageoverflow">
{$formstart}

{$record_id}


{foreach from=$items key=key item=entry}
<div class="pageoverflow">
    <p class="pageinput"><input type="checkbox"  name="m1_group[{$entry->id_group}]" id="m1_{$entry->id_group}" {if $entry->participe ==1}checked='checked' {/if} value = '1'>{$entry->nom} - {$entry->description}</p>
  </div>
{/foreach}
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
{**}