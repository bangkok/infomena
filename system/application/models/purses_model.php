<?
class Purses_model extends Model 
{ 
	
	private $table_purses = 'purses';
	private $table_operation = 'transaction';
	private $table_cat_status = 'cat_status';
	private $table_valuta = 'valuta';
	private $table_cur = 'cur_exchange';
	private $table_catalog = 'catalog';
	
	private $type_reg = 'reg';
	private $type_order = 'order';
	private $type_comis = 'comis';
	
	private $InfomenaId = 1;
	private $FondId = 2;

  function Purses_model()  {   
		parent::Model();   
  }


  function createPurse($user_id){
  	if(!$this->getUserPurseId($user_id)){
  		$u->id_user = $user_id;
  		$this->db->insert($this->table_purses, $u);
  		return mysql_insert_id();
  	}
  	return false;
  }
  
  function f1($id_user_from,$id_user_to,$info,$type='', $order_id=0){
  	
  	if( !($this->getUserPurseId($id_user_from) && $this->getUserPurseId($id_user_to)) ) return false;
  	if(empty($type))$type = $this->type_reg;
  	//else $type = $this->{'type_'.$type};
  	
  	$fpurse = $this->getUserPurse($id_user_from);
  	$sub = $fpurse->info - $info;
  	$this->db->where('id_user',$id_user_from);
  	$this->db->update($this->table_purses, array('info'=>$sub));
  	
  	$tpurse = $this->getUserPurse($id_user_to);
  	$add = $tpurse->info + $info;
  	$this->db->where('id_user',$id_user_to);
  	$this->db->update($this->table_purses, array('info'=>$add));

  	$u->id_user_from= $id_user_from;
  	$u->id_user_to	= $id_user_to;
  	$u->id_purse_from = $fpurse->id;
  	$u->id_purse_to = $tpurse->id;
  	$u->info = $info;
  	if(empty($type))$type = $this->type_reg;
  	$u->type = $type;
  	if(!empty($order_id)) $u->id_check = $order_id;
  	$u->ad = date("Y-m-d H:i:s");
  	$Infimena_sec_code = $this->config_model->getConfigName('Infomena_sec_code');//'lkdldjv';
  	$u->checksum = md5($id_user_from.$id_user_to.$u->ad.$Infimena_sec_code);
  	$this->db->insert($this->table_operation, $u);
  	
  	return true;
  }
  function comis($id_user, $comis, $order_id=0){

  	$to_infomena = $comis * 0.4;
  	$to_parent = $comis * 0.4;
  	$to_parent_parent = $comis * 0.1;
  	$to_fond = $comis * 0.1;
  	
  	//$mynet = $this->comunity_model->MyNetwork($id_user);
  	$mynet = $this->data['UserNet'];
  	$this->f1($id_user, $this->purses_model->getval('InfomenaId'), $to_infomena, 'comis', $order_id);
  	if(!empty($mynet['parent']))
  		$this->f1($id_user, $mynet['parent']['id'], $to_parent, 'comis', $order_id);
  	if(!empty($mynet['parent']['parent']))
  		$this->f1($id_user, $mynet['parent']['parent']['id'], $to_parent_parent, 'comis', $order_id);
  	else $this->f1($id_user, $this->purses_model->getval('InfomenaId'), $to_parent_parent, 'comis', $order_id);
  	
  	$this->f1($id_user, $this->purses_model->getval('FondId'), $to_fond, 'comis', $order_id);
  }
  
  function getUserPurseId($user_id){
  	$this->db->from($this->table_purses);
  	$this->db->where('id_user',$user_id);
  	$query = $this->db->get();
  	$result = $query->row();
  	if(isset($result->id)) return $result->id;
  	return false;
  }
  function getUserPurse($user_id){
  	$this->db->from($this->table_purses);
  	$this->db->where('id_user',$user_id);
  	$query = $this->db->get();
  	$result = $query->row();
  	if(!empty($result)) return $result;
  	return false;
  }

function present($user_id, $type){
	if(empty($user_id)||$user_id == $this->InfomenaId) return false;
	if($type == 'reg'){
		$info_reg = $this->config_model->getConfigName('info_reg',$this->data['lang']);
		$this->f1($this->InfomenaId, $user_id, $info_reg, 'reg');
	return true;}
	if($type == 'predl'){
		if( 5 >= $this->config_model->cnt($this->table_catalog, array('type'=>'predl', 'user'=>$user_id))){
			$this->f1($this->InfomenaId, $user_id, 2, 'predl5');		
		}
	return true;}
	if($type == 'spros'){
		if( 5 >= $this->config_model->cnt($this->table_catalog, array('type'=>'spros', 'user'=>$user_id))){
			$this->f1($this->InfomenaId, $user_id, 2, 'spros5');
		}
	return true;}
	if($type == 'addfriend'){
			$this->f1($this->InfomenaId, $user_id, 10, 'addfriend');
	return true;}
//	$this->f1($this->InfomenaId, $user_id, $info, $type);
}

public function getval($name){
	if(isset($this->$name))
		return $this->$name;
	return false;
	}
}    

?>