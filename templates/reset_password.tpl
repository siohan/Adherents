{$var|print_r}
{if $validation =="1"}
<p>{$final_message}</p>
{else}
<h3>Mot de passe oublié ?</h3>
{form_start action=reset_password}
<input type="hidden" name="genid" value="{$genid}">
<input type="hidden" name="feu_id" value="{$feu_id}">
<div class="form-group">
	<label for"nom">Nouveau Mot de passe</label>
	<input class="form-control" type="password" name="password1" required>
</div>
<div class="form-group">
	<label for="prenom">Nouveau Mot de passe (confirmation)</label>
	<input class="form-control" type="password" name="password2" required>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
{form_end}
{/if}
