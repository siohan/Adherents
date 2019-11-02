<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-users-cog"></i>
              Compo de mon équipe</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info"></p>
{form_start url="1beta23/index.php/mon-compte" extraparms="display=>add_edit_compo"}
<div class="c_full cf">
	<label class="grid_3">Action de référence</label>
	<div class="grid_8">
	<input type="text" name="ref_action" value="{$ref_action}"/>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Equipe</label>
	<div class="grid_8">
	<input type="text" name="ref_equipe" value="{$ref_equipe}"/>
	</div>
</div>
{foreach from=$items key=key item=entry}

	<input type="checkbox" name="genid[{$entry->genid}]" value="{$entry->genid}" {if $entry->participe == "1"}   checked{/if} />  {$entry->joueur}<br />
{/foreach}

<input type="submit" name="submit" value="Envoyer"/>
{form_end}
</div>
</div>
</div>
</div>