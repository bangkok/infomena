<?php
include_once(APPPATH."libraries/base.php");

class MYAjax extends Base{

	function MYAjax()
	{
		parent::Base();
		
		$this->load->file(APPPATH.'libraries/ajax/JsHttpRequest/JsHttpRequest.php', false);
		$JsHttpRequest =& new JsHttpRequest("UTF-8");
	}

//  AJAX JS class refactor, call method direct	
//	function index()
//	{
//		$JsHttpRequest =& new JsHttpRequest("UTF-8");
//		
//		$method = $this->input->post('method');
//		$param = $this->input->post('param');
//		
//		if (method_exists($this, $method))
//		{
//			$this->$method($param);
//		}
//		else 
//		{
//			$this->sample($param);
//		}		
//
//		exit(); // any other output is not required and is conflicting with AJAX JsHtmlRequestor library
//	
//	}
	
	/**
	 * Sample ajax method
	 *
	 * @param unknown_type $a
	 */
	function sample($str = 'Hello world. Привет.')
	{
//		.print_r($this->uri->uri_string(), true)
		if (!is_string($str))
			$data['text'] = "<pre>".print_r($str, true)."</pre>";
		else
			$data['text'] = $str;
		sleep(2);
		
		$string = $data['text'];
		
		$GLOBALS['_RESULT'] = array(
			"HTML"   => $string
		);
	}
	
	function accessDeny()
	{
		$this->load->file(APPPATH.'libraries/ajax/JsHttpRequest/JsHttpRequest.php', false);
		
		$JsHttpRequest =& new JsHttpRequest("UTF-8");
		
		$user = $this->db_session->userdata('user');
		
		$router =& load_class('Router'); 
		if (substr_count($router->fetch_method(),'Ajax') > 0)
		{
			$string = "Доступ <strong>".$user["username"]."</strong> к странице запрещен.";
			if ($user["username"] == '')
		    	$JSstring = "
					ajax.doLoad({
						block:'menu', 
						method:'userMenuAjax', 
						loadInfo:'<img src=\"/img/indicator.gif\" />',
						param: new Array(''),
						hist: false, 
						infoBlock:'menu', 
						controller:'main',
						callback: function(){
							}
						});  
			    ";
		    else
		    	$JSstring = '';
		        	
			$GLOBALS['_RESULT'] = array(
				"HTML"	=> $string,
				"JS"	=> $JSstring
			);
		}
		else
		{
			parent::accessDeny();
		}
		exit;
		
	}
	
	
	function notExist()
	{
	    $string = 'Данных для загрузки не существует. <h1>404</h1>';
	    $JSstring = '';
	        	
		$GLOBALS['_RESULT'] = array(
			"HTML"	=> $string,
			"JS"	=> $JSstring
		);	
	}	
	
	// hack for set params
	function _remap($m)
	{
		if (substr_count($m,'Ajax') > 0)
		{
			$p = $this->input->post('param');
			
			 unset($_POST);
			 $_POST = null;
			
			if(method_exists($this, $m))
				$this->$m($p);
			else
				$this->notExist();
			exit();
		}
		else
		{
			if(method_exists($this, $m))
			{
				call_user_func_array(array($this, $m), array_slice($this->uri->rsegments, 2));
			}
			else
			{
				show_404('');
			}
		}
	}
}
?>