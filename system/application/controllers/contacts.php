<?php
@include_once("base.php");


class Contacts extends Base
{
 function __construct()
   {
    parent::Base();
    $this->load->model('contacts_model');
    $this->load->library('validation');
    $this->data['Styles'] .= $this->AddStyle('forms');
   }

function _remap()
    {
      if(stristr($this->uri->uri_string(),'captcha'))
           $this->captcha();
      else $this->index();
    }

function index() {
	
    $content['message']='';
    $this->load->helper(array('form', 'url'));
    //$this->load->library('validation');
    $this->lang->load('forma',$this->data['lang']);
    $this->lang->load('validation',$this->data['lang']);
    $this->fields=$this->config_model->fields();
    
	// fields verify
	$rules['fio']     = "trim|required|alpha|min_length[3]|max_length[255]|xss_clean";
	$rules['mail']    = "trim|required|valid_email";	
	$rules['phone']   = "numeric|min_length[5]|max_length[15]";
    $rules['message'] = "trim|required|min_length[3]|max_length[500]";
    $rules['captcha'] = "required|callback_check_captcha";
   
    $content['fields'] = $this->fields;
    
	//print_r($content['user']);
    
    $this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
   
    $this->validation->set_error_delimiters('<div class="report_form">', '</div>');
    
    if ($this->validation->run() != FALSE && $this->input->post("send") != "")
    { 
 	  $content['message']=$this->contacts_model->Record($this->config_model->getConfigName('mail','all'),$content['fields']);
 	  $this->validation=false;
    }elseif(!$this->input->post("send")){
		$this->load->model('members_model');
		if($temp = $this->auth_model->getUser($this->data['auth']['login'])){
			$user = $this->members_model->GetUser($temp->id);
			$this->validation->fio	= $user->{$this->auth_model->getval('fio')};
			if(empty($this->validation->fio))
				$this->validation->fio	= $user->{$this->auth_model->getval('nickname')};
			$this->validation->mail	= $user->{$this->auth_model->getval('email')};
			$this->validation->phone= $user->{$this->auth_model->getval('tel')};
		}
    }
    

	$this->data['ShowCatalog'] = true;  	
    $content['contacts']=$this->config_model->getConfigName('contacts',$this->data["lang"]);
    $this->data['Content']['text'] = $this->load->view($this->data['papka'].'/contacts', $content, true);
    $this->load->view('pagesites2', $this->data);
    
  }
function framing($arr, $pred='', $post=''){
	foreach ($arr as &$elem)
		if(is_string($elem)) $elem = $pred.$elem.$post;
return $arr;
}

}?>
