<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-user"></i>
              Mes infos persos</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info">Les infos recueillies sont strictement à usage interne.</p>
{*if $itemcount > 0*}

<table class="table table-bordered" width="100%" cellspacing="0">
 <thead>
	<tr>
		<th>Naissance</th>
		<th>Adresse</th>
		<th>Code postal</th>
		<th>Ville</th>
		<th>Action(s)</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->anniversaire|date_format:"%d-%m-%Y"}</td>
	<td>{$entry->adresse}</td>
	<td>{$entry->code_postal}</td>
	<td>{$entry->ville}</td>
	<td>{$fe_edit}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{*/if*}
</div>
</div>
</div>
</div>

