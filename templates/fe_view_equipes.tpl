<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-users-cog"></i>
              Compo de mon équipe</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info"></p>
{if $itemcount > 0}
<h3>{$epreuve}</h3>
<p class="warning">{$message}</p>
<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
 </thead>
 <tbody>

  <tr>
	{foreach from=$items item=entry}
	<td {if $entry->class == 1}style="background-color:green"{/if}> {$entry->equipe}</td>
	{/foreach}	
  </tr>

 </tbody>
</table>

{/if}
{if $itemcount2 > 0}

<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
 </thead>
 <tbody>
{foreach from=$items2 item=entry}
  <tr>
	<td> {$entry->licence}</td>
  </tr>
	{/foreach}
 </tbody>
</table>
{$delete}    {$modifier}    {$lock}    {$emailing}
{else}
{$ajouter}
{/if}
</div>
</div>
</div>
</div>

