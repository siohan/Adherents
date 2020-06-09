<div class="dashboard-box">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-users"> </i> Appartenance aux groupes</h3>
			<span class="description">Les groupes auxquels le membre appartient.</span>

					{form_start action='do_assign_groups'}
						<input type="hidden" name="genid" value="{$genid}">
						{for $foo=1 to $compteur}
							<p><input type="checkbox"  name="group[]" id="{$actionid}{$entry->id_group}" {if true == $check_{$foo}}checked='checked' {/if} value= {$id_group_{$foo}}>{$nom_gp_{$foo}}</p>
 
						{/for}
						
					<input type="submit" name="submit" value="Envoyer">
					<input type="submit" name="cancel" value="Annuler">
					{form_end}
		</nav>
</div>