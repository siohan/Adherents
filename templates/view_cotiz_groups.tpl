<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-euro"></i> Type de cotisations</h3>		
			<span class="description">Les cotisations auxquelles le membre adhère.</span>		
			{if $activation == true}
						{if $autorisation == true}
							{form_start module=Adherents action=do_assign_cotiz}
								<input type="hidden" name="genid" value="{$genid}">
								{for $foo=1 to $compteur}
					  			<p><input type="checkbox"  name="group[]" id="{$actionid}{$entry->id_group}" {if true == $check_{$foo}}checked='checked' {/if} value="{$id_group_{$foo}}" {if true == $unremovable_{$foo}}disabled="disabled"{/if}>{$nom_gp_{$foo}}</p>{if true == $unremovable_{$foo}}<input type="hidden" name="group[]" value="{$id_group_{$foo}}">{/if}
 
								{/for}
						
								<input type="submit" name="submit" value="Envoyer">
								<input type="submit" name="cancel" value="Annuler">
							{form_end}
							<p class="information">Les cotisations payées tout ou partie ne sont plus modifiables que ds le module Paiements</p>
							{else}<p class="red"><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>{/if}
					{else}<p class="red">Le module Cotisations n'est pas activé !</p>{/if}
		</nav>
</div>