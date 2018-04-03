{literal}
<script>
 $(function() {
   $( "#m1_anniversaire" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}<div class="pageoverflow">
{$formstart}

{if $edition == '0'}
{$edit}
<div class="pageoverflow">
  <p class="pagetext">Licencié(e) FFTT ? :</p>
  <p class="pageinput">{$fftt}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Licence :</p>
  <p class="pageinput">{$licence}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Nom :</p>
  <p class="pageinput">{$nom}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Prénom :</p>
  <p class="pageinput">{$prenom}</p>
</div>
{else}
{$licence}
{/if}
<div class="pageoverflow">
  <p class="pagetext">Date naissance :</p>
  <p class="pageinput">{$anniversaire}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Adresse :</p>
  <p class="pageinput">{$adresse}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Code postal</p>
  <p class="pageinput">{$code_postal}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Ville :</p>
  <p class="pageinput">{$ville}</p>
</div>

<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>

{$formend}
</div>
