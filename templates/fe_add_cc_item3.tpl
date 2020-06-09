{if (isset($validation))}
<div class="alert alert-success">Article ajouté !{cms_selflink page='mon-compte' text="Revenir à mon compte"}</div>
{else}
<!-- DataTables Example -->
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-cart-arrow-down"></i>
              Commander un article</div>
            <div class="card-body">
              <div class="table-responsive">
						{form_start action=fe_add_cc_items}
						
						<input type="hidden" name="produit_id" value="{$produit_id}" />
						<div class="alert alert-primary" role="alert">Il manque un article ?<a href="{cms_action_url action=fe_add_item record_id=$username}"> Ajoutez-le ici!</a></div>
						<input type="hidden" name="record_id" value="{$record_id}" />
						<input type="hidden" name="date_created" value="{$date_created}" />
						<div class="form-group">
						  <label for"fournisseur">Article :</label>
						<select class="form-control" name="fournisseur">{html_options options=$liste_items selected=$produit_final}</select>
						</div>
						
						<input type="hidden" name="edit" value="{$edit}" />
						<div class="form-group">
						  <label for"ep_manche_taille">Epaisseur Manche Taille:{*cms_help key='help_ep_manche_taille'*}</label>
						  <input type="text" class="form-control" name="ep_manche_taille" value="{$ep_manche_taille}" />
						</div>
						<div class="form-group">
						  <label for="couleur">Couleur:</p>
						  <input type="text" class="form-control" name="couleur" value="{$couleur}" /></p>
						</div>
						<div class="form-group">
							<label for="quantite">Quantité :</label>
							<input type="text" class="form-control" name="quantite" value="{$quantite}" /></p>
						</div>
						<button class=" btn btn-primary" type="submit" name="submit" value="Envoyer">Envoyer</button>
						<button class=" btn btn-primary" type="submit" name="cancel" value="Annuler">Annuler</button>
						  </div>
						{form_end}
						</div>
					</div>
				</div>
			</div>
{/if}