<h3>Ajout / Modification d'un groupe</h3>
{form_start}
<input type="hidden" name="record_id" value="{$record_id}" />

<div class="c_full cf">
  <label class="grid_3">Groupe</label>
  <div class="grid_8"><input type="text" name="nom" value="{$nom}" size="40"></div>
</div>
<div class="c_full cf">
  <label class="grid_3">Description</label>
  <div class="grid_8"><input type="text" name="description" value="{$description}"  size="40"></div>
</div>
<div class="c_full cf">
  <label class="grid_3">Actif</label>
  <div class="grid_8"><select name="actif">{cms_yesno selected=$actif}</select></div>
</div>

<div class="c_full cf">
	<label class="grid_3">Groupe public ? : {cms_help key='help_public_group' title="Groupe public ?" }</label>
	<div class="grid_8"><select name="public">{cms_yesno selected=$public}</select></div>
</div>
<div class="c_full cf">
	<label class="grid_3">Auto-enregistrement ? : {cms_help key='help_auto_enregistrement' title='Auto-enregistrement'}</label>
	<div class="grid_8"><select name="auto_subscription">{cms_yesno selected=$auto_subscription}</select>
</div>

<div class="c_full cf">
	<label class="grid_3">Validation par l'administrateur ? : {cms_help key='help_admin_valid' title='Validation par l\'admin'}</label>
	<div class="grid_8"><select name="admin_valid">{cms_yesno selected=$admin_valid}</select></div>
</div>
<div class="c_full cf">
	<label class="grid_3">Redirection après activation du compte : {cms_help key='help_pageid_aftervalid' title='Redirection après validation'}</label>
	<div class="grid_8"><input type="text" name="pageid_aftervalid" value="{$pageid_aftervalid}" size="40"></div>
</div>
    <input type="submit" name="submit" value="Envoyer">
	<input type="submit"  name="cancel" value="Annuler">

{form_end}
