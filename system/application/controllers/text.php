<?php
@include_once("base.php");

class text extends Base
{
	function __construct()
	{
		parent::Base();
	}
	
	
	function index()
	{
		//if(''== $this->uri->uri_string())
       //header("Location: /about");
       	$this->data['ShowMenuLeft'] = true;
       	$this->data['ShowCatalog'] = true;
		$this->load->view('pagesites2', $this->data);
	}
	
	
}
?>