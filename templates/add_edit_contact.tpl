<h3> Ajout / Modification d'un contact</h3>
<div class="pageoverflow">
{form_start action=add_edit_contact}
<input type="hidden" name="genid" value="{$genid}" />
<input type="hidden" name="record_id" value="{$record_id}" />


<div class="pageoverflow">
  <p class="pagetext">Type Contact:</p>
  <p class="pageinput"><select name="type_contact">{html_options options=$liste_types_contact selected=$type_contact}</select></p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Contact</p>
  <p class="pageinput"><input type="text" name="contact" value="{$contact}" /></p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Description:</p>
  <p class="pageinput"><input type="text" name="description" value="{$description}" /></p>
</div>

<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer" /><input type="submit" name="cancel" value="Annuler" /></p>
  </div>
{form_end}
</div>
