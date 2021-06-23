<a href="{cms_action_url action='defaultadmin' active_tab=groups}">{admin_icon icon="back.gif"}Revenir</a>
<section class="cf">
	<div id="topcontent_wrap">
		<div class="dashboard-box">					
			<nav class="dashboard-inner cf">
				<h3 class="dashboard-icon"><i class="fa fa-user"></i>En bref</h3>
				<span class="description">Les détails du groupe</span>	
				<p> 
											
						<a href="{cms_action_url action=add_edit_group record_id=$id}">{admin_icon icon="edit.gif"}</a>
				<ul class="subitems">
						<li>Nom du groupe : {$nom}</li>
						<li>Description : {$description}</li>
						<li><a href="{cms_action_url action=add_edit_group  record_id=$id}">Modifier le groupe</a></li>
				</ul>
	
	<!--<p>Auto-enregistrement ? 
		{if $entry2->auto_subscription== '1'}
			<a href="{cms_action_url action=chercher_adherents_spid obj=desactivate_group record_id=$entry2->id}">Désactiver le groupe</a>
		{else}
			<li><a href="{cms_action_url action=chercher_adherents_spid obj=activate_group record_id=$entry2->id}">Activer le groupe</a></li>
		{/if}</ul></p>
	-->
			
		</nav>
	</div>
	<div class="dashboard-box">					
			<nav class="dashboard-inner cf">
				<h3 class="dashboard-icon"><i class="fa fa-user"></i>Actif / Inactif</h3>
				<span class="description">Déterminez si ce groupe doit être actif ou non</span>	
				<p> {if $actif== '1'}
						<a href="{cms_action_url action=chercher_adherents_spid obj=desactivate_group record_id=$id}">{admin_icon icon="true.gif"}</a>
					{else}
						<a href="{cms_action_url action=chercher_adherents_spid obj=activate_group record_id=$id}">{admin_icon icon="false.gif"}</a>{/if}
				<ul class="subitems">
					{if $actif== '1'}
						<li class="green">Le groupe est actif !</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=desactivate_group record_id=$id}">Désactiver le groupe</a></li>
					{else}
						<li class="red">Le groupe est inactif !</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=activate_group record_id=$id}">Activer le groupe</a></li>
					{/if}
				</ul>
			
		</nav>
	</div>
	<div class="dashboard-box last">					
			<nav class="dashboard-inner cf">
				<h3 class="dashboard-icon"><i class="fa fa-user"></i>Public / Non public</h3>
				<span class="description">Déterminez si ce groupe doit être public ou non</span>	
				<p>{if $public== '1'}<a href="{cms_action_url action=chercher_adherents_spid obj=desactivate_group record_id=$entry2->id}">{admin_icon icon="true.gif"}</a>{else}<a href="{cms_action_url action=chercher_adherents_spid obj=activate_group record_id=$entry2->id}">{admin_icon icon="false.gif"}</a>{/if}</p>
				<ul class="subitems">
					{if $public== '1'}
						<li class="green">Le groupe est public !</li>
						<li>Mettez le tag ci-dessous dans une de vos pages pour affichage.</li>
						<li>{$tag}</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=unpublish_group record_id=$id}">Mettre le groupe à non publique</a></li>
					{else}
						<li class="red">Le groupe n'est pas public !</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=publish_group record_id=$id}">Mettre le groupe à publique</a></li>
					{/if}
				</ul>
				</nav>
	</div>
	<div class="dashboard-box ">					
			<nav class="dashboard-inner cf">
				<h3 class="dashboard-icon"><i class="fas fa-user"></i>Auto-enregistrement</h3>
				<span class="description">Les personnes peuvent s'enregistrer elles-mêmes ?</span>	
				<p>{if $tag_subscription != ''}<a href="{cms_action_url action=chercher_adherents_spid obj=ko_auto record_id=$entry2->id}">{admin_icon icon="true.gif"}</a>{else}<a href="{cms_action_url action=chercher_adherents_spid obj=activate_group record_id=$entry2->id}">{admin_icon icon="false.gif"}</a>{/if}</p>
				<ul class="subitems">
					{if $tag_subscription != ''}
						<li class="green">Auto-enregistrement activé</li>
						<li>Mettez le tag ci-dessous dans une de vos pages pour s'enregistrer.</li>
						<li>{$tag_subscription}</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=ko_auto record_id=$id}">Désactiver l'auto-enregistrement</a></li>
					{else}
						<li class="red">Pas d'auto-enregistrement activé</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=ok_auto record_id=$id}">Activer l'auto-enregistrement</a></li>
					{/if}
				</ul>
				</nav>
	</div>
	{if $tag_subscription != ''}<div class="dashboard-box ">					
			<nav class="dashboard-inner cf">
				<h3 class="dashboard-icon"><i class="fas fa-user"></i>Validation par l'admin requise ou non</h3>
				<span class="description"></span>	
				<p>{if $admin_valid == '1'}
						<a href="{cms_action_url action=chercher_adherents_spid obj=admin_valid record_id=$entry2->id valid=0}">{admin_icon icon="true.gif"}</a>
					{else}
						<a href="{cms_action_url action=chercher_adherents_spid obj=admin_valid record_id=$entry2->id valid=1}">{admin_icon icon="false.gif"}</a>
					{/if}
				</p>
				<ul class="subitems">
					{if $admin_valid == '1'}
						<li class="green">Les personnes doivent être validées pour faire partie d'un groupe et récupérer leurs identifiants</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=admin_valid record_id=$id valid=1}">Passer à non requis</a></li>
					{else}
						<li class="red">Validation non requise, les utilisateurs obtiennent leurs identifiants et peuvent aussitôt se connecter</li>
						<li><a href="{cms_action_url action=chercher_adherents_spid obj=admin_valid record_id=$id valid=0}">Passer à requis</a></li>
					{/if}
				</ul>
				</nav>
	</div>{/if}
	</div>
</section>
	
<h3>Les membres du groupe : </h3>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;&nbsp;<a href="{cms_action_url action=assign_users record_id=$id}">{admin_icon icon="groupassign.gif"} Ajouter des utilisateurs</a></p></div>
{if $itemcount > 0}
{*$form2start*}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>Actif ?</th>
			<th>Email ?</th> 
			<th>Portable ?</th> 
			<th>Action</th>
	<!--		<th><input type="checkbox" id="selectall" name="selectall"></th>-->
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->genid}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->actif}</td>
		<td>{$entry->has_email}</td>
		<td>{$entry->has_mobile}</td>
		<td>{$entry->deletefromgroup}</td>
<!--		<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->genid}" class="select"></td>-->
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	<!-- SELECT DROPDOWN -->
<!--	
	<div class="pageoptions" style="float: right;">
	<br/>{$actiondemasse}{$submit_massaction}
	  </div>-->
	{*$form2end*}	
{/if}

