<h3>Ajout/mofification des membres du groupe</h3>
<div class="pageoverflow">
{$formstart}

{$record_id}

{foreach from=$items key=key item=entry}
<div class="pageoverflow">
    <p class="pageinput"><input type="checkbox"  name="{$actionid}licence[{$entry->genid}]"  {if $entry->participe ==1}checked='checked' {/if} value = '1'>{$entry->joueur}</p>
  </div>
{/foreach}
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
{**}