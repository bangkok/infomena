<?
class Checks_model extends Model 
{ 
	
	private $table = 'checks';
	private $table_operation = 'transaction';
	private $table_cat_status = 'cat_status';
	private $table_valuta = 'valuta';
	private $table_cur = 'cur_exchange';
	
	private $type_reg = 'reg';
	
	
		
	
  function Checks_model()  {   
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
	
	function addCheck($id_user_from, $id_user_to){
		$poles="asgmt | desc | info | cash | valuta | comis | confirmed | date_confirm";
		$u = $this->datapost($poles);
		$u->id_user_from = $id_user_from;
		$u->id_user_to = $id_user_to;
		$u->inum = 1+$this->numberCheck($id_user_from);
		$u->ad = date("Y-m-d H:i:s");
		
		$this->db->insert($this->table, $u);
		return mysql_insert_id(); 
	}
	function confirmed($id=0){
		$u->confirmed = 1;
		$u->date_confirm = date("Y-m-d H:i:s");
		$this->db->where('id', $id);
		$this->db->update($this->table, $u);
	}

	function getUserByNickname($nickname, $fields=''){
		$u_table = $this->auth_model->getval('table');
		$u_login = $this->auth_model->getval('login');
		$u_nickname = $this->auth_model->getval('nickname');
		
		$this->db->where($u_nickname, $nickname);
		$query = $this->db->get($u_table);
		if ($query->num_rows() > 0){
			$row = $query->row();
			if(!empty($fields)){
		   		foreach (explode("|",$fields) as $field){
		   			$field = trim($field);
		   			$res->$field = $row->$field;
		   		}
	   		return $res;
	   		}
			return $this->auth_model->getUser($row->$u_login);
		}
		return false;
	}
	function numberCheck($user_id){
		$this->db->select("MAX(inum) as inum");
		$this->db->where('id_user_from',$user_id);
		$query = $this->db->get($this->table);
		$row = $query->row();
		return $row->inum;
		//print_r($row);
		
	}

	function getUserChecks($user_id){
		$u_table = $this->auth_model->getval('table');
		$u_id = $this->auth_model->getval('id');
		$u_nickname = $this->auth_model->getval('nickname');
		$table_catalog = $this->catalog_model->getval('table_catalog');	
		
		$this->db->select("$this->table.*");
		$this->db->select("date_format($this->table.ad, '%d.%m.%Y') AS date",FALSE);
		
		$this->db->select("$table_catalog.title as title, 	$table_catalog.type as type");
		$this->db->join($table_catalog, "$table_catalog.id = $this->table.asgmt", "LEFT");
		
		$this->db->select("$u_table.$u_nickname AS nickname");
		$this->db->join($u_table, "
			($u_table.$u_id  = $this->table.id_user_from AND $this->table.id_user_from != $user_id) OR
			($u_table.$u_id  = $this->table.id_user_to AND $this->table.id_user_to != $user_id) ", "LEFT");
		
		$this->db->select("CASE $this->table.id_user_from WHEN $user_id THEN 
			info + comis ELSE
			-(info + comis) END AS income");
		$this->db->where("$this->table.confirmed",1);		
		$this->db->where("(($this->table.id_user_to = $user_id) OR ($this->table.id_user_from = $user_id))");
		//$this->db->where("$this->table.id_user_from",$user_id);

		$this->db->order_by("$this->table.ad", 'desc');
		$query = $this->db->get($this->table);
		return $query->result();		
	}

	function getUserTransactions($user_id){
		$table = $this->table_operation;
		$u_table = $this->auth_model->getval('table');
		$u_id = $this->auth_model->getval('id');
		$u_nickname = $this->auth_model->getval('nickname');
		$table_catalog = $this->catalog_model->getval('table_catalog');


		$this->db->select("$table.*");
		$this->db->select("date_format($table.ad, '%d.%m.%Y') AS date",FALSE);

		$this->db->select("$u_table.$u_nickname AS nickname, $u_table.$u_id as user_id");
		$this->db->join($u_table, "
			($u_table.$u_id  = $table.id_user_from AND $table.id_user_from != $user_id) OR
			($u_table.$u_id  = $table.id_user_to AND $table.id_user_to != $user_id) ", "LEFT");
		$this->db->select("CASE $table.id_user_to WHEN $user_id THEN
			$table.info + $table.comis ELSE
			-($table.info + $table.comis) END AS income");

		$this->db->select("$this->table.id as order_id");
		$this->db->join($this->table, "$this->table.id = $table.id_check", "LEFT");

		$this->db->select("$table_catalog.title as title");
		$this->db->join($table_catalog, "$table_catalog.id = $this->table.asgmt", "LEFT");

		$this->db->where("(($table.id_user_to = $user_id) OR ($table.id_user_from = $user_id))");
		$this->db->order_by("$table.ad", 'desc');

		$query = $this->db->get($table);
		return $query->result();

	}


	function getChecksTo($user_id){
		$this->db->select('*');
		$this->db->select('date_format(ad, \'%d.%m.%Y\') AS date',FALSE);
		$this->db->where('id_user_to',$user_id);
		$this->db->order_by("ad", 'desc');
		$query = $this->db->get($this->table);
		return $query->result();
	}
	function getChecksFrom($user_id){
		$this->db->select('*');
		$this->db->select('date_format(ad, \'%d.%m.%Y\') AS date',FALSE);
		$this->db->where('id_user_from',$user_id);
		$this->db->order_by("ad", 'desc');
		$query = $this->db->get($this->table);
		return $query->result();
	}
	function getIdCheck($id){
		$this->db->select('*');
		$this->db->select('date_format(ad, \'%d.%m.%Y\') AS date',FALSE);
		$this->db->where('id',$id);
		$query = $this->db->get($this->table);
		return $query->row();
	}
	function cntChecksTo($user_id){
		$this->db->where('id_user_to',$user_id);
		$this->db->where('confirmed !=', 1);
		return  $this->db->count_all_results($this->table);
	}
	
public function getval($name){
	if(isset($this->$name))
		return $this->$name;
	return false;
	}
}    

?>