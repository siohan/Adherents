{form_start action='admin_images_tab'}
<fieldset>
	<legend>Réglages des paramètres images</legend>

		<p class="warning">Ce sont les photos de vos membres.</p>
		<p class="pagetext">Extensions autorisées</p>
		<input type="text" name="allowed_extensions" value="{$allowed_extensions}"/>
		
		<div class="pageoverflow">
			<p class="pagetext">Poids maximal de l'image (en octets)</p>
			<input type="text" name="max_size" value="{$max_size}"/>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Largeur maximale de l'image</p>
			<input type="text" name="max_width" value="{$max_width}"/>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Hauteur maximale de l'image</p>
			<input type="text" name="max_height" value="{$max_height}"/>
		</div>

	<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<input type="submit" name="submit" value="Envoyer"/>
		</div>
</fieldset>

{form_end}
