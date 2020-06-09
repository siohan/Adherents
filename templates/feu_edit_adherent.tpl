{literal}
<script>
 $(function() {
   $( "#m1_anniversaire" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}
{if true == $validation}
{$final_message}
{else}
<h3>Adhésion à un groupe</h3>
<!-- Content Column -->
        <div class="col-lg-9 mb-4">
	<p class="information">Les champs suivis d'un astérisque sont obligatoires</p>
{form_start action='feu_edit_adherent'}

<input type="hidden" name="record_id" value="{$record_id}" />
<input type="hidden" name="id_inscription" value="{$id_inscription}" />
<input type="hidden" name="id_group" value="{$id_group}" />

<div class="c_full cf">
	<label class="grid_3">Nom *</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="nom" value="{$nom}" size="40" required>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Prénom *</label>
	<div class="grid_8">
		<input  class="grid_8 required" type="text" name="prenom" value="{$prenom}" required>
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
	<label class="grid_3">Email *</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="email1" value="{$email1}" required>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Email (confirmation) *</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="email2" value="{$email2}" required>
	</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Portable</label>
	<div class="grid_8">
		<input class="grid_8 required" type="text" name="portable" value="{$portable}" placeholder="+33 6xxxxxx">
	</div>
</div>

<div class="c_full cf">
  <input type="submit" name="submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

{form_end}
</div>
{/if}
