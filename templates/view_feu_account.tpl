<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">			
		<h3 class="dashboard-icon"><i class="fa fa-lock"></i> Authentification (FEU)</h3>	
		<span class="description">Pour espace privé et pages de contenu protégé</span>	
					{if $activation == true}
						{if $autorisation == true}
							{if true== $has_feu_account}
							<p class="green"> Le membre possède déjà un compte FEU</p>
							{else}
							<p class="red">Ce membre ne possède pas un compte FEU <a href="{cms_action_url action='push_customer' record_id=$genid}">Créer ?</a></p>
							{/if}
							
								
							{else}<p class="red"><strong>Vous n'êtes pas autorisé à voir ce contenu...</strong></p>{/if}
					{else}
						<p class="red"><strong>Le module FrontEndUsers n'est pas activé !</strong></p>{/if}
		</nav>
</div>