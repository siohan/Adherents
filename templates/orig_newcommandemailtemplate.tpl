{* Email envoyé au gestionnaire des commandes *}
{* liste des variables disponibles *}
{* Email envoyé au gestionnaire des commandes *}
{* liste des variables disponibles *}
<h3>Nouvelle commande</h3>

<h3>Détails de la commande N° {$commande_number}</h3>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Fournisseur</th>
		<th>Catégorie de produit</th>
		<th>Article</th>
		<th>Quantité</th>
		<th>Epaisseur, manche, taille</th>
		<th>Couleur</th>
	</tr>
 </thead>
 <tbody>

  <tr class="{$entry->rowclass}">
	<td>{$fournisseur}</td>
	<td>{$categorie_produit}</td>
	<td>{$libelle_commande}</td>
	<td>{$quantite}</td>
	<td>{$ep_manche_taille}</td>
	<td>{$couleur}</td>
  </tr>

 </tbody>
</table>
