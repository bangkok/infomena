<?php
@include_once("base.php");

class Messages extends Base
{
	function __construct()
	{
		parent::Base();
		$this->load->model('messages_model');
		$this->fields=$this->config_model->fields();
/*		
		$temp = $this->auth_model->getUser($this->data['auth']['login']);
		$user_id = $temp->id;
		//$cnt->all = $this->messages_model->GetMessages($user_id,'CNT');
		$cnt->new = $this->messages_model->GetMessages($user_id,'CNT',0, array($this->messages_model->getval('table').".new"=>0));		
*/		
		$this->data['BussinesMenu'] = $this->config_model->getMenuByMarker('my_communication_menu');
//		echo $this->data['BussinesMenu']['child'][86]['name'].="($cnt->new)";
		$this->data['BussinesMenu'] = $this->load->view('block/bussinesmenu.php', $this->data, true);
		$this->data['Content']['text'] = $this->data['BussinesMenu'];	
		
	}
	function _remap()
    {
      if(($uri=$this->uri->segment(4))!=''){
           if(method_exists($this, $uri)) $this->$uri();
           //else $this->norun();}
           else $this->index();}
      else $this->index();
    }
    	
	function index(){
		$id = $this->uri->segment(4);
		$table = $this->messages_model->getval('table');
		$content['user'] = $temp = $this->auth_model->getUser($this->data['auth']['login']);
		$user_id = $temp->id;
		if(!empty($_POST['del']) && is_array($_POST['del'])){
			foreach ($_POST['del'] as $del_id) $this->messages_model->delMessage($del_id, $user_id);
			//print_r($_POST);
		}
		$content['cnt']->all = $this->messages_model->GetMessages($user_id,'CNT');
		//$content['cnt']->new = $this->messages_model->GetMessages($user_id,'CNT',0, array($this->messages_model->getval('table').".new"=>0));
		$content['cnt']->new = $this->messages_model->GetMessages($user_id,'CNT',0, array($table.".new"=>0, $table.".user_to"=>$user_id));
		if(!empty($id) && is_numeric($id)){
			$content['messages'] = $this->messages_model->GetMessages($user_id,0,0, array($table.".id"=>$id));
			if(!empty($content['messages']) && $content['messages'][0]->user_to == $user_id && $content['messages'][0]->new == 0) {
				$this->messages_model->readCheck($id);
				$content['messages'][0]->new =1; $content['cnt']->new--;}
			$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/messages', $content, TRUE);
		}elseif ($id == 'onlinew'){
			$content['messages'] = $this->messages_model->GetMessages($user_id,0,0, array($table.".new"=>0,	$table.".user_to"=>$user_id));
			$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/messages', $content, TRUE);	
		}else{
			$content['messages'] = $this->messages_model->GetMessages($user_id);
			$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/messages', $content, TRUE);	
		}
		//$this->data['Content']['name'] = "Сообщения";
		$this->load->view('pagesites', $this->data);		
	}

	function newmess($id='')
	{
		$this->load->library('validation');
		$this->lang->load('validation',$this->data['lang']);
		$this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		$this->load->model('members_model');
		$id = $this->uri->segment(5);
		
		$temp = $this->auth_model->getUser($this->data['auth']['login']);
		$content['my'] = $this->members_model->GetUser($temp->id);
		if(!$content['user'] = $this->members_model->GetUser($id)){
		  	$temp = $this->auth_model->getUser($this->data['auth']['login']);
		  	$content['user'] = $this->members_model->GetUser($temp->id);
	  	}
	  	$rules['theme'] =  "trim|required|max_length[255]|xss_clean";
		$rules['message'] = "trim|required|xss_clean";
		//print_r($content['user']);
		$content['fields'] = $this->fields;
		$this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
	    $this->validation->set_rules($rules);
	    
	    if ($this->validation->run() != FALSE && $this->input->post("send") != ""){
	    	if(!empty($content['my']->id) && !empty($content['user']->id))
	    	$msgid = $this->messages_model->addMessage($content['my']->id,$content['user']->id);
	    	//echo "ok!";
	    	//$this->validation = false;
	    	header("location:/mess/".$msgid);
	    }
		
		$content['status']	= $this->auth_model->status();
		$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
		

		$this -> counter_model -> cntHisLots($content['user'] -> id);
		$this -> counter_model -> fillMenuOfCnt();
		$this -> data['Menu'] = $this -> config_model -> getMenuByMarker('members_area_menu');
		$this -> config_model -> menulink($this -> data['Menu']['child'], $content['user'] -> id);

		if(!empty($content['user']->nickname)) $this->data['Menu']['name'] = str_replace('участника',$content['user']->nickname, $this->data['Menu']['name']);
		//print_r($this->data['Menu']);
		//$this->data['Content']['text']= $this->load->view($this->data['papka'].'/member', $content, TRUE);
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/newmess', $content, TRUE);
		$this->data['Content']['name'] = "Сообщения";
		$this->load->view('pagesites', $this->data);
	}
	
	
	
function framing($arr, $pred='', $post=''){
	foreach ($arr as &$elem)
		if(is_string($elem)) $elem = $pred.$elem.$post;
return $arr;
}	
}
?>