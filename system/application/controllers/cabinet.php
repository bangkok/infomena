<?php
@include_once("base.php");

class Cabinet extends Base {
	
	function __construct()
	{
		 parent::Base();
		 $this->load->library('validation');
		 $this->lang->load('forma',$this->data['lang']);
		 $this->lang->load('validation',$this->data['lang']);
		 $this->load->model('auth_model');
	}


	
	function _remap()
    {
      if(($uri=$this->uri->segment(2))!=''){
           if(method_exists($this, $uri)) $this->$uri();
           else $this->norun();}
      else $this->index();
     
    }
   
function norun(){

	//$this->data['Content']['text'] = $this->config_model->getConfigName('no_text',$this->data['lang']);
	$this->load->view('pagesites', $this->data);
}
function index(){
	
	
	$this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/myprofile', '', TRUE);	   

	$this->load->view('pagesites', $this->data);	
//	header("location: /auth/register");
}

function register(){ 

	if(is_array($this->data['auth'])) {header("location: /auth/profile"); }

	$content['message'] = "";
	
	// fields verify
	$rules['fio'] =   "trim|required|min_length[4]|max_length[100]|xss_clean";
	$rules['login'] = "trim|required|min_length[4]|max_length[16]|xss_clean|callback__unique_username";
	$rules['mail'] =  "trim|required|valid_email|callback_unique_email";	
//	$rules['phone'] = "trim|required|numeric|min_length[5]|max_length[15]";
	$rules['pass1'] = "trim|required|matches[pass2]|min_length[4]";
	$rules['pass2'] = "trim|required|min_length[4]";
	$rules['captcha'] = "trim|required|callback_check_captcha";
	$rules['old_y'] =   "trim|required|numeric|min_length[4]|max_length[4]|xss_clean|callback_datey_check";
	$rules['old_m'] =   "trim|required|numeric|min_length[1]|max_length[2]|xss_clean|callback_datem_check";
	$rules['old_d'] =   "trim|required|numeric|min_length[1]|max_length[2]|xss_clean|callback_dated_check";
	$rules['old'] =   "callback_date_check";
	
	
	

	$fields2=$this->config_model->fields();    
    $content['fields']=$fields2;
	
    $fields['fio'] =   "'<b>".$fields2['fio']."</b>'";
//    $fields['foto'] =   "'<b>".$fields2['foto']."</b>'";  
    $fields['login'] = "'<b>".$fields2['login']."</b>'";
    $fields['mail'] =  "'<b>".$fields2['mail']."</b>'";
//    $fields['phone'] = "'<b>".$fields2['phone']."</b>'";	
    $fields['pass1'] = "'<b>".$fields2['pass1']."</b>'";
    $fields['pass2'] = "'<b>".$fields2['pass2']."</b>'";
    $fields['captcha'] = "'<b>".$fields2['captcha']."</b>'";
    $fields['old'] =   "'<b>".$fields2['old']."</b>'";
    $fields['old_y'] =   "'<b>".$fields2['old_y']."</b>'";
    $fields['old_m'] =   "'<b>".$fields2['old_m']."</b>'";
    $fields['old_d'] =   "'<b>".$fields2['old_d']."</b>'";
//    $fields['activation_code'] =   "'<b>".$fields2['activation_code']."</b>'";
    
    $this->validation->set_fields($fields);
    $this->validation->set_rules($rules);
   
    $this->validation->set_error_delimiters('<div class="report_form">', '</div>');
    $this->lang->load('auth',$this->data['lang']);
    
    if ($this->validation->run() != FALSE && $this->input->post("send") != "")
    { 

 	  $this->auth_model->addUser();
   	
		
	  if(!$this->config_model->sendActivationEmail())  $content["message"] = "<div class='report_no'>".$this->lang->line('error_mail')."</div>";
      else    										   $content["message"] = "<div class='report_yes'>".$this->lang->line('mail_good_act')."</div>";
      $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/registered', $content, TRUE);	
 	  
 	  $this->validation=false;
    }
    else   $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/register', $content, TRUE);	   
    
    		
		 
    $this->load->view('pagesites', $this->data);
}

function unique_email($str)
{
	//$this->load->model('auth_model');
		
	if ($this->auth_model->existEmail($str))
	{
		$this->validation->set_message('_unique_email', 'Пользователь с таким %s уже существует');
		return FALSE;
	}
	else
	{
		return TRUE;
	}		
	
}
	
function datey_check($str){
	if($str > date('Y')){
		$this->validation->set_message('datey_check', 'Невозможное значение поля %s');
		return false;}
	return true;
}
function datem_check($str){
	if($str < 1 || $str > 12){
		$this->validation->set_message('datem_check', 'Невозможное значение поля %s');
		return false;}
	return true;
}
function dated_check($str){
	if($str < 1 || $str > 31){
		$this->validation->set_message('dated_check', 'Невозможное значение поля %s');
		return false;}
	return true;
}
function date_check($str){
	$old_y = $this->input->post("old_y");
	$old_m = $this->input->post("old_m");
	$old_d = $this->input->post("old_d");
	if(!empty($old_y) && !empty($old_m) && !empty($old_d))
		if(!checkdate($old_m, $old_d, $old_y)){ 
			$this->validation->set_message('date_check', 'Невозможное значение %s');
			return false;}
	return true;
}

