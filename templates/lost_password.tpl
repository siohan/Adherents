{if $validation == 1}
<div class="alert alert-info" role="alert">Pb !!!{$final_message}</div>
{else}
<h3>Mot de passe oublié ?</h3>
{form_start action=forgotpw}
<div class="form-group">
	<label for"nom">Votre nom</label>
	<input class="form-control" type="text" name="nom" placeholder="votre nom">
</div>
<div class="form-group">
	<label for="prenom">Votre prénom</label>
	<input class="form-control" type="text" name="prenom" placeholder="votre prénom">
</div>
<button type="submit" class="btn btn-primary">Envoyer</button>
{form_end}
{/if}
