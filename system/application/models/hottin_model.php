<?
class Hottin_model extends Model 
{ 
		
  function Hottin_model()  {   parent::Model();   
  
  
  }
  
  function gettin(){
$InfomenaId = 1;
$FondId = 2;
$utable = 'members';
$table_catalog = 'catalog';
$table_transaction = 'transaction';	 

$sql = "SELECT  *,nickname, id, parent_id, (SELECT SUM(info) FROM $table_transaction WHERE id_user_to = $utable.id ) AS sum  FROM ".$utable." WHERE activated = 'y'";
//$sql = "SELECT  *,nickname, id, parent_id, (SELECT SUM(info) FROM $table_transaction WHERE id_user_to = $utable.id AND $table_transaction.type='order') AS sum  FROM ".$utable." WHERE activated = 'y'";

$query = $this->db->query($sql);
$result = $query->result();

foreach ($result as $row){
	$row->sum1 = $row->sum;
	$users[$row->id] = $row;
	$tusers[$row->parent_id][$row->id] = $row;
}

foreach ($users as &$user){
	if(isset($tusers[$user->id]))
		foreach ($tusers[$user->id] as $child){
			if(isset($tusers[$child->id]))
				foreach ($tusers[$child->id] as $child2)
					$users[$user->id]->sum1 += $child2->sum;
			$users[$user->id]->sum1 += $child->sum;		
		}
}

unset($users[$InfomenaId]);
unset($users[$FondId]);

foreach ($users as $user)
	$temp[$user->sum1] = $user;
krsort($temp);
unset($users);$i=0;
foreach ($temp as $val){
	if($i++ >= 10) break;
	$users[$val->id] = $val;}
	
//print_r($users);
return $users;
	
print_r($users);
unset($users);
 
  }
  
function getchild($users, $parent){$childs = null;
	foreach ($users as $user)
		if($user->parent_id == $parent){
			$childs[] = $user;
		}
	return $childs;
}   
function childsum($users){$sum=0;
	foreach ($users as $user)
		if(!empty($user->sum))
			echo "|".$sum += $user->sum;
	return $sum;
}  


}    

?>