    function activation()
    {
    	if(is_array($this->data['auth'])) {header("location: /auth/profile"); }
    	
    	
		$user = urldecode($this->uri->segment(3));
		$code = $this->uri->segment(4);
	    $content["message"] = "";

	      
	    $fields2=$this->config_model->fields();    
	    $content['fields']=$fields2;
	    
	    $fields['login'] = "'<b>".$fields2['login']."</b>'";
	    $fields['pass'] = "'<b>".$fields2['pass2']."</b>'";
    
	    $this->validation->set_fields($fields);
	    //$this->validation->set_rules($rules);    
	      	
        $this->lang->load('auth',$this->data['lang']);
		$this->auth_model->clearUnactivated();
	    if ($this->auth_model->isActivation($user))
	    {
	    	$content["message"] = "<div class='report_yes'>".$this->lang->line('auth_activ_yes1')."</div >";
	    	$content["regMsg"] = $this->lang->line('auth_activ_yes1');
	    }
	    else if ($this->auth_model->activationUser($user, $code))
	    {
	    	$content["message"] = "<div class='report_yes'>".$this->lang->line('auth_activ_yes2')."</div >";
	    	$content["regMsg"] = $this->lang->line('auth_activ_yes2');
	    }
	   	else
	   	{
	    	$content["message"] = "<div class='report_no'>".$this->lang->line('auth_activ_no')."</div>";
	    	$content["regMsg"] = $this->lang->line('auth_activ_no');
	   	}
	    //$this->data['auth']=$content["authed"];
 	    $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/activation', $content, TRUE);	    
	    
	    $this->load->view('pagesites', $this->data);
    }
    
    
	
    
function login()
	{
		
		//$this->data['auth']=0;
		if(is_array($this->data['auth'])) {header("location: /auth/profile"); }
		
	    $content["message"] = "";
	   
	    
	    $rules['login'] = "trim|required|min_length[1]|max_length[100]|xss_clean";
	    $rules['pass'] = "trim|required|min_length[2]";
   
	    $fields2=$this->config_model->fields();    
	    $content['fields']=$fields2;
	    
	    $fields['login'] = "'<b>".$fields2['login']."</b>'";
	    $fields['pass'] = "'<b>".$fields2['pass']."</b>'";
    
	    $this->validation->set_fields($fields);
	    $this->validation->set_rules($rules);
	    
	    $this->validation->set_error_delimiters('<div class="report_form">', '</div>');
        $this->lang->load('auth',$this->data['lang']);
	    
		// login procedure
	    if ($this->validation->run() != FALSE && $this->input->post("send") != "")
	    {
	    	if ($this->input->post("login") == "" || $this->input->post("pass") == "" || !$this->auth_model->isUser($this->input->post("login"), 
	    	$password = md5($this->input->post("pass"))))
	    	{
			    $content["message"] = "<div class='report_no'>".$this->lang->line('user_error')."</div>";  
	    	}
	    	else 
	    	{
	 //РµСЃР»Рё РІРµСЂРЅС‹Р№ РїР°СЂРѕР»СЊ -> РєР°С‚Р°Р»РѕРі
			    //$user = array("login"=>$this->input->post("login"),"pass"=>$this->input->post("pass"));
			    $users=$this->auth_model->getUser($this->input->post("login"));
			    $user["login"] = $users->login;
			    $user["pass"] = $users->pwd;
			    $user["name"] = $users->name;
			    $user["mail"] = $users->email;
			    $user["avatar"] = $users->avatar;
			    //$user["phone"] = $users->phone;
			    //$user["old"] = $users->old;
			    $user["logDate"] = date("Y-m-d H:i:s");
			    
			    $this->db_session->set_userdata('auth',$user);
			    $content["auth"]= $user;
			    $this->data["auth"]= $user;
			    $content["message"] = "<div class='report_yes'>".$this->lang->line('user_good')." - ".$user["login"]."</div>";
			    $this->data["authed"] = true;
		//header("Location: /horo");
	    	}
	    }

	    $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/auth', $content, TRUE);	   
        $this->load->view('pagesites', $this->data);
	    
	    
	}    
    
    

function logout()
	{
	  $this->db_session->set_userdata('auth','0');
	  //header("location: /auth/login");
	  header("location: /");
	}	
	
	


