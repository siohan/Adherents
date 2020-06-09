{literal}
<script>
 $(function() {
   $( "#m1_anniversaire" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}
<h3>Ajout/modification d'un adhérent</h3>
<!-- Content Column -->
        <div class="col-lg-9 mb-4">
{form_start}

<input type="hidden" name="edit" value="{$edit}" />
<input type="hidden" name="genid" value="{$genid}"/>
<div class="c_full cf">
	<label class="grid_3">Actif</label>
	<div class="grid_8">
	<select class="grid_2" name="actif">{cms_yesno selected=$actif}</select>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Nom</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="nom" value="{$nom}"/>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Prénom</label>
	<div class="grid_8">
		<input  class="grid_8 required" type="text" name="prenom" value="{$prenom}"/>
	</div>
</div>	
<div class="c_full cf">
		<label class="grid_3">Sexe</label>
		<div class="grid_8">
		<select class="grid_8" name="sexe">{html_options options=$liste_sexe selected=$sexe}</select>
		</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Anniversaire</label>
	<div class="grid_8">
		<input class="grid_8" type="date" name="anniversaire" value="{$anniversaire}"/>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Licence</label>
	<div class="grid_8">
		<input class="grid_8" type="text" name="licence" value="{$licence}"/>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Adresse</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="adresse" value="{$adresse}"/>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Code Postal</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="code_postal" value="{$code_postal}"/>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Ville</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="ville" value="{$ville}"/>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Pays</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="pays" value="{$pays}"/>
	</div>
</div>

<div class="c_full cf">
  <input type="submit" name="submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

{form_end}
</div>
