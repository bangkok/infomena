<?
class Members_model extends Model 
{ 
	
	private $table_members = 'members';

	

  function Members_model()  {   
		parent::Model();   
  }
  
  function GetUser($id){
  	if(empty($id)){
  	$temp = $this->auth_model->getUser($this->data['auth']['login']);
  	$id = $temp->id;
  	}
  	$u_table = $this->auth_model->getval('table');
  	$this->db->select("$u_table.*");
  	$this->db->where("$u_table.id",$id);
  	/*
  	$this->db->select("geo_country.title AS country, geo_region.title AS region, geo_town.title AS town");
	$this->db->join('geo_country', "geo_country.id = $u_table.country", "LEFT");
	$this->db->join('geo_region', "geo_region.id = $u_table.region", "LEFT");
	$this->db->join('geo_town', "geo_town.id = $u_table.town", "LEFT");
		*/
  	$query=$this->db->get($u_table);
  	
  	return $query->row();
  }

// =========================================
public function getval($name){
		if(isset($this->$name))
			return $this->$name;
		return false;
	}	
}    

?>