 function profile()
    {
     if(!is_array($this->data['auth'])) {header("location: /auth/login"); }
     
     
     	$content['message'] = "";
	
	// fields verify
	$rules['fio'] =   "trim|required|min_length[4]|max_length[100]|xss_clean";
	$rules['mail'] =  "trim|required|valid_email";	
//	$rules['phone'] = "trim|required|numeric|min_length[5]|max_length[15]";


	
	$rules['old_y'] =   "trim|required|numeric|min_length[4]|max_length[4]|xss_clean|callback_datey_check";
	$rules['old_m'] =   "trim|required|numeric|min_length[1]|max_length[2]|xss_clean|callback_datem_check";
	$rules['old_d'] =   "trim|required|numeric|min_length[1]|max_length[2]|xss_clean|callback_dated_check";
	$rules['old'] =	"callback_date_check";
	
	$rules['pass1'] = "matches[pass2]|min_length[4]";
	$rules['pass2'] = "min_length[4]";


	$fields2=$this->config_model->fields();    
    $content['fields']=$fields2;
	
    $fields['fio'] =   "'<b>".$fields2['fio']."</b>'";
//    $fields['foto'] =   "'<b>".$fields2['foto']."</b>'";    
    $fields['mail'] =  "'<b>".$fields2['mail']."</b>'";
//    $fields['phone'] = "'<b>".$fields2['phone']."</b>'";	
    $fields['pass1'] = "'<b>".$fields2['newpass']."</b>'";
    $fields['pass2'] = "'<b>".$fields2['pass2']."</b>'";
    $fields['old'] =   "'<b>".$fields2['old']."</b>'";
    $fields['old_y'] =   "'<b>".$fields2['old_y']."</b>'";
    $fields['old_m'] =   "'<b>".$fields2['old_m']."</b>'";
    $fields['old_d'] =   "'<b>".$fields2['old_d']."</b>'";
//    $fields['church_name'] =   "'<b>".$fields2['church_name']."</b>'";
//    $fields['shepherd_name'] =   "'<b>".$fields2['shepherd_name']."</b>'";
//    $fields['believer_old'] =   "'<b>".$fields2['believer_old']."</b>'";

    $this->validation->set_fields($fields);
    $this->validation->set_rules($rules);
    $this->validation->set_error_delimiters('<div class="report_form">', '</div>');
    $this->lang->load('auth',$this->data['lang']);
    $users=$this->auth_model->getUser($this->data['auth']['login']);  
    if ($this->validation->run() != FALSE && $this->input->post("send") != "")
    {// print"<br>----";


      $this->auth_model->changeProfile($this->data['auth']['login'],$this->input->post("pass1"));
      $content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";
      
     
      			    $users=$this->auth_model->getUser($this->data['auth']['login']);
      			    
      			    
			    $user["login"] = $users->login;
			    $user["pass"] = $users->password;
			    $user["fio"] = $users->name;
			    $user["mail"] = $users->email;
			    $user["old"] = $users->old;
			    $user["logDate"] = date("Y-m-d H:i:s");
			    $this->db_session->set_userdata('auth',$user);
      
 	  //$this->validation->foto = $users->foto;
 	      
    }
   else{
   
    $_POST["fio"]=$users->name;
//    $_POST["foto"]=$users->foto;
    $_POST["mail"]=$users->email;
//    $_POST["phone"]=$users->phone;
//print_r($users);

//*
	$old = explode("-",$users->birthdate);
	$_POST["old_y"] = $old[0]; 
	$_POST["old_m"] = $old[1];
	$_POST["old_d"] = $old[2]; 
	
    $_POST["old"]=$users->birthdate;
//*/
   
    $this->validation->set_fields($fields);
    $this->validation->set_rules($rules);
    }
    
 $content['auth']['login']=$users->login;    
    
 
    $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/profile', $content, TRUE);	    
    $this->load->view('pagesites', $this->data);    
     
    
    }

    
	function forgot()
	{
		if(is_array($this->data['auth'])) {header("location: /auth/profile"); }
		
		
		$rules['login'] = "min_length[4]|max_length[16]|xss_clean|callback__unique_nousername";
		$rules['mail'] =  "valid_email";	
		$rules['captcha'] = "trim|required|callback_check_captcha";

		$fields2=$this->config_model->fields();    
    	$content['fields']=$fields2;
  
   		$fields['login'] = "'<b>".$fields2['login']."</b>'";
		$fields['mail'] =  "'<b>".$fields2['mail']."</b>'";
    	$fields['captcha'] = "'<b>".$fields2['captcha']."</b>'";
     
		$content['message'] = "";
		
		$this->lang->load('auth',$this->data['lang']);
		$this->validation->set_fields($fields);
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		
		
	    if ($this->validation->run() != FALSE && $this->input->post("send") != "")
	    {
			if ($this->auth_model->sendNewPasswordRequest($this->input->post("login"),$this->input->post("mail")))
			{
				$content["message"] = "<div class='report_yes'>".$this->lang->line('forgot_mail')."</div>";
			}
			else 
			{
				$content["message"] = "<div class='report_yes'>".$this->lang->line('forgot_mail_no')."</div>";
				
			}
			$this->validation=false;
	    }

		if ($this->input->post("send") != "")
		{
			$this->db_session->unset_userdata('captcha_keystring');
		}
		
       $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/forgot', $content, TRUE);	    
       $this->load->view('pagesites', $this->data);    
	}
 
	
	function newpassword()
	{
		$user = $this->uri->segment(3);
		$code = $this->uri->segment(4);	
        $content["message"]='';
		
	    if (!$this->auth_model->existUsername($user))
	    {
		    $content["message"] = "";	    	
	    }

		$rules['pass1'] = "trim|required|matches[pass2]|min_length[4]";
		
		$fields2=$this->config_model->fields();    
    	$content['fields']=$fields2;
		
		$fields['pass1'] = "'<b>".$fields2['newpass']."</b>'";
        $fields['pass2'] = "'<b>".$fields2['pass2']."</b>'";

		$this->lang->load('auth',$this->data['lang']);
		$this->validation->set_fields($fields);
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		
		
		// login procedure
	    if ($this->validation->run() != FALSE && $this->input->post("send") != "")
	    {
			if ($this->auth_model->changePassword($user, $code, $this->input->post("pass1")))
			{
				$content["message"] = "<div class='report_yes'>".$this->lang->line('profilnewparol')."</div>";

			}
			else 
			{
				$content["message"] = "<div class='report_no'>".$this->lang->line('profilnewparol_no')."</div>";
			}
			$this->validation=false;
	    }
	    
	    $content['code'] = $code;
	    $content['user'] = $user;
       $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/newpassword', $content, TRUE);	    
       $this->load->view('pagesites', $this->data);    
	    

	}
	
function invite(){
	$id = $this->uri->segment(3);
	$this->db_session->set_userdata('invite',$id);	
	header("location: /");
}
 

	
	function _unique_activation_code($str)
	{	
		$code = $this->config_model->getConfigName('activation_code');
		if ($str != $code)
		{
			$this->validation->set_message('_unique_activation_code', 'РќРµРІРµСЂРЅС‹Р№ РєРѕРґ РґРѕСЃС‚СѓРїР°');
			return FALSE;
		}
		else
		{
			return TRUE;
		}		
	}		
	
	
		function _unique_username($str)
	{
		//$this->load->model('auth_model');
		
		if ($this->auth_model->existUsername($str))
		{
			$this->validation->set_message('_unique_username', 'Пользователь с таким %s уже существует');
			return FALSE;
		}
/*		else if(eregi('^[А-Яа-я0-9]+$',$str)){
			$this->validation->set_message('_unique_username', 'Некорекно введен %s');
			return FALSE;
	}
	*/
		else
		{
			return TRUE;
		}		
	}
	
	
	function _unique_nousername($str)
	{
		//$this->load->model('auth_model');
		
		if (!$this->auth_model->existUsername($str))
		{
			$this->validation->set_message('_unique_nousername', 'РџРѕР»СЊР·РѕРІР°С‚РµР»СЊ СЃ С‚Р°РєРёРј %s РЅРµ СЃСѓС‰РµСЃС‚РІСѓРµС‚');
			return FALSE;
		}
/*		else if(eregi('^[Рђ-РЇР°-СЏ0-9]+$',$str)){
			$this->validation->set_message('_unique_username', 'РќРµРєРѕСЂРµРєРЅРѕ РІРІРµРґРµРЅ %s');
			return FALSE;
	}
	*/
		else
		{
			return TRUE;
		}		
	}	
	
	
	function _unique_email($str)
	{
		$this->load->model('auth_model');
		
		if ($this->auth_model->existEmail($str))
		{
			$this->validation->set_message('_unique_email', 'РџРѕР»СЊР·РѕРІР°С‚РµР»СЊ СЃ С‚Р°РєРёРј %s СѓР¶Рµ СЃСѓС‰РµСЃС‚РІСѓРµС‚');
			return FALSE;
		}
		else
		{
			return TRUE;
		}		
	}
	
