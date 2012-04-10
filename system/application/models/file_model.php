<?
class File_model extends Model 
{ 
  function __construct()  {   parent::Model();   }
   
 
	function addfile($myfile ,$name='')
	{
		$table = 'nrfl';
		$path_to_admin = "/admin/";	
		$Expire_c = 3600;
	
		$u->flnm = $name;
		//$u->flim = '/admin/media/806';
		$u->flim_fnm = $myfile['name'];//$description;
		if($u->flim_siz = $myfile['size'])
			{clearstatcache ();$u->flim_siz = filesize($myfile['tmp_name']);}
		
		$u->flex = $Expire_c;
		$u->ad = date('Y-m-d H:i:s');
		$u->up = date('Y-m-d H:i:s');
		//$u->dl = '';
      	$this->db->set($u);
      	$this->db->insert($table);
	
		$id = mysql_insert_id();
		@move_uploaded_file  ( $myfile['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path_to_admin.'media/'.$id  );
		//chmod ( $_SERVER['DOCUMENT_ROOT'].$path_to_admin.'media/'.$id, '0777' );
		
		//$this->db->where('login', $login);
		//$this->db->update('users', array('foto'=>$id));
		
	    return $id;
	}
	
	
	function upfile($id, $myfile ,$name='')
	{
		//if (!$id) return $this->addfile($this->data['auth']['login'] ,$myfile ,$name);
		
		$table = 'nrfl';
		$path_to_admin = "/admin/";	
		$Expire_c = 3600;
	
		$u->flnm = $name;
		//$u->flim = '/admin/media/806';
		$u->flim_fnm = $myfile['name'];//$description;
		//clearstatcache ();	$u->flim_siz = filesize($myfile['tmp_name']);//
		$u->flim_siz = $myfile['size'];
		$u->flex = $Expire_c;
		//$u->ad = date('Y-m-d H:i:s');
		$u->up = date('Y-m-d H:i:s');
		//$u->dl = '';
      	$this->db->set($u);

      	$this->db->where('flid', $id);
      	$this->db->update($table);
	
		move_uploaded_file  ( $myfile['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path_to_admin.'media/'.$id  );
		//chmod ( $_SERVER['DOCUMENT_ROOT'].$path_to_admin.'media/'.$id, '0777' );
		
		
		//$this->db->where('login', $this->data['auth']['login']);
		//$this->db->update('users', array('foto'=>$id));
		
	    return $id;
	}
	
	
	    function delfile($id=null)
    {	
    	$table = 'nrfl';
    	$path_to_admin = "/admin/";	
    	
		$this->db->where('flid', $id);
		//$this->db->where('login', $this->data['auth']['login']);
		$this->db->delete($table);
		
		unlink ($_SERVER['DOCUMENT_ROOT'].$path_to_admin.'media/'.$id) ;
		return true; 
	}
	
	
	function joinfile($table, $pole, $value, $conditions = array())
	{
		//$this->db->where('login', $this->data['auth']['login']);
		foreach ($conditions as $key=>$condition)
			$this->db->where($key, $condition);
		$this->db->update($table, array($pole=>$value));
		return true;
	}
	
} 
   


?>