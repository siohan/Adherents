<div class="pageoverflow">
{$formstart}
{$produit_id}
{$record_id}{*la licence de l'adhérent*}
{*$categorie_produit*}
{$fournisseur}
{$edition}
{$produit_id}
<div class="alert alert-primary" role="alert">Il manque un article ?<a href="{cms_action_url action=fe_add_item record_id=$username}">Ajoutez-le !</a></div>
<div class="pageoverflow">
  <p class="pagetext">Libellé:</p>
  <p class="pageinput">{$libelle_commande}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Epaisseur Manche Taille:{*cms_help key='help_ep_manche_taille'*}</p>
  <p class="pageinput">{$ep_manche_taille}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Couleur:</p>
  <p class="pageinput">{$couleur}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">Quantité :</p>
	<p class="pageinput">{$quantite}</p>
</div>
<!--<div class="pageoverflow">
	<p class="pagetext">Statut de l'article :</p>
	<p class="pageinput">{$statut_item}</p>
</div>-->
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>