	function _userEmail_check($str)
	{
		$this->load->model('auth_model');
		
		if (!$this->auth_model->existEmail($str) && !$this->auth_model->existUsername($str))
		{
			$this->validation->set_message('_userEmail_check', 'РџРѕР»СЊР·РѕРІР°С‚РµР»СЏ СЃ С‚Р°РєРёРј %s РЅРµ СЃСѓС‰РµСЃС‚РІСѓРµС‚');
			return FALSE;
		}
		else
		{
			return TRUE;
		}		
	}	


	
	
	function loginAjax($param = "")
	{
//		echo $method,", ",$param;
		
		$content = $this->data;
		
		$content['block'] = 'authf';
		$content['infoBlock'] = 'authf';
		$content['controller'] = 'auth';
		$content['controllerAfter'] = 'tools';
		$content['methodAfter'] = 'main';
		$content['info'] = 'пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ...';

	    $content["msg"] = "";
	    
	    $this->load->model('auth_model');
	    
	    if (isset($param) && is_array($param[0]))
	    {
		    $username = $param[0][0];
		    $password = $param[0][1];
		    $sub = $param[0][2];
		}
		else
		{
			$username = '';
			$password = '';
			$sub = '';
		}
	    $content["username"] = $username;
	    $content["password"] = "";
	    
	    $_POST['username'] = $username;
//	    $content["password"] = "";
	    
		//$this->input->post("username");
	    //$password = $this->input->post("password");
//	    var_dump($param);
	    
		// login procedure
	    if ($sub != "")
	    {
	    	if ($username == "" || $password == "" || !$this->auth_model->isUser($username, $password))
	    	{
			    $content["msg"] = "пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ/пїЅпїЅпїЅпїЅпїЅпїЅ";
	    	}
	    	else 
	    	{
			    $user = array("username"=>$username,"password"=>$password);
			    $user["logDate"] = date("Y-m-d H:i:s");
			    
			    $this->db_session->set_userdata('user',$user);
			    $content["authed"] = true;
			   // redirect("main");
	    	}
	    }

		if ($content["authed"] != true)
	    {
	    	$content["content_title"] = "пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ";
	    	$content["main"] = $this->load->view('auth/login', $content, TRUE);
	    	
	    	$string = $this->load->view('auth/auth', $content, TRUE);
	    	$JSstring = $this->load->view('auth/js/login', $content, TRUE);
	    }
	    else
	    {
	    	$content["content_title"] = "пїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ";
	    	$user = $this->db_session->userdata('user');
	    	$content["logDate"] = $user["logDate"];
	    	$content["user"] = $this->auth_model->getUser($user['username']);
	    	$content["main"] = $this->load->view('auth/logout', $content, TRUE);
//	    	
//	    	$string = $this->load->view('auth/auth', $content, TRUE);
//	    	$JSstring = $this->load->view('auth/js/logout', $content, TRUE);

			$string = '';
	    	$JSstring = $this->load->view('auth/js/authedRedirect', $content, TRUE);
	    }	    
	    
//		$string = $data['text'];
		
		$GLOBALS['_RESULT'] = array(
			"HTML"	=> $string,
			"JS"	=> $JSstring
		);		    
	}	
	


