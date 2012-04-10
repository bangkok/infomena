<?php
include_once("base.php");
class Hottin extends Base {

	function __construct()
    	{
        	parent::Base();
    	}
	
	function index()
	{
		$this->load->model('hottin_model');
		$content['Users'] = $this->hottin_model->gettin(); 
		$this->data['Content']['text'] = $this->load->view('block/hottin', $content, true);
		$this->load->view('pagesites', $this->data);
		
	}
	

}
?>