<h3>Votre compte</h3>
{if $error < 1}
<p class="alert alert-success">{$message_final}<br />

Pour continuer <a href="{$lien}"> Cliquez ici</a></p>
{else}
<p class="alert alert-danger">{$message_final}</p>

{/if}