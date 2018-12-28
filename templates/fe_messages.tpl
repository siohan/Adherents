<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-envelope"></i>
              Ma messagerie interne</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info">{$fe_envoi_message}</p>
{*if $itemcount > 0*}

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
 <thead>
	<tr>
		<th>Expéditeur</th>
		<th>Date</th>
		<th>Sujet</th>
		<th>Lu ?</th>
		<th colspan="2">Action(s)</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id_message}-{$entry->sender}</td>
	<td>{$entry->senddate|date_format:"%d-%m-%Y"}-{$entry->sendtime}</td>
	<td>{$entry->subject}</td>
	<td>{$entry->lu}</td>
	<td>{$entry->view}</td>
	<td>{$entry->delete}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{*/if*}
</div>
</div>
</div>
</div>