<?php
//define('APPPATH',$_SERVER['DOCUMENT_ROOT']."system/application/");
include_once("base.php");
class Cron extends Base {

	function __construct()
    	{
        	parent::Base();
        	$this->load->model('horo_model');
    	}
	function _remap()
    {
      if(($uri=$this->uri->segment(2))!='' || $uri=$_GET['seg']!=''){
           if(method_exists($this, $uri)) $this->$uri();
           //else $this->norun();}
           else $this->index();}
      else $this->index();
    }
	function index()
	{
		$this->lang->load('horo', $this->data['lang']);
		$this->horo_model->send_horo_mail_all_users();
	}
	function rating(){
		$sub= 2;
		$utable = $this->auth_model->getval('table');
		$urating = $this->auth_model->getval('rating');
		$this->db->where("activated",'y');
		$query = $this->db->get($utable);
		$members= $query->result();
		//print_r($res);
		//$data = 
		foreach ($members as $user){
			if((time()- strtotime($user->last_login))/60/60 > 48){
				$this->db->update($utable, array($urating=>$user->$urating-$sub, 'up'=>date("Y-m-d H:i:s")),'id='.$user->id);
			}
			//echo "<br>".$ltime = strtotime($user->last_login);
			//echo "<br>".$sec = (time()- $ltime)/60/60/24;
			//echo "<br>".$dey = date('d')- date('d',$ltime);
			
			//if( )
		}
		
		
	}
	
}
?>