	function forgotAjax($param = "")
	{
	    if (isset($param) && is_array($param[0]) && count($param[0]) == 4)
	    {
		    $user = $param[0][0];
		    $code = $param[0][1];
		    $sub = $param[0][2];
		    
		    $_POST['user'] = $user;
		    $_POST['code'] = $code;
		    $_POST['sub'] = $sub;	
		}
//		else
//		{
//			$user = '';
//			$code = '';
//			$sub = '';
//		}
	    

	    
		$content = $this->data;		
		
		$content['block'] = 'authf';
		$content['infoBlock'] = 'authf';
		$content['controller'] = 'auth';
		$content['info'] = 'пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ...';
	    
	    $content["msg"] = "";
	    	    
	    $content["email"] = "";
	    $content["regMsg"] = "";
	    
		$this->load->helper(array('form', 'url'));
		$this->load->library('validation');
		
		$this->load->model('auth_model');		
		
		// fields verify
		$rules['code'] = "trim|required|callback__code_check";
		$rules['user'] = "trim|required|callback__userEmail_check";
		
		$fields['code'] = '<b>пїЅпїЅпїЅ</b>';
		$fields['user'] = '<b>пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅ Email пїЅпїЅпїЅпїЅпїЅ</b>';
		
		$this->validation->set_fields($fields);
		
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters('<div style="color: #ff0000">', '</div>');
		
		// login procedure
	    if ($this->validation->run() != FALSE && $this->input->post("sub") != "")
	    {
//	    	echo 'a';
			$content["regMsg"] = $this->auth_model->sendNewPasswordRequest($this->input->post("user"));
//			{
//				$content["regMsg"] = "<p>пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ.</p>";
//			}
//			else 
//			{
//				$content["regMsg"] = "<p>пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ.</p>";
//			}
	    }

		if ($this->input->post("sub") != "")
		{
			$this->db_session->unset_userdata('captcha_keystring');
		}
		
		$content["content_title"] = "пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ";
//	    $content["auth"] = "";
	    $content["main"] = $this->load->view('auth/forgot', $content, TRUE);
		    
	    $string = $this->load->view('auth/auth', $content, TRUE);
	    $JSstring = $this->load->view('auth/js/forgot', $content, TRUE);
	    
//		$string = $data['text'];
		
		$GLOBALS['_RESULT'] = array(
			"HTML"	=> $string,
			"JS"	=> $JSstring
		);
	    
	}

	

    
    
    
    
    
    
