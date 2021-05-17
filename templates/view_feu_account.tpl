<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-lock"></i> Espace privé ++</h3>	
		<span class="description">Pour espace privé et pages de contenu protégé</span>	
					{if $activation == true}
						{if $autorisation == true}
								{if $has_email == true}
									<p class="green"><a href="{cms_action_url action=push_customer record_id=$genid}">(R)Envoyer l'identifiant et mot de passe</a></p>
								{else}<p class="red"><strong>Email obligatoire !!</strong></p>
								{/if}
						{else}
							<p class="red"><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>
						{/if}
					{else}
						<p class="red"><strong>Le module FrontEndUsers n'est pas activé !</strong></p>
					{/if}
		</nav>
</div>