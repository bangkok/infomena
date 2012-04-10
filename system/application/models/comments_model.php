<?
class Comments_model extends Model 
{ 
	
	private $catcomments = 'catcomments';
	private $usercomments = 'usercomments';	

  function Comments_model()  {   
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

	function getCatComments($pos, $lang='no'){
		
		$u_table = $this->auth_model->getval('table');
		$u_id = $this->auth_model->getval('id');
		$u_nickname = $this->auth_model->getval('nickname');
		$u_avatar = $this->auth_model->getval('avatar');
			
		$this->db->select("$this->catcomments.*");		
		$this->db->select("$u_table.$u_id as u_id, $u_table.$u_nickname AS nickname, $u_table.$u_avatar AS avatar, $u_table.rating AS urating");
		$this->db->join($u_table, "$u_table.$u_id  = commentator", "LEFT");
		
		$this->db->where('pos', $pos);
		$this->db->order_by("$this->catcomments.ad", 'DESC');
	  	$query=$this->db->get($this->catcomments);
	  	return $query->result();
	}
	function getUserComments($user, $lang='no'){
		
		$u_table = $this->auth_model->getval('table');
		$u_id = $this->auth_model->getval('id');
		$u_nickname = $this->auth_model->getval('nickname');
		$u_avatar = $this->auth_model->getval('avatar');

		$this->db->select("$this->usercomments.*");		
		$this->db->select("$u_table.$u_id as u_id, $u_table.$u_nickname AS nickname, $u_table.$u_avatar AS avatar, $u_table.rating AS urating");
		$this->db->join($u_table, "$u_table.$u_id  = commentator", "LEFT");
		
		$this->db->where('user', $user);
		$this->db->order_by("$this->usercomments.ad", 'DESC');
	  	$query=$this->db->get($this->usercomments);
	  	return $query->result();		
	}
	function AddCatComment($commentator, $lang='no'){
		$poles = 'message | pos';
		$u = $this->datapost($poles);
		//$u->{$this->auth_model->getval('login')} = $user_id;

		$u->commentator = $commentator;
		$u->ad = date("Y-m-d H:i:s");
		//print_r($u);
		$this->db->insert($this->catcomments, $u);
		return mysql_insert_id();		
	}
	function AddUserComment($commentator, $lang='no'){
		$poles = 'message | user';
		$u = $this->datapost($poles);
		//$u->{$this->auth_model->getval('login')} = $user_id;

		$u->commentator = $commentator;
		$u->ad = date("Y-m-d H:i:s");
		//print_r($u);
		$this->db->insert($this->usercomments, $u);
		return mysql_insert_id();		
	}	
	function CntUserComments($user){
		$this->db->where('user', $user);
		return $this->db->count_all_results($this->usercomments);
	}
	function CntCatComments($pos){
		$this->db->where('pos', $pos);
		return $this->db->count_all_results($this->catcomments);
	}
// =========================================
public function getval($name){
		if(isset($this->$name))
			return $this->$name;
		return false;
	}	
}    

?>