	function registerAjax($param = "")
	{
//		echo count($param[0]);
		if (isset($param) && is_array($param[0]) && count($param[0]) == 9)
	    {
		    $name = $param[0][0];
	    	$username = $param[0][1];
		    $password = $param[0][2];
		    $password2 = $param[0][3];
		    $email = $param[0][4];
		    $tel = $param[0][5];
		    $code = $param[0][6];
		    $sub = $param[0][7];
		    
		    $_POST['name'] = $name;
		    $_POST['username'] = $username;
		    $_POST['password'] = $password;
		    $_POST['password2'] = $password2;
		    $_POST['email'] = $email;
		    $_POST['tel'] = $tel;
		    $_POST['code'] = $code;
		    $_POST['sub'] = $sub;	
		}
//		else
//		{
//			$user = '';
//			$code = '';
//			$sub = '';
//		}
				
	    $this->load->model('auth_model');
	    
		$content = $this->data;
		
		$content['block'] = 'authf';
		$content['infoBlock'] = 'authf';
		$content['controller'] = 'auth';
		$content['info'] = 'пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ...';		
	    
	    $content["name"] = "";
		$content["username"] = "";
	    $content["password"] = "";
	    $content["password2"] = "";
	    $content["email"] = "";
	    $content["tel"] = "";
	    $content["msg"] = "";
	    $content["regMsg"] = "";
	    $content["content_title"] = "пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ";
	    
		$this->load->helper(array('form', 'url'));
		$this->load->library('validation');
		
		
		// fields verify
		$rules['name'] = "trim|required|min_length[4]|max_length[16]|xss_clean";
		$rules['username'] = "trim|required|min_length[4]|max_length[16]|xss_clean|callback__unique_username";
		$rules['password'] = "trim|required|matches[password2]|min_length[4]";
		$rules['email'] = "trim|required|valid_email|callback__unique_email";
		$rules['tel'] = "trim|required|min_length[4]|max_length[16]|xss_clean";
		$rules['code'] = "trim|required|callback__code_check";
		
		$fields['name'] = '<b>пїЅпїЅпїЅ</b>';
		$fields['username'] = '<b>????пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ</b>';
		$fields['password'] = '<b>????пїЅпїЅпїЅпїЅпїЅпїЅ</b>';
		$fields['password2'] = '<b>пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ</b>';
		$fields['email'] = '<b>Email</b>';
		$fields['tel'] = '<b>????пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ</b>';
		$fields['code'] = '<b>пїЅпїЅпїЅ</b>';
		
		$this->validation->set_fields($fields);
		
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters('<div style="color: #ff0000">', '</div>');

		// login procedure
	    if ($this->validation->run() != FALSE && $this->input->post("sub") != "")
	    {
	    	$this->auth_model->addUser();
	    	
            $this->auth_model->_sendAdminMsg("????пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ/пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ", 
        		"пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ - ".$_POST['username']);
	    	
	    	$content["regMsg"] = $this->auth_model->sendActivationEmail();
		    $content["main"] = $this->load->view('auth/registered', $content, TRUE);
	    }
	    else 
	    {
		    $content["main"] = $this->load->view('auth/register', $content, TRUE);
	    }
	    
		if ($this->input->post("sub") != "")
		{
			$this->db_session->unset_userdata('captcha_keystring');			
		}
	    
	    $string = $this->load->view('auth/auth', $content, TRUE);
	    $JSstring = $this->load->view('auth/js/register', $content, TRUE);
	    
		$GLOBALS['_RESULT'] = array(
			"HTML"	=> $string,
			"JS"	=> $JSstring
		);
	}
		
	

	
	
