{literal}
<script>
 $(function() {
   $( "#m1_anniversaire" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}
<!-- Content Column -->
        <div class="col-lg-9 mb-4">
{$formstart}
{$genid}


<div class="pageoverflow">
  <p class="pagetext">Nom :</p>
  <p class="pageinput">{$nom}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Prénom :</p>
  <p class="pageinput">{$prenom}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Sexe :</p>
  <p class="pageinput">{$sexe}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Date naissance :</p>
  <p class="pageinput">{$anniversaire}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Licence :</p>
  <p class="pageinput">{$licence}</p>
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
  <p class="pagetext">Pays :</p>
  <p class="pageinput">{$pays}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Externe ? :</p>
  <p class="pageinput">{$externe}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>

{$formend}
</div>
