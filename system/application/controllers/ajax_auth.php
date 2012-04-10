<?include_once(APPPATH."libraries/core.php");


class Ajax_auth extends Core /*extends Controller*/ {

	var $POST;
	function __construct()
	{
		//parent::Controller();
		parent::Core();
		//print_r($_POST);
		$this->POST = $_POST; 
		$this->load->model('auth_model');
		$this->lang->load('auth',$this->data['lang']);
			$this->load->model('purses_model');
	}

	
	function _remap()
    {
      if(($uri=$this->uri->segment(2))!=''){
           if(method_exists($this, $uri)) $this->$uri();
           else $this->index();}
      else $this->index();
     
    }	
	
/*	
	// hack for set params
	function _remap($m)
	{
		$p = $this->input->post('param');
			
		unset($_POST);
		$_POST = null;
		
		$this->$m($p);
		exit();
	}		
*/	
	
	function index()
	{	//session_start();

	}

	
function register(){
	//session_start();
			//print_r($_POST);
			$_POST= $this->POST;
			//print_r($_POST);
	//$this->load->model('config_model');
	//$this->load->model('auth_model');
	$this->load->library('validation');
	//$this->data['lang'] = 'ru';
	//$this->lang->load('forma',$this->data['lang']);
	$this->lang->load('validation',$this->db_session->userdata('lang'));

		 $content['message'] = "";
	
	// fields verify
	$rules['parent'] = "trim|callback_is_nickname";
	$rules['nickname'] =  "callback_unique_user|trim|required|min_length[2]|max_length[255]|callback_unique_nickname|xss_clean";
	$rules['fio'] =   "trim|required|min_length[2]|max_length[255]|xss_clean";
//	$rules['nam'] =   "trim|required|min_length[2]|max_length[100]|xss_clean";
//	$rules['fam'] =   "trim|required|min_length[2]|max_length[100]|xss_clean";
	//$rules['login'] = "trim|required|min_length[4]|max_length[16]|xss_clean|callback__unique_username";
	$rules['email'] =  "trim|required|valid_email|callback__unique_email";	
//	$rules['phone'] = "trim|required|numeric|min_length[5]|max_length[15]";
	$rules['p1'] = "trim|required|matches[p2]|min_length[4]";
	$rules['p2'] = "trim|required|min_length[4]";
	
	$rules['country'] = "trim|required|callback_notnull";
	$rules['region'] = "trim|required|callback_notnull";
	$rules['town'] = "trim|required|callback_notnull";

	$rules['cod'] = "trim|required|callback_check_captcha";

	$rules['birthdate'] = "callback_date_check";
	$rules['rules'] = "callback_checked";
	$rules['sex'] = "callback_checked";
	//$rules['captcha'] = "trim|required|callback_check_captcha";
	//$rules['old_y'] =   "trim|required|numeric|min_length[4]|max_length[4]|xss_clean|callback_datey_check";
	//$rules['old_m'] =   "trim|required|numeric|min_length[1]|max_length[2]|xss_clean|callback_datem_check";
	//$rules['old_d'] =   "trim|required|numeric|min_length[1]|max_length[2]|xss_clean|callback_dated_check";
	//$rules['old'] =   "callback_date_check";
		
	if(!empty($_POST)){
		if(!isset($_POST['rules'])) $_POST['rules'] = 'no';
		if(!isset($_POST['sex'])) $_POST['sex'] = 'no';
		
		$_POST['birthdate'] = $_POST['year'].'-'.$_POST['monb'].'-'.$_POST['dayb'];
		if(empty($_POST['year']) || empty($_POST['monb']) || empty($_POST['dayb'])) $_POST['birthdate'] = 'no';
	}
	
	$country=null;
	$region=null;
	if(isset($_POST['country'])&& !empty($_POST['country']) && $_POST['country'] != 'null') $country=$_POST['country'];
	if(isset($_POST['region'])&& !empty($_POST['region']) && $_POST['region'] != 'null') $region=$_POST['region'];
		
	$content['geo']= $this->auth_model->geo($country, $region);
	$content['geo']['curcountry'] = $country;
	$content['geo']['curregion'] = $region;
	//print_r($content['geo']);
	

    if(!$inv=$this->db_session->userdata('invite')) {
		$this->load->model('purses_model');
		$inv = $this->purses_model->getval('InfomenaId');
	}else $content['parent_id'] = $inv;
	$user = $this->auth_model->getUserById($inv); 
	$content['parent'] = $user->nickname;
	if(!empty($_POST['parent'])) {
		$user = $this->config_model->row($this->auth_model->getval('table'),array($this->auth_model->getval('nickname')=>$_POST['parent']));
		if(!empty($user->id)) $inv = $user->id;
	}
	$_POST['parent_id']  = $inv;
	
	$fields=$this->config_model->fields();
	$content['fields'] = $fields;
	
	
	$this->validation->set_fields( $this->framing($fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
   
    $this->validation->set_error_delimiters('<div class="report_form">', '</div>');
	
    
    if (!empty($_POST['go']) && $this->validation->run() != FALSE)
    {
	  $content["run"] = true;
 	  $this->auth_model->addUser();//поля настроить
 	  $this->lang->load('auth',$this->db_session->userdata('lang'));
	  if(!$this->auth_model->sendActivationEmail())  $content["message"] = "<div class='report_no'>".$this->lang->line('error_mail')."</div>";
      else    										   $content["message"] = "<div class='report_yes'>".$this->lang->line('mail_good_act')."</div>";
 	  
      $this->validation=false;
    }
    //elseif(!$this->input->post("go")){}
    if(empty($this->validation->parent)) $this->validation->parent = $content['parent'];


	$this->load->view('ajax/register',$content);
	//print_r($this->validation);
}
function framing($arr, $pred='', $post=''){
	foreach ($arr as &$elem)
		if(is_string($elem)) $elem = $pred.$elem.$post;
return $arr;
}
function auth()
{
	//echo "auth";
	//print_r($_COOKIE);
	
			$_POST= $this->POST;
			//print_r($_POST);
			
		    if ($this->input->post("login") == "" || $this->input->post("pwd") == "" || !$this->auth_model->isUser($this->input->post("login"), 
	    	$password = md5($this->input->post("pwd"))))
	    	{    
			    $content["message"] = "<div class='report_no'>".$this->lang->line('user_error')."</div>";  
			    $this->data["authed"] = false;
			    $content['block_message'] = $this->lang->line('login_no');
			    $this->load->view('ajax/auth',$content);
	    	}
	    	else 
	    	{
	 //РµСЃР»Рё РІРµСЂРЅС‹Р№ РїР°СЂРѕР»СЊ -> РєР°С‚Р°Р»РѕРі
			    //$user = array("login"=>$this->input->post("login"),"pass"=>$this->input->post("pass"));
		    
			    $users=$this->auth_model->getUser($this->input->post("login"));
			    $user["id"] = $users->id;
			    $user["login"] = $users->email;
			    $user["pass"] = $users->pwd;
			    $user["name"] = $users->name;
			    $user["mail"] = $users->email;
			    $user["info"] = $users->info;
			    $user["avatar"] = $users->avatar;
			    $user["rating"] = $users->rating;
			    //$user["phone"] = $users->phone;
			    //$user["old"] = $users->old;
			    $user["logDate"] = date("Y-m-d H:i:s");
			    
			    $days = (int)(time()/(60*60*24)) - (int)(strtotime($users->last_login)/(60*60*24));
			    if(1 >= $days){
			    	$u->rating = $user["rating"] = $users->rating +2;
					$u->up = $user["logDate"];
				}
			    $u->last_login = $user["logDate"];
			    
			    $this->db->where($this->auth_model->getval('login'), $user["login"]);
			    $this->db->update($this->auth_model->getval('table'), $u);
			    
			    $this->db_session->set_userdata('auth',$user);
			    $this->data["authed"] = true;
			    //$this->_log_check();
			    $content["auth"]= $user;
			    $this->data["auth"]= $user;
			    
			    //if(!empty($_POST['save'])) {setcookie('mycookie', 'save'); $mes = $_COOKIE['mycookie']; }
			    if(!empty($_POST['save'])) {$this->db_session->set_userdata('saveauth', $user["login"]);}
			    
			    $content["message"] = "<div class='report_yes'>".$this->lang->line('user_good')." - ".$user["login"]."</div>";
			    
			    $this->data["authed"] = true;
			    
				$this->load->model('comments_model');
				$content['CntUserComments'] = $this->comments_model->CntUserComments($users->id);
				$this->load->model('messages_model');
				$content['CntMessagesNew'] = $this->messages_model->GetMessages($users->id,'CNT',0, array(	$this->messages_model->getval('table').".new"=>0, 
																						$this->messages_model->getval('table').".user_to"=>$users->id));
			    $content['block_message'] = $this->lang->line('login_yes');
				$this->load->view('ajax/auth',$content);
	    	}		
			
}
 
function logout()
	{
	  $this->db_session->set_userdata('auth','0');
	  $this->db_session->set_userdata('invite',false);
	  //header("location: /auth/login");
	 // header("location: /");
	 	$this->data["authed"]=false;
	 	unset($this->data["auth"]);
		$content['run']=false;
		$content['block_message'] = $this->lang->line('logout');
		$this->load->view('ajax/auth',$content);
	}	



	function forgot()
	{
		if(isset($this->data["authed"]) && $this->data["authed"]) ;//{header("location: /auth/profile"); }
		
		
	//$this->load->model('config_model');
	//$this->load->model('auth_model');
	$this->load->library('validation');
	$this->lang->load('validation',$this->db_session->userdata('lang'));
	
		
		//$rules['login'] = "min_length[4]|max_length[16]|xss_clean|callback__unique_nousername";
		$rules['email'] =  "trim|required|valid_email|callback__userEmail_check";	
		$rules['cod'] = "trim|required|callback_check_captcha";

		$fields=$this->config_model->fields();    
    	$content['fields']=$fields;
  

     
		$content['message'] = "";
		
		
		$this->validation->set_fields( $this->framing($fields, '"<b>', '</b>"') );
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		
		//print_r($_POST);
	    if ($this->validation->run() != FALSE)
	    {
			if ($this->auth_model->sendNewPasswordRequest($this->input->post("email"),$this->input->post("email")))
			{
				$content["message"] = "<div class='report_yes'>".$this->lang->line('forgot_mail')."</div>";
				$content["run"]=true;
			}
			else 
			{
				$content["message"] = "<div class='report_yes'>".$this->lang->line('forgot_mail_no')."</div>";
				$content["run"]=true;
			}
			$this->validation=false;
	    }

		if ($this->input->post("send") != "")
		{
			$this->db_session->unset_userdata('captcha_keystring');
		}
		
       //$this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/forgot', $content, TRUE);	    
       $this->load->view('ajax/forgot',$content);    
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

		
		$this->validation->set_fields($fields);
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		
		
		// login procedure
	    if ($this->validation->run() != FALSE)
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
       $this->data['Content']['text']=$this->load->view($this->data['papka'].'/auth/newpassword', $content, TRUE);
       $this->load->view('pagesites', $this->data); 	    
       //$this->load->view('ajax/newpassword', $content);    
	    

	}	
function text()
{
	$this->data['Content'] = $this->config_model->Get_Page($this->uri->segment_array(),$this->router,$this->data['lang']);
	$this->data['Content']['name']=$this->data['Content']['title'];
	if('' == $this->data['Content']['text']=$this->config_model->getText($this->data['Content']['id']))	;
	$this->load->view('ajax/text', $this->data); 
}
function geo(){
	if(isset($_POST['geo']) && isset($_POST['id']))
		switch ($_POST['geo']){
		case 'c' : $_POST['country'] = $_POST['id']; break;
		case 'r' : $_POST['region'] = $_POST['id']; break;
		}
	//print_r($_POST);
	$country=null;
	$region=null;
	if(isset($_POST['country'])&& !empty($_POST['country']) && $_POST['country'] != 'null') $country=$_POST['country'];
	if(isset($_POST['region'])&& !empty($_POST['region']) && $_POST['region'] != 'null') $region=$_POST['region'];
		
	$content['geo']= $this->auth_model->geo($country, $region);
	$content['geo']['curcountry'] = $country;
	$content['geo']['curregion'] = $region;
	$content['geo']['geo'] = $_POST['geo'];
	//print_r($content['geo']);
	$this->load->view('ajax/geo', $content);
}
function _unique_email($str){
	if ($this->auth_model->existEmail($str))	{
		$this->validation->set_message('_unique_email', $this->lang->line('unique_email'));
		return FALSE;
	}
	else
		return TRUE;	
}
function unique_nickname($str){
	if (!$this->auth_model->unique_nickname($str))	{
		$this->validation->set_message('unique_nickname', $this->lang->line('unique_nickname'));
		return FALSE;
	}
	else
		return TRUE;	
}
function is_nickname($str){
	if ($this->auth_model->unique_nickname($str))	{
		$this->validation->set_message('is_nickname', $this->lang->line('is_nickname'));
		return FALSE;
	}
	else
		return TRUE;	
}

	function _userEmail_check($str)	{
		$this->load->model('auth_model');
		if (!$this->auth_model->existEmail($str) && !$this->auth_model->existUsername($str))
		{
			$this->validation->set_message('_userEmail_check', $this->lang->line('unique_email'));
			return FALSE;
		}
		else
			return TRUE;	
	}
function checked($str){
	if(empty($str) || $str=='no' || $str=='off'){
		$this->validation->set_message('checked', $this->lang->line('checked'));
		return false;}
	return true;
}

function date_check($str){
	if(empty($str) || $str=='no' || $str=='off'){
		$this->validation->set_message('date_check', $this->lang->line('date_check_no'));
	return false;}
	
	$old = explode('-', $str);
	if(false && !checkdate($old[1], $old[2], $old[0])){ 
		$this->validation->set_message('date_check', $this->lang->line('date_check_bad'));
		return false;}
		
	if(18 > date('Y', time()) - $old[0]){ 
		$this->validation->set_message('date_check', $this->lang->line('date_check_10'));
		return false;}
	return true;
}
function unique_user($str){//echo 'kh'.getenv('HTTP_X_FORWARDED_FOR');
	$this->db->from($this->auth_model->getval('table'));
	$this->db->where('ip',$_SERVER['REMOTE_ADDR']);
	$this->db->where('screen',$this->input->post("screen"));
	if(preg_match('/\((.*)\)/',$_SERVER['HTTP_USER_AGENT'], $matches) && !empty($matches[1]))
			$this->db->where('op_sys', $matches[1]);
	//$this->db->where('browser',$_SERVER['HTTP_USER_AGENT']);
	if($this->db->count_all_results()){
		$this->validation->set_message('unique_user', $this->lang->line('unique_user'));
		return false;}
	return true;
}

function notnull($str){
	if(empty($str) || $str==null || $str=='null' || $str=='NULL'){
		$this->validation->set_message('notnull', $this->lang->line('notnull'));
		return false;}

}

	
	function accessDeny()
	{
		$this->load->file(APPPATH.'libraries/ajax/JsHttpRequest/JsHttpRequest.php', false);
		
		$JsHttpRequest = new JsHttpRequest("UTF-8");
		
		$user = $this->db_session->userdata('user');
		
		$string = "Доступ <strong>".$user["username"]."</strong> к странице запрещен.";

		$GLOBALS['_RESULT'] = array(
			"HTML"   => $string
		);
		exit;
	}
	

	
	
}
?>