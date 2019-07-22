{form_start action=do_upload_image method=POST}
<fieldset>
        <legend>Téléverser une image</legend>
          <p>
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
	<input type="hidden" name="genid" value="{$genid}" />
        <input name="fichier" type="file" id="fichier_a_uploader" />
        <input type="submit" name="submit" value="Uploader" />
      </p>
</fieldset>
{form_end}