<?
class Comunity_model extends Model 
{ 
	var $LMap;
	var $LMarker;
	var $TMap;
			
	function Comunity_model(){ parent::Model();
	
		$u_table = $this->u_table	= $this->auth_model->getval('table');
		$u_avatar = $this->u_avatar = $this->auth_model->getval('avatar');
		$this->db->select("$u_table.*");
		$this->db->where("$u_table.dl" , 'n');
		$this->db->where("$u_table.activated" , 'y');
		
		$this->db->select("geo_country.title AS country, geo_region.title AS region, geo_town.title AS town,");
		$this->db->join('geo_country', "geo_country.id = $u_table.country", "LEFT");
		$this->db->join('geo_region', "geo_region.id = $u_table.region", "LEFT");
		$this->db->join('geo_town', "geo_town.id = $u_table.town", "LEFT");
				
		$this->db->orderby("$u_table.parent_id" , 'asc');
		//$this->db->orderby("$table.sort" , 'desc');
		//$this->db->orderby("$table.id" , 'asc');
		$query=$this->db->get($u_table);

		$result = $query->result();	

		foreach ($result as $row){
			$LMap[$row->id] =	$row->parent_id;}
		foreach ($result as $row){
			$item['id'] = $row->id;
			$item['upId'] = $row->parent_id;
			$item['user'] = $row;
				
			$CurTMapItem = &$TMap[$item['upId']][$item['id']];
			if(!isset($TMap[$item['id']])) $TMap[$item['id']] = NULL;
		//адресс массива елементов upId которых = id => ['id']['child']
			$item['child'] = &$TMap[$item['id']];
			$item['dom'] = &$TMap[$item['upId']];
			$CurTMapItem = $item;
			if(isset($LMap[$item['upId']])){
				$CurTMapItem['parent'] = &$TMap[$LMap[$item['upId']]][$item['upId']];
			}
		 }
		 $this->LMap = $LMap;
		$this->TMap = $TMap = array_diff($TMap, array(NULL));	// Удалить все пустые(NULL) элементы	
	}
	function MyNetwork($id=1)
	{

		return !empty($this->TMap[$this->LMap[$id]][$id]) ? $this->TMap[$this->LMap[$id]][$id] : array();
		
	}

	function cntNetwork($user_id)
	{
		$MyNetwork = $this->MyNetwork($user_id);

		if ( $count = count($MyNetwork['child']) ) {

			foreach($MyNetwork['child'] as $line1) {

				$count += count($line1['child']);

			}
		}

		return $count;

	}

	function ratingNetwork($user_id)
	{
		$MyNetwork = $this->MyNetwork($user_id);

		$rating = $MyNetwork['user'] -> rating;

		if( !empty($MyNetwork['child']) ) foreach($MyNetwork['child'] as $line1) {

			$rating += $line1['user'] -> rating;

			if( !empty($line1['child']) ) foreach ($line1['child'] as $line2) {

				$rating += $line2['user'] -> rating;

			}
		}
		
		return $rating;
	}

	function Comunity($conditions = array(), $col=0,$from=0, $order=array()){
		$u_table = $this->u_table;
		$u_avatar = $this->u_avatar;
		
		$this->db->select("$u_table.*");
		$this->db->where("$u_table.dl" , 'n');
		$this->db->where("$u_table.activated" , 'y');
		
		$this->db->select("geo_country.title AS country, geo_region.title AS region, geo_town.title AS town,");
		$this->db->join('purses', "purses.id_user = $u_table.id", "LEFT");
		$this->db->join('geo_country', "geo_country.id = $u_table.country", "LEFT");
		$this->db->join('geo_region', "geo_region.id = $u_table.region", "LEFT");
		$this->db->join('geo_town', "geo_town.id = $u_table.town", "LEFT");

		$this->db->orderby("$u_table.amount" , 'asc');

		//$this->db->orderby("purses.info" , 'desc');
		//$this->db->orderby("$u_table.ad" , 'desc');

		//$this->db->orderby("$u_table.receipts" , 'desc');
		//$this->db->orderby("$u_table.rating" , 'desc');
		//$this->db->orderby("$table.sort" , 'desc');
		//$this->db->orderby("$table.id" , 'asc');

		if(is_array($order))
			foreach ($order as $key => $value)
				$this->db->order_by($key, $value);

		if(is_array($conditions))
			foreach ($conditions as $key => $value)
				$this->db->where($key, $value);	
		
		if($col>0)
			$this->db->limit($col,$from);

				
		$query=$this->db->get($u_table);

		$result = $query->result();

		foreach ($result as &$member) {

			$member -> net_rating = $this -> ratingNetwork($member -> id);
			
			$member -> cnt_net = $this -> cntNetwork($member -> id);
		}

		return $result;
	}	

function tprint($DOM=null, $ret=false){
	$out = $this->recprint($DOM);
	$out = '<div style="float:left; text-align:left">'.$out.'</div><div style="clear:both">';
	if($ret) return $out;
	else echo $out;
}
function recprint($DOM=null, $out='', $tab=''){
	if(empty($DOM)) $DOM = $this->TMap[0];
	foreach ($DOM as $item){
		$out.= $tab.'['.$item['id'].'] '.$item['user']->nickname." {<br>\n";
		foreach ($item as $key => $val) @$out.= $tab."&nbsp;&nbsp;&nbsp;&nbsp;[$key] => $val<br>\n"; 
		$out.= $tab."}<br>\n";
		if(!empty($item['child'])) $out= $this->recprint($item['child'], $out, $tab."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	}
	return $out;	
} 

}

?>