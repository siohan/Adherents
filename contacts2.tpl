<div class="pageoptions">
         <a href="{cms_action_url action=add_edit_contact}">{admin_icon icon='newobject.gif'}
            Ajouter
         </a>
       </div>
       {if !empty($contacts)}
       <table class="pagetable">
<thead> <tr>
             <th>{$mod->Lang('name')}</th>
             <th>{$mod->Lang('date')}</th>
             <th class="pageicon">{* edit icon *}</th>
             <th class="pageicon">{* delete icon *}</th>
           </tr>
         </thead>
         <tbody>
         {foreach $contacts as $contact}
           {cms_action_url action=add_edit_contact record_id=$contact->id assign='edit_url'}
<tr>
             <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$contact->type_contact}</a></td>
             <td>{$contact->contact}</td>
			<td>{$contact->description}</td>
             <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">
                   {admin_icon icon='edit.gif'}</a>
              </td>
             <td>{* delete link will go here *}</td>
           </tr>
{/foreach}
         </tbody>
       </table>
{/if}