<?php
class Counter_model extends Model
{
const MY_PREFIX		= 'my_';
const HIS_PREFIX	= 'his_';

public $cnt = array();


function __construct()
{
	parent::Model();
	
	$this -> load -> model('catalog_model');
	$this -> load -> model('messages_model');
	$this -> load -> model('comments_model');
	$this -> load -> model('comunity_model');
	$this -> load -> model('checks_model');

	if( !empty($this->data['authed']) ) {
		if( !isset($this -> auth_model -> user_id) ) {

			$this -> auth_model -> getUser($this -> data['auth']['login']);
		}

		$this -> user_id = $this -> auth_model -> user_id;
		
	}
}

function setCntIntoMenu()
{
	if( empty($this -> cnt) && !empty($this -> user_id) ) {

		$this -> cntLots();

		$this -> cntMessages();

		$this -> cntComments();

		$this -> cntNetwork();

		$this -> cntChecksTo();
	}

	$this -> fillMenuOfCnt();

}

function fillMenuOfCnt(array $filter = array('all'))
{
	$cnt = array();

	if( $filter == array('all') ) {

		$cnt = $this -> cnt;

	} else {

		foreach ($filter as $marker) {

			if( isset($this -> cnt[$marker]) ) {

				$cnt[$marker] = $this -> cnt[$marker];
			}
		}

	}


	foreach ($cnt as $marker => $value) {

		if( isset($this -> data['LMarker'][$marker]) ) {

			foreach ($this -> data['LMarker'][$marker] as $id) {

				$this -> data['TMenu'][ $this -> data['LMenu'][$id] ][ $id ] ['cnt'] = $value;
			}
		}
	}

}

function cntLots()
{
	$poles = array('type'=>'predl','user'=>$this -> user_id, 'dl'=>'n');

	$this -> cnt[self::MY_PREFIX.'predl'] = $this -> catalog_model -> Cnt($poles);


	$poles = array('type'=>'spros','user'=>$this -> user_id, 'dl'=>'n');

	$this -> cnt[self::MY_PREFIX.'spros'] = $this -> catalog_model -> Cnt($poles);


	$poles = array('type'=>'predl', 'DATE_FORMAT(catalog.ad,"%Y-%m-%d") = DATE_FORMAT(NOW(),"%Y-%m-%d")');

	$this -> cnt['predl_of_day'] = $this->catalog_model->Cnt($poles);


	$poles = array('type'=>'spros', 'DATE_FORMAT(catalog.ad,"%Y-%m-%d") = DATE_FORMAT(NOW(),"%Y-%m-%d")');

	$this -> cnt['spros_of_day'] = $this->catalog_model->Cnt($poles);

}

function cntHisLots($user_id)
{
	$poles = array('type'=>'predl','user'=>$user_id, 'dl'=>'n');

	$this -> cnt[self::HIS_PREFIX.'predl'] = $this -> catalog_model -> Cnt($poles);


	$poles = array('type'=>'spros','user'=>$user_id, 'dl'=>'n');

	$this -> cnt[self::HIS_PREFIX.'spros'] = $this -> catalog_model -> Cnt($poles);

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

function cntNetwork()
{

	$this -> cnt[self::MY_PREFIX.'network'] = $this->comunity_model->cntNetwork($this -> user_id);

}

function cntChecksTo(){

	$this -> cnt[self::MY_PREFIX.'checks']  = $this -> checks_model -> cntChecksTo($this -> user_id);

}

    
}
?>
