<?
class Messages_model extends Model 
{ 
	
	private $table = 'messages';
	
	

	

  function Messages_model()  {   
		parent::Model();   
  }
  
function datapost($fields = ''){
	if(!empty($fields)){
 	//$fieldsa = explode("|",$fields);
		foreach (explode("|",$fields) as $field){
			$field = trim($field);
  	 		$res->$field = $this->input->post($field);
		}
   		return $res;
   	}
   	return false;
}  
  function GetMessages($user_id, $col=0,$from=0 ,$conditions = array()){
		$u_table = $this->auth_model->getval('table');
		$u_id = $this->auth_model->getval('id');
		$u_nickname = $this->auth_model->getval('nickname');
		$u_avatar = $this->auth_model->getval('avatar');
		
  		$this->db->select("$this->table.*, $this->table.id AS id");
  		
		$this->db->select("$u_table.$u_id AS u_id, $u_table.$u_nickname AS nickname, $u_table.$u_avatar AS avatar, $u_table.rating AS urating");
		$this->db->join($u_table, "
			($u_table.$u_id  = $this->table.user_from AND $this->table.user_from != $user_id) OR
			($u_table.$u_id  = $this->table.user_to AND $this->table.user_to != $user_id) ", "LEFT");
		
		$this->db->where("(($this->table.user_to = $user_id  AND $this->table.dlt = 'n') OR ($this->table.user_from = $user_id  AND $this->table.dlf = 'n'))");
		//$this->db->where("$this->table.dl","n");
		
		if(!empty($conditions) && is_array($conditions))
			foreach ($conditions as $key => $value)
				if(is_numeric($key)) $this->db->where($value);
				else $this->db->where($key, $value);	

		if($col === 'CNT')return  $this->db->count_all_results($this->table);
				
		$this->db->order_by("$this->table.ad", 'desc');
		
		if($col>0)
			$this->db->limit($col,$from);
			
		$query = $this->db->get($this->table);
		return $query->result();
  }
  function GetMessage($id){
		$this->db->where("id",$id);
		$query = $this->db->get($this->table);
		return $query->result();
  }
  
  function addMessage($user_from, $user_to){
		$poles="theme | message";
		$u = $this->datapost($poles);
		
		$u->user_from = $user_from;
		$u->user_to = $user_to;
		$u->inum = 1+$this->numberCheck($user_to);
		$u->ad = date("Y-m-d H:i:s");  	
		$this->db->insert($this->table, $u);
  		return mysql_insert_id();
  }
  function readCheck($id){
		$u->new = 1;
		$u->readed = date("Y-m-d H:i:s");
		$this->db->where('id', $id);
		$this->db->update($this->table, $u);
  	
  }
  function delMessage($id, $user){
  		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		$mess = $query->row();
		
  		if($mess->user_from == $user){
			$u->dlf = 'y';
			$this->db->where('id', $id);
			$this->db->update($this->table, $u);  	
  		}
  		if($mess->user_to == $user){
			$u->dlt = 'y';
			$this->db->where('id', $id);
			$this->db->update($this->table, $u);  	
  		}
  }
  

// =========================================
	function numberCheck($user_id){
		$this->db->select("MAX(inum) as inum");
		$this->db->where('id_user_from',$user_id);
		if(!$query = $this->db->get($this->table)) return false;
		$row = $query->row();
		return $row->inum;
		//print_r($row);
		
	}
public function getval($name){
		if(isset($this->$name))
			return $this->$name;
		return false;
	}	
}    

?>