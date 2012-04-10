<?php
include_once("base.php");
class Horo extends Base {

	function __construct()
    	{
        	parent::Base();
        	$this->load->model('horo_model');
        	$this->lang->load('horo', $this->data['lang']);
    	}
	function _remap()
	{
		if($uri = $this->uri->segment(2)){
			if(method_exists($this, $uri)) 
				$this->$uri();
			else $this->index();}
		else $this->index();        
	}
	
	function index()
	{
		$this->load->helper('horo');
		if(isset($this->data['auth']['old'])){
			$old = strtotime($this->data['auth']['old']);
			$data['sign'] = zodiak(date("n", $old),date("d", $old));
		}
	
		$output='';
		$date = date('Y-m-d');	
		
		
			
		if($data['horo'] = $this->horo_model->get_horo($date))
			$output.= $this->load->view($this->data['papka'].'/horo', $data, true);
			//$output.= "<br>\n<b>".$this->lang->line($sign)."</b><br>\n".$horo[$sign]."<br>\n";
			
		
		
		if(!empty($output))
			$this->data['Content']['text'] = $output;
		
		$this->load->view('pagesites', $this->data);
		
	}
	
		
	function settings()
	{
		if(!(isset($this->data['auth']['login']) && !empty($this->data['auth']['login']))) exit;
		$settings = $this->data['Horo']['defoult_settings'];
		if(isset($_POST['send'])){
			if(isset($_POST['horo'])) //$settings = $_POST['horo'];
				foreach($_POST['horo'] as $key => $item)
					if(isset($settings[$key]))$settings[$key] = $item;
			
			$this->horo_model->set_user_settings($this->data['auth']['login'],$settings);
			if(isset($settings['enabled']) && $settings['enabled'] == 'y')
				$this->horo_model->send_horo_mail($this->data['auth']['login']);
			$data['message'] = $this->lang->line("horo_set_successful");
		}else{
			if(!$settings =  $this->horo_model->get_user_settings($this->data['auth']['login']))
				$settings = $this->data['Horo']['defoult_settings'];
			//else unset($settings['login']);
		}
		
		//$settings['enabled']='y';
		$this->lang->load('forma', $this->data['lang']);
		$data['settings'] =  $settings;
		$data['content']  = $this->data['Content']['text'];

		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/horo_set', $data, true);
		$this->load->view('pagesites', $this->data);
	}
}
?>