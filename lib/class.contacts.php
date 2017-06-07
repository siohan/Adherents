<?php
       class Contacts
       {
           private $_data = array('id'=>null,'licence'=>null,'actif'=>null,'nom'=>null,
                                  'prenom'=>null,'club'=>null, 'nclub'=>null, 'clast'=>null);
           public function __get($key)
           {
               switch( $key ) {
               case 'id':
               case 'licence':
	       case 'type_contact':
               case 'contact':
               case 'description':
                return $this->_data[$key];
               }
}
           public function __set($key,$val)
           {
        	switch( $key ) {
               	case 'contact':
               	case 'description':
                   $this->_data[$key] = trim($val);
                break;
    		case 'licence':
		case 'type_contact' : 
        	   $this->_data[$key] = (int) $val;
		break; 
	   }
}
public function save()
{
    if( !$this->is_valid() ) return FALSE;
    if( $this->id > 0 ) {
        $this->update();
    } else {
        $this->insert();
    }
}
public function is_valid()
{
    //if( !$this->nom ) return false;
    if( !$this->licence ) return false;
    return TRUE;
}
protected function insert()
{
    $db = \cms_utils::get_db();
    $sql = 'INSERT INTO '.CMS_DB_PREFIX.'module_ping_adherents_contacts (licence, type_contact, contact, description) VALUES (?,?,?,?)';
    $dbr = $db->Execute($sql,array($this->licence,$this->type_contact,$this->contact, $this->description));
    if( !$dbr ) return FALSE;
    $this->_data['id'] = $db->Insert_ID();
    return TRUE;
}
protected function update()
{
    $db = \cms_utils::get_db();
    $sql = 'UPDATE '.CMS_DB_PREFIX.'module_adherents_contacts SET licence = ?, type_contact = ?, contact = ?, description = ? WHERE id = ?';
    $dbr = $db->Execute($sql,array($this->licence,$this->type_contact,$this->contact, $this->description, $this->id));	
    if( !$dbr ) return FALSE;
    return TRUE;
}
public function delete()
{
    if( !$this->id ) return FALSE;
    $db = \cms_utils::get_db();
    $sql = 'DELETE FROM '.CMS_DB_PREFIX.'module_adherents_contacts WHERE id = ?';
    $dbr = $db->Execute($sql,array($this->id));
    if( !$dbr ) return FALSE;
    $this->_data['id'] = null;
    return TRUE;
}
/** internal */
public function fill_from_array($row)
{
    foreach( $row as $key => $val ) 
	{
        	if( array_key_exists($key,$this->_data) ) 
		{
            		$this->_data[$key] = $val;
        	}
	} 
}
public static function &load_by_id($id)
{

$id = (int) $id;
               $db = \cms_utils::get_db();
               $sql = 'SELECT * FROM '.CMS_DB_PREFIX.'module_adherents_contacts WHERE id = ?';
               $row = $db->GetRow($sql,array($id));
               if( is_array($row) ) 
		{
                   $obj = new self();
                   $obj->fill_from_array($row);
                   return $obj;
		} 
}
} 
?>