<h3>Récupération du mot de passe</h3>
<!-- Content Column -->
        <div class="col-lg-9 mb-4">
	
{form_start action='forgotpw'}



<div class="c_full cf">
	<label class="grid_3">prénom, nom, sans espace, accents, tirets, apostrophes,etc...</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="username" value="{$nom}" size="40" required>
	</div>
</div>


<div class="c_full cf">
  <input type="submit" name="submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

{form_end}
</div>
{/if}
