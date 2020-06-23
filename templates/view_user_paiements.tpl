<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-euro"></i> Non réglé</h3>	
		<span class="description">Articles non réglés par le membre</span>	
					{if $activation == true}
						{if $autorisation == true}
							{if $itemcount > 0}
								<p>{form_start action='add_total_payment'}
									{foreach from=$items item=entry}
										{if $entry->is_paid == false}
								  
								  			<input type="checkbox" name="ref_action[]" value="{$entry->ref_action}">{$entry->nom}  ({$entry->tarif} €)</li><br />{/if}
									{/foreach}
											<input type="submit" name="submit" value="Marquer comme totalement réglé">
								 {form_end}
								</p>	
							{elseif $itemcount == 0}<p class="green">{$error_message}</p>
							{else}<p class="red">{$error_message}</p>{/if}
								
							{else}<p class="information"><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>{/if}
					{else}
						<p class="information"><strong>Le module Paiements n'est pas activé !</strong></p>{/if}
		</nav>
</div>