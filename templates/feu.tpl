<div class="alert alert-info warning">Pour figurer ici, les adhérents doivent avoir une adresse email dans les contacts.</div>
<div>
	<ul>
		<li>{admin_icon icon='import.gif'} : Insére le membre dans l'espace privé (envoi d'un email)</li>
		<li>{admin_icon icon='true.gif'} Membre déjà inséré.</li>
		<li>{admin_icon icon='delete.gif'} Supprime le membre de l'espace privé.</li>
	</ul>
	</div>
{if $itemcount > 0}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>Dernière connexion</th>
			<th>Email</th>
			<th colspan="4">Actions</th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->last_logged}</td>
		<td>{$entry->email}</td>
		<td>{$entry->push_customer} {$entry->delete_user_feu}</td>
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	
{/if}
	
