<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-envelope-open"></i>
              Envoi d'un message</div>
            <div class="card-body">
              

{$formstart}

	
	<div class="pageoverflow">
		<p class="pagetext">Priorité du message</p>
		<p class="pageinput">{$priority}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Sujet du message</p>
		<p class="pageinput">{$sujet}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Message:</p>
		<p class="pageinput">{$message}</p>
	</div>

	</fieldset>
	<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<p class="pageinput">{$submit}</p>
		</div>


{$endform}
</div>
</div>
</div>
</div>