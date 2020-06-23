<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
  $('#selectall').click(function(){
    var v = $(this).attr('checked');
    if( v == 'checked' ) {
      $('.select').attr('checked','checked');
    } else {
      $('.select').removeAttr('checked');
    }
  });
  $('.select').click(function(){
    $('#selectall').removeAttr('checked');
  });
  $('#toggle_filter').click(function(){
    $('#filter_form').toggle();
  });
  {if isset($tablesorter)}
  $('#articlelist').tablesorter({ sortList:{$tablesorter} });
  {/if}
});
//]]>
</script>
<h2>{$titre}</h2>
<p><a href="{cms_action_url action='view_adherent_details' record_id=$genid}">{admin_icon icon="back.gif"} Revenir</a></p>
{form_start}
<input type="hidden" name="id_presence" value="{$id_presence}">
<input type="hidden" name="genid" value="{$genid}">
<input type="radio" name="id_option" value="1" {if $user_choice == 1}checked{/if}> Oui <br />
<input type="radio" name="id_option" value="0" {if $user_choice == 0}checked{/if}> Non <br />
<input type="submit" name="submit" value="Envoyer">
{form_end}