	function logoutAjax()
	{
		$content = $this->data;
	    
	    // unset user data but keep session
    	$this->db_session->unset_userdata('user');
    	//$this->db_session->sess_destroy();
    	
    	$content["content_title"] = "пїЅпїЅпїЅпїЅпїЅ";
    	$content['text'] = "пїЅпїЅ пїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ.";
    	
	    $string = $this->load->view('auth/logouted', $content, TRUE);
	    $JSstring = $this->load->view('auth/js/logouted', $content, TRUE);
	        	
		$GLOBALS['_RESULT'] = array(
			"HTML"	=> $string,
			"JS"	=> $JSstring
		);	
	}	


function history()
	{  if(!isset($_SESSION['auth']['login'])||$_SESSION['auth']['login']==''){
	  	header("location: /program/cabinet/login");
	  }
	  
	  $this->load->model('ploskost_model');
	  $this->data['orders'] = $this->ploskost_model->getOrdersByUserId($_SESSION['auth']['login']);
	  $this->data['status'] = $this->ploskost_model->Status();
	  $this->data['months'] = $this->ploskost_model->Month();
	  
	  
	  
	  //$this->data['order_statuses'][1]='';
	 // print_r($this->data['orders']);
	  
	    $this->data['Content']['file'] = "auth/history.php";
	    $this->load->view('mainpage.tpl', $this->data);	  
	}	
	
	
	
