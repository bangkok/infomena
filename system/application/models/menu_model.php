<?php
class Menu_model extends Model
{
public $cnt = array();

function __construct()
{
	parent::Model();
	
	$this -> load -> model('catalog_model');
	$this -> load -> model('messages_model');
	$this -> load -> model('comments_model');

	if( !isset($this -> auth_model -> user_id) )
		$this -> auth_model -> getUser($this -> data['auth']['login']);
	$this -> user_id = $this -> auth_model -> user_id;
}

function setCntIntoMenu(&$menu = null)
{
	if( empty($this -> cnt) ) {

		$this -> cntLots();

		$this -> cntMessages();

		$this -> cntComments();

	}

	//if ( !$menu ) $menu = $this -> data['TMenu'];

	foreach ($this -> cnt as $marker => $value) {

		if( isset($this -> data['LMarker'][$marker]) ) {

			foreach ($this -> data['LMarker'][$marker] as $id) {

				$this -> data['TMenu'][ $this -> data['LMenu'][$id] ][ $id ] ['cnt']
					 = $value;
				echo "<br>".$marker." ".$value."<br>";

			}

		}


	}
}

function cntLots()
{
	
	$poles = array('type'=>'predl','user'=>$this -> user_id, 'dl'=>'n');

	$this -> cnt['my_predl'] = $this -> catalog_model -> Cnt($poles);


	$poles = array('type'=>'spros','user'=>$this -> user_id, 'dl'=>'n');

	$this -> cnt['my_spros'] = $this -> catalog_model -> Cnt($poles);

}

function cntMessages()
{

	$table = $this->messages_model -> getval('table');

	$this -> cnt['messages'] = $this->messages_model->GetMessages(
		$this -> user_id, 'CNT', 0, array($table.".new"=>0, $table.".user_to"=>$this -> user_id)
	);

}
    
function cntComments()
{
	
	$this -> cnt['comments'] = $this -> comments_model -> CntUserComments($this -> user_id);

}

    
}
?>
