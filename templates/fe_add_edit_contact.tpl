{if isset($validation)}
{if $success==true}<div class="alert alert-success">{else}<div class="alert alert-danger">{/if}{$final_msg} {cms_selflink page="mon-compte" text="Revenir à mon compte"}
{else}
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-user-check"></i>
              J'ajoute un nouveau contact</div>
            <div class="card-body">
              <div class="table-responsive">
					{form_start action=fe_add_edit_contact}
					<input type="hidden" name="genid" value="{$genid}" />
					<input type="hidden" name="record_id" value="{$record_id}" />


					<div class="c_full cf form-group">
						<label class="grid_3">Type de contact</label>
						<div class="grid_8"><select class="grid_2 form-control" name="type_contact">{html_options options=$liste_types_contact selected=$type_contact}</select></div>
					</div>
					<div class="c_full cf form-group">
						<label class="grid_3">Contact</label>
					  <div class="grid_8"><input class="form-control" type="text" name="contact" value="{$contact}" /></div>
					</div>
					<div class="c_full cf form-group">
						<label class="grid_3">Description:</label>
					  <div class="grid_8"><input class="form-control" type="text" name="description" value="{$description}" /></div>
					</div>

					<div class="c_full cf form-group">
					    <input class="btn btn-primary" type="submit" name="submit" value="Envoyer" /><input class="btn btn-primary" type="submit" name="cancel" value="Annuler" />
					  </div>
					{form_end}
				</div>
				</div>
				</div>
				</div>
{/if}