{if isset($validation)}
{redirect_page page='mon-compte'}
{else}
<!-- DataTables Example -->
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-plus"></i>
              Ajouter un article manquant dans la liste</div>
            <div class="card-body">
              <div class="table-responsive">
	<p class="alert alert-info"> Les champs marqués d'un astérisque sont obligatoires.</p>
					{form_start action=fe_add_item}
					<input type="hidden" name="record_id" value="{$record_id}" />
					 <div  class="form-group">
						<label for="categorie">Catégorie : * </label>
					  	<select class="form-control" name="categorie">{html_options options=$liste_categories selected=$categorie}</select>
					</div>
					<div class="form-group">
					  <label for="libelle">Libellé:*</label>
					  <input class="form-control" type="text" name="libelle" value="{$libelle}"  placeholder="{$libelle}" />
					</div>
					<div class="form-group">
					  <label for="">Fournisseur : *</label>
					  <select class="form-control" name="fournisseur">{html_options options=$liste_fournisseurs selected=$fournisseur}</select>
					</div>
					<div class="form-group">
					  <label for="">Référence catalogue:</label>
					  <input class="form-control" type="text" name="reference" value="{$reference}" />
					</div>
					<div class="form-group">
						<label for="">Marque :</label>
						<input class="form-control" type="text" name="marque" value="{$marque}"/>
					</div>
				
					    <input class="btn btn-primary"type="submit" name="submit" value="Envoyer" />
						<input class="btn btn-primary"type="submit" name="cancel" value="Annuler" />
					  
					{form_end}
						</div>
					</div>
				</div>
			</div>
{/if}