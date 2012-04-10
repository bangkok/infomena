<?
class Catalog_model extends Model 
{ 
	
	private $table_razdel = 'cat_razdel';
	private $table_catalog = 'catalog';
	private $table_cat_img = 'cat_img';
	private $table_cat_status = 'cat_status';
	private $table_valuta = 'valuta';
	private $table_cur = 'cur_exchange';
	private $table_purses = 'purses';
	private $catcomments = 'catcomments';
	
	
  function Catalog_model()  {   
		parent::Model();   
		$this->comis = ($this->config_model->getConfigName('comis') / 100);
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
   
  function getCatalog($conditions=null, $lang='no')
  {
  	$where = '';
  	//$conditions = array("type"=>'spros');
  	if(!empty($conditions))
  		foreach ($conditions as $key=>$val) $where .= " AND $key = '$val'";
  	$this->db->select("*, (SELECT COUNT(*) FROM $this->table_catalog 
  		WHERE ($this->table_catalog.razdel = $this->table_razdel.id AND $this->table_catalog.dl = 'n') $where) as num");
  	$this->db->orderby("sort" , 'asc');
  	$query=$this->db->get($this->table_razdel);
  	$result = $query->result();
  	return $result;

  }

  
	function insert($user_id,$poles){
	
		$u = $this->datapost($poles);
		//$u->{$this->auth_model->getval('login')} = $user_id;
		$u->user = $user_id;
		$u->ad = date("Y-m-d H:i:s");
		//print_r($u);
		$this->db->insert($this->table_catalog, $u);
		return mysql_insert_id();
	}
	
   	function update($table, $conditions, $poles)
    { if(empty($table)) $table = $this->table_catalog;
    
		$this->db->from($table);
		if(is_array($conditions))
			foreach ($conditions as $key => $value)
				$this->db->where($key, $value);
		if(!$this->db->count_all_results()) return false;
		
    	$u = $this->datapost($poles);
		if(is_array($conditions))
			foreach ($conditions as $key => $value)
				$this->db->where($key, $value);
		
        $r= $this->db->update($table, $u);
    
       	return $r;
       
    }
	function Cnt($poles=null){

		$this->db->from($this->table_catalog);
		$this->db->where("$this->table_catalog.dl", "n");
		if(is_array($poles))
			foreach ($poles as $key => $value)
			if(is_numeric($key))
						$this->db->where($value);
				else	$this->db->where($key, $value);	

		return  $this->db->count_all_results();
	}
	function Get($conditions = array(), $col=0,$from=0, $order=array()){		
		//echo 'col='.$col.'from='.$from.'<br>';
		$u_table = $this->auth_model->getval('table');
		$u_id = $this->auth_model->getval('id');
		$u_nickname = $this->auth_model->getval('nickname');
		$u_avatar = $this->auth_model->getval('avatar');
		
		$this->db->select("$this->table_catalog.*, $this->table_catalog.id AS id");
		$this->db->select('date_format('.$this->table_catalog.'.ad, \'%d.%m.%Y\') AS ad',FALSE);
		$this->db->select('date_format('.$this->table_catalog.'.breack_date, \'%d.%m.%Y\') AS breack_date',FALSE);
	//COMISIYA	
	
		//if(isset($conditions['type'])&& $conditions['type']== 'predl') 
			//$this->db->select("$this->table_catalog.price_info * $this->comis as cost");
		//$this->db->select("CASE $this->table_catalog.peri WHEN 0 THEN 100 ELSE peri END as peri");
		$this->db->select("CASE $this->table_catalog.type WHEN 'predl' THEN $this->table_catalog.price_info * (1+($this->comis /(peri/100))) ELSE price_info END AS cost ");
		
		$this->db->select("CASE $this->table_catalog.type WHEN 'spros' THEN (price_info/(1+($this->comis/(peri/100))) ) ELSE price_info END AS cost_info");
		//KURS
		$this->db->select("$this->table_cur.koef as koef");
		//$this->db->select("ROUND($this->table_catalog.price_info / koef * (100- peri)/peri ,'2') AS price_cash");
		/*
		$this->db->select("CASE $this->table_catalog.type WHEN 'predl' THEN 
			(price_info / koef * (100- peri)/peri ) ELSE
			(price_info / koef * (100- peri)/peri ) END AS price_cash");
		*/
		$this->db->select("$this->table_catalog.price_info / koef * (100- peri)/peri AS price_cash");
		$this->db->select("CASE $this->table_catalog.type WHEN 'predl' THEN 
			(price_info * $this->comis /(peri/100)) ELSE
			(price_info * $this->comis/($this->comis + (peri/100)) ) END AS comis");
		
		$this->db->join($this->table_cur, "$this->table_cur.id  = $this->table_catalog.valuta", "LEFT");
	//USER
		$this->db->select("$u_table.$u_nickname AS nickname, $u_table.$u_avatar AS avatar, $u_table.rating AS urating");
		$this->db->join($u_table, "$u_table.$u_id  = user", "LEFT");
		
		$this->db->select("geo_country.title AS country, geo_region.title AS region, geo_town.title AS town,");
		$this->db->join('geo_country', "geo_country.id = $u_table.country", "LEFT");
		$this->db->join('geo_region', "geo_region.id = $u_table.region", "LEFT");
		$this->db->join('geo_town', "geo_town.id = $u_table.town", "LEFT");
	//PURSES	
		$this->db->select("$this->table_purses.info as info");
		$this->db->join($this->table_purses, "$this->table_purses.id_user = $u_table.id", "LEFT");
		
	//CATALOG STATUS
		$this->db->select("CASE $this->table_catalog.status WHEN -1 THEN $this->table_catalog.status_self ELSE $this->table_cat_status.name END AS status_name ");
		$this->db->join($this->table_cat_status, "$this->table_cat_status.id = $this->table_catalog.status","LEFT");
	//RAZDEL
		$this->db->select("$this->table_razdel.title AS razdel_title");
		$this->db->join($this->table_razdel, "$this->table_razdel.id = razdel","LEFT");
	//CAT IMAGE
		$this->db->select("$this->table_cat_img.image AS image, $this->table_cat_img.prevue as prevue, $this->table_cat_img.sort AS sort");
		$this->db->join($this->table_cat_img, "$this->table_cat_img.pos = $this->table_catalog.id","LEFT");
	//VALUTA
		$this->db->select("$this->table_valuta.name AS valuta_name");
		$this->db->join($this->table_valuta, "$this->table_valuta.id = $this->table_catalog.valuta","LEFT");
		
	//COMMENTS
		$this->db->select("(SELECT COUNT(*) FROM $this->catcomments WHERE $this->catcomments.pos = $this->table_catalog.id ) as numcatcomments");
	
		
		
	//SORT
		if(is_array($order))
			foreach ($order as $key => $value)
				$this->db->order_by($key, $value);
		$this->db->order_by("$this->table_catalog.rating", 'DESC');
		$this->db->order_by("$this->table_catalog.ad", 'DESC');
		$this->db->order_by("$this->table_cat_img.sort", 'DESC');
		
		if( !(!empty($this->data['Hacks']['ShowDelitedLots']) && $this->data['Hacks']['ShowDelitedLots']) )
			$this->db->where("$this->table_catalog.dl", "n");
		if(is_array($conditions))
			foreach ($conditions as $key => $value)
				if(is_numeric($key))
						$this->db->where($value);
				else	$this->db->where($key, $value);	
		
		$this->db->from($this->table_catalog);
		$this->db->group_by('id');

		if($col>0)
			$this->db->limit($col,$from);
		$query=$this->db->get();
		
		$result = $query->result();
		foreach ($result as &$row) {
			$row->comis = round($row->comis,2);
			$row->cost = round($row->cost,2);
			$row->cost_info = round($row->cost_info,2);
			$row->price_cash = round($row->price_cash,2);}
		return $result;
	}
	function images($pos){
		$pole = 'prevue';
		$table='nrfl';
		$this->db->select("$this->table_cat_img.*, $table.flim_fnm as file_name");
		$this->db->join($table, "$this->table_cat_img.$pole = $table.flid","LEFT");
		$this->db->where('pos', $pos);
		$query=$this->db->get($this->table_cat_img);
		return $query->result();
	}
/*	
	function lastpredl($from=0,$col=0){
		$this->db->select("$this->table_catalog.*, $this->table_catalog.id as id");
		$this->db->select("$this->table_catalog.price_info * $this->comis as price_info",FALSE);
		
		$this->db->select("$this->table_cat_img.image as image, $this->table_cat_img.prevue as prevue, $this->table_cat_img.sort as sort");
		$this->db->join($this->table_cat_img, "$this->table_cat_img.pos = $this->table_catalog.id","LEFT");
		
		$this->db->where('type', 'predl');
		$this->db->order_by("$this->table_catalog.ad", 'desc');
		$this->db->group_by('id');
		if($col>0) $this->db->limit($col,$from);
		if($query=$this->db->get($this->table_catalog))
			return $query->result();
		return false;
	}
	function lastspros($from=0,$col=0){
		
		$u_table = $this->auth_model->getval('table');
		$u_id = $this->auth_model->getval('id');
		$u_nickname = $this->auth_model->getval('nickname');
		$u_avatar = $this->auth_model->getval('avatar');
		
		$this->db->select("$this->table_catalog.*, $this->table_catalog.id as id");
		
		$this->db->select("$u_table.$u_nickname as nickname, $u_table.$u_avatar as avatar");
		$this->db->join($u_table, "$u_table.$u_id  = user", "LEFT");
		
		$this->db->select("$this->table_razdel.title as razdel_title");
		$this->db->join($this->table_razdel, "$this->table_razdel.id = razdel","LEFT");
		
		$this->db->select("$this->table_cat_img.image as image, $this->table_cat_img.prevue as prevue, $this->table_cat_img.sort as sort");
		$this->db->join($this->table_cat_img, "$this->table_cat_img.pos = $this->table_catalog.id","LEFT");
		
		$this->db->where('type', 'spros');
		$this->db->order_by("$this->table_catalog.ad", 'desc');
		$this->db->group_by('id');
		if($col>0)	$this->db->limit($col,$from);
		if($query=$this->db->get($this->table_catalog))
			return $query->result();
		return false;
	}
	
*/
  function getValutes(){
  	$this->db->join('cur_exchange', "cur_exchange.to = valuta.id","LEFT");
	return $this->config_model->table('valuta',array('valuta.id!='=>1),array('sort'=>'desc','valuta.id'=>'asc'));
  }
  function getSector($id=0, $lang='no'){
  	
 		$this->db->where("visible" , 'y');
  		$this->db->where("upId" , $id);		
		$this->db->orderby("upId" , 'asc');
		$this->db->orderby("sort" , 'asc');
		$query=$this->db->get('catalog');

       return  $result = $query->result(); 	
  }
  
  function recCompanysSql($CUR)
  {
  	$sql = ' OR catalog.upId = '.$CUR['id'];
	foreach ($CUR['child'] as $item)	
		if(isset($item['child'])) $sql .= $this->recCompanysSql($item);
	return $sql;
  }	
  
  function getCompanies($sector=1, $from = 0,  $col = 0, $lang='no')
  {
//$time = microtime();
//*/		
		$TMap = &$this->data['Catalog']['TMap'];
		$LMap = &$this->data['Catalog']['LMap'];
		$CUR = $TMap[$LMap[$sector]][$sector];
		
		$sql = "SELECT DISTINCT
				companies.id as id, 
				companies.title as title, 
				companies.address as address, 
				companies.content as content, 
				companies.contacts as contacts,
				companies.image as image
				
			FROM  catalog
			LEFT JOIN compmap ON catalog.id = compmap.sectorId 
			RIGHT JOIN companies ON (companies.sectorId = catalog.id OR companies.id = compmap.compId) 
									AND companies.sleep = 'y' AND catalog.visible = 'y'
			
			WHERE compmap.sectorId = ".$CUR['id']." OR companies.sectorId = ".$CUR['id'];	
//*	Показывать дочерние предприятия
		if (isset($CUR['child'])){
			$sql .= ' OR catalog.upId = '.$CUR['id'];
//* Закоментировать если не нужно отображать всю ветку			
			foreach ($CUR['child'] as $item)
				if(isset($item['child'])) $sql .= $this->recCompanysSql($item);
		}
//*/
		$sql .= ' ORDER BY companies.title'; // GROUP BY companies.id
		
		$query = $this->db->query($sql);
		$this->data['Catalog']['cnt'] = $query->num_rows();
		
		$sql .= " LIMIT $from,$col";
		$query = $this->db->query($sql);
		
		//echo $query->num_rows();
//$time2 = microtime(); echo $time2 - $time;

		$result = $query->result();
//print_r($result);
         return $result;
  	
  }
  
  
  function getCompanyText($Comp_id,  $lang='no')
  {
  	
	$this->db->select("companies.content as content , companies.title as title");
	$this->db->where("companies.id" , $Comp_id);		
	$this->db->where("sleep" , 'y');
	$query=$this->db->get('companies');
	$result = $query->result();
	//print_r($result);
	if (isset($result['0']))
		return $result['0'];
	else return false;
  }
  
// =========================================
public function getval($name){
		if(isset($this->$name))
			return $this->$name;
		return false;
	}	
}    

?>