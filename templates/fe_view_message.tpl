<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-envelope-open"></i>
              Mon message</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info">{*$fe_add_cc*}</p>
{*if $itemcount > 0*}

<table class="table table-bordered" width="100%" cellspacing="0">
 <thead>
	<tr>
		<th>Message</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->message}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{*/if*}
</div>
</div>
</div>
</div>