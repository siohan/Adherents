{if isset($validation)}
 {if $success=='true'}<div class="alert alert-success">{else}<div class="alert alert-danger">{/if}{$final_msg}{cms_selflink page="mon-compte" text="Revenir à mon compte"}
{*redirect_page page='mon-compte'*}
{else}
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-users-cog"></i>
              Mes infos persos</div>
            <div class="card-body">
              <div class="table-responsive"><p class="info"></p>

					{form_start action=fe_edit_adherent}
					<input class="form-control" type="hidden" name="genid" value="{$genid}"/>
					<div class="form-group">
					    <label for="anniversaire">Anniversaire</label>
						<input class="form-control" type="date" name="anniversaire" value="{$anniversaire}" />
					</div>
					<div class="form-group">
					    <label for="adresse">Adresse</label>
						<input class="form-control" type="text" name="adresse" value="{$adresse}" />
					</div>
					<div class="form-group">
					    <label for="adresse">Code postal</label>
						<input class="form-control" type="text" name="code_postal" value="{$code_postal}" />
					</div>
					<div class="form-group">
					    <label for="adresse">Ville </label>
						<input class="form-control" type="text" name="ville" value="{$ville}" />
					</div>
					<button type="submit" name="submit" value="Envoyer" class="btn btn-primary">Envoyer</button>
					<button type="submit" name="cancel" value = "Annuler" class="btn btn-warning">Annuler</button>

					{form_end}
</div>
</div>
</div>
</div>
{/if}