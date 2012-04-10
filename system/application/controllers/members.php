<?php
@include_once("base.php");

class Members extends Base
{
	function __construct()
	{
		parent::Base();
		$this->fields=$this->config_model->fields();
	}
	
	
	function index($id='')
	{
		$this->load->model('members_model');
		$id = $this->uri->segment(2);
		if(!$content['user'] = $this->members_model->GetUser($id)){
		  	$temp = $this->auth_model->getUser($this->data['auth']['login']);
		  	$content['user'] = $this->members_model->GetUser($temp->id);
	  	}

		$content['fields'] = $this->fields;
		$content['status']	= $this->auth_model->status();
		$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
				
		//echo "<pre>".print_r($content['user'],true)."</pre>";
		$this->load->model('comments_model');
		if(!empty($_POST) && !empty($_POST['send']) && !empty($_POST['message'])){
			$temp = $this->auth_model->getUser($this->data['auth']['login']);
			if($this->comments_model->AddUserComment($temp->id))
				$content['message'] = "OK";
		}

		$this -> counter_model -> cntHisLots($content['user']->id);
		$this -> counter_model -> fillMenuOfCnt();

		$content['Comments']= $this->comments_model->getUserComments($content['user']->id);
		$content['CntUserComments'] = $this->comments_model->CntUserComments($content['user']->id);
		
		$this->data['Menu'] = $this->config_model->getMenuByMarker('members_area_menu');
		//print_r($this->data['Menu']);
		$this->config_model->menulink($this->data['Menu']['child'], $content['user']->id);
		//$this->data['Menu']['child'][36]['link'].="/".$content['user']->id;
		if(!empty($content['user']->nickname)) $this->data['Menu']['name'] = str_replace('участника',$content['user']->nickname, $this->data['Menu']['name']);
		//print_r($this->data['Menu']);
		$this->data['Content']['text']= $this->load->view($this->data['papka'].'/member', $content, TRUE);
		$this->data['Content']['name'] = "Обо мне";
		$this->load->view('pagesites', $this->data);
	}
	
	
	
	
}
?>