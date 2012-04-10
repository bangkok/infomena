<?php
@include_once("base.php");


class Addfriend extends Base
{
 function __construct()
   {
    parent::Base();
    $this->load->model('addfriend_model');
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
    $rules['captcha'] = "required|callback_check_captcha";
   
    $content['fields'] = $this->fields;
    
	//print_r($content['user']);
    
    $this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
   
    $this->validation->set_error_delimiters('<div class="report_form">', '</div>');
    
    if ($this->validation->run() != FALSE && $this->input->post("send") != "")
    { 
		$content['message']=$this->addfriend_model->AddFriendMail();
		$this->validation=false;
    }
	  	
    $this->data['contacts']=$this->config_model->getConfigName('contacts',$this->data["lang"]);
    $this->data['Content']['text'] = $this->load->view($this->data['papka'].'/addfriend', $content, true);
    $this->load->view('pagesites', $this->data);
    
  }
function framing($arr, $pred='', $post=''){
	foreach ($arr as &$elem)
		if(is_string($elem)) $elem = $pred.$elem.$post;
return $arr;
}

}?>
