{if $itemcount > 0}
<h3>Mes infos persos</h3>
<table class="table table-bordered pagetable">
 <thead>
	<tr>
		<th>Date Naissance</th>
		<th>Adresse</th>
		<th>Code postal</th>
		<th>Ville</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->anniversaire|date_format:"%d-%m-%Y"}</td>
	<td>{$entry->adresse}</td>
    <td>{$entry->code_postal}</td>
	<td>{$entry->ville}</td>	

	<td>{$entry->fe_edit} {$entry->fe_delete} {$entry->fe_confirm}</td>

  </tr>
{/foreach}
 </tbody>
</table>
{/if}
{if isset($url_logout)}
<p><a href="{$url_logout}" title="{$mod->Lang('info_logout')}">{$mod->Lang('logout')}</a></p>
{/if}
