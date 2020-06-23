<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">
		<h3 class="dashboard-icon groups"><i class="fa fa-camera"></i> Photo</h3>
	{if $extension !=''}

	{$photo}
	{/if}
	<br />
		{form_start action=do_upload_image}
				<input type="hidden" name="genid" value="{$genid}" />
		        <input name="fichier" type="file" id="fichier_a_uploader" />
		        <input type="submit" name="submit" value="Uploader" />
		{form_end}
	</nav>
</div>