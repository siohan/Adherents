{if isset($validation)}

<div class="alert alert-success">Votre inscription a été prise en compte ! {cms_selflink page='mon-compte' text="Revenir à votre compte"}</div>
{redirect_url url=$url_redir}{*redirect_page page='mon-compte'*}
{else}<!-- DataTables Example -->
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-question"></i>
              Faire mes choix</div>
            <div class="card-body">
              <div class="table-responsive">
						
						{form_start action=fe_edit_inscription}
						<input type="hidden" name="compteur" value="{$compteur}" />
						<input type="hidden" name="choix_multi" value="{$choix_multi}" />
						<input type="hidden" name="id_inscription" value="{$id_inscription}" />
						
						<input type="hidden" name="genid" value="{$genid}" />
						<input type="hidden" name="iteration" value="{$iteration}">
						
						
							{if $choix_multi == true}
								
									{for $foo=1 to $iteration}
										<div class="form-check">
						  					<input class="form-check-input" type="checkbox" name="nom" value="{$it_{$foo}}" {if $inscrit_{$foo}== true} checked{/if}><label>{$nom_{$foo}}</label>
										</div>
									{/for}
								
							{else}
								<h3>Mon choix</h3>
									
									{for $foo=1 to $iteration}
									<div class="form-check">
										<input class="form-check-input" type="radio" name="nom" value="{$it_{$foo}}" {if $inscrit_{$foo}== true} checked{/if}>
										<label class="form-check-label">{$nom_{$foo}}</label>
									</div>
									{/for}	
								</div>						
							{/if}
						
						
						
						    <button type="submit" name="submit" value="Envoyer" class=" btn btn-primary">Envoyer</button>
						<button type="submit" name="submit" value="Annuler" class=" btn btn-primary">Annuler</button>
						  </div>
						{form_end}
						</div>
					</div>
				</div>
			</div>
{/if}