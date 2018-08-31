<h1>Envoyer un SMS</h1>
<p>Les signes suivants comptent double en caractères : € \ [] {} ~ ^ | <br />
Le signe € n'est disponible que sur la gamme Premium. Autrement il est remplacé par E</p>
<p>Attention, si vous utilisez des variables dynamiques, ce nombre peut ne pas indiquer le nombre réel de caractères/SMS</p>
<p>Si vous utilisez une liste de contacts vous pouvez utiliser les variables
#nom# #prenom# #telephone# #fax# #champ1# #champ2# #champ3# #champ4# #champ5#</p>
<div class="pageoverflow">
{$formstart}
{$group}
<div class="pageoverflow">
  <p class="pagetext">Expéditeur </p>
  <p class="pageinput">{$sender}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Message</p>
  <p class="pageinput">{$content}</p>
</div>

<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