	function newemail()
	{
		$user = $this->uri->segment(3);
		$code = $this->uri->segment(4);		
		
	    $content["msg"] = "";
	    $content["content_title"] = "РќРѕРІС‹Р№ Email";
	    
	    $content["regMsg"] = "";
	    $content["user"] = $user;
	    
		$this->load->model('auth_model');		
		
	    if (!$this->auth_model->existUsername($user))
	    {
		    $content["regMsg"] = "<p>РџРѕР»СЊР·РѕРІР°С‚РµР»СЏ <b>$user</b> РЅРµ СЃСѓС‰РµСЃС‚РІСѓРµС‚ РІ Р±Р°Р·Рµ РґР°РЅРЅС‹С….</p>";	    	
	    }
	    
		if ($this->auth_model->changeEmail($user, $code))
		{
			$content["regMsg"] = "<p>Р’Р°С€ Email СѓСЃРїРµС€РЅРѕ РёР·РјРµРЅРµРЅ.</p>";
            $this->auth_model->_sendAdminMsg("РџРѕР»СЊР·РѕРІР°С‚РµР»СЊ/РР·РјРµРЅРµРЅРёРµ email", 
        		"Email РёР·РјРµРЅРµРЅ РїРѕР»СЊР·РѕРІР°С‚РµР»РµРј - ".$user);			
		}
		else 
		{
			$content["regMsg"] = "<p>РћС€РёР±РєР° РёР·РјРµРЅРµРЅРёСЏ Email. Р’РѕР·РјРѕР¶РЅРѕ РЅРµ СЃРѕРІРїР°РґР°РµС‚ РєРѕРґ, Р»РёР±Рѕ РїСЂРѕС€Р»Рѕ Р±РѕР»РµРµ СЃСѓС‚РѕРє СЃ 
РјРѕРјРµРЅС‚Р° Р·Р°РїСЂРѕСЃР° РЅР° РёР·РјРµРЅРµРЅРёРµ Email.</p>";
            $this->auth_model->_sendAdminMsg("РџРѕР»СЊР·РѕРІР°С‚РµР»СЊ/РР·РјРµРЅРµРЅРёРµ email", 
        		"РћС€РёР±РєР° РёР·РјРµРЅРµРЅРёСЏ email РїРѕР»СЊР·РѕРІР°С‚РµР»РµРј - ".$user);			
		}

	    $content["auth"] = $this->load->view('auth/login', $content, TRUE);
	    $content["main"] = $this->load->view('auth/newemail', $content, TRUE);
		    
	    $this->load->view('auth/auth', $content);
	    
	}	
	
		
	
	/*// hack for set params
	function _remap($m)
	{
		if (substr_count($m,'Ajax') > 0)
		{
			$p = $this->input->post('param');
			
			 unset($_POST);
			 $_POST = null;
			
			$this->$m($p);
			exit();
		}
		else
		{
			$this->$m();
		}
	}		
	*/
}
?>