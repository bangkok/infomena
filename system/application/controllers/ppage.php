<?php
@include_once("base.php");

class Ppage extends Base {
	
	function __construct()
	{
		 parent::Base();
		 $this->load->library('validation');
		 //$this->lang->load('forma',$this->data['lang']);
		 $this->lang->load('validation',$this->data['lang']);
		 $this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		 $this->lang->load('auth',$this->data['lang']);
		 //$this->load->model('auth_model');
		 
		 $this->fields=$this->config_model->fields();
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
	
	$rules['status'] =   "trim|numeric";
	$rules['status_self'] =   "trim|max_length[64]";
	$rules['deviz'] =   "trim|max_length[255]";
	
	$content['fields'] = $this->fields;
	
	//$this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
    
   if (isset($_REQUEST['go']))
    if ($this->validation->run() != FALSE && $this->input->post("go") != "")
    {
		if(isset($_POST['deviz']) && $_POST['deviz']=='Мой девиз (введите свой девиз)') $_POST['deviz']='';
		$this->auth_model->changeProfile($this->data['auth']['login'], 'status | status_self | deviz');
		$content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";      
    }
	
    $content['status'] = $this->auth_model->status();
	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
	
	//echo $content['user']->id;
	//$info = $this->config_model->row('purses', array('id_user'=>$content['user']->id));
	//print_r($info);
	//	print_r($content['geo']);
	$this->data['Content']['name']="Мой профиль";
	$this->data['Content']['text']=$this->load->view($this->data['papka'].'/ppage/myprofile', $content, TRUE);	   
	
	$this->load->view('pagesites', $this->data);	
//	header("location: /auth/register");
}
function edit_general(){
	
//	if(!isset($this->data["auth"]) || !is_array($this->data["auth"])) {header("location: /auth/login"); }
	$content['status'] = $this->auth_model->status();
	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
	
	$content['message'] = "";

	$rules['fio']		= "trim|required|min_length[2]|max_length[255]|xss_clean";
	//$rules['fam']		= "trim|required|min_length[2]|max_length[100]|xss_clean";
	$rules['nickname']	= "trim|required|min_length[2]|max_length[255]|callback_unique_nickname|xss_clean";
	$rules['org']		= "trim|min_length[2]|max_length[100]|xss_clean";	
//	$rules['nickcheck']	= "trim|required|callback_nickcheck";
	
	$rules['country'] = "trim|required|callback_notnull";
	$rules['region'] = "trim|required|callback_notnull";
	$rules['town'] = "trim|required|callback_notnull";
	

	if(isset($_POST['country'])&& !empty($_POST['country']) && $_POST['country'] != 'null') $country=$_POST['country']; else{ $country = $_POST['country'] =null;}
	if(isset($_POST['region'])&& !empty($_POST['region']) && $_POST['region'] != 'null') $region=$_POST['region']; else{ $region = $_POST['region']=null;		}
	$fields=$this->fields;


    $this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
//    $users=$this->auth_model->getUser($this->data['auth']['login']); 
   if (isset($_REQUEST['go']))
    if ($this->validation->run() != FALSE && $this->input->post("go") != "")
    {//print_r($_POST);
      $this->auth_model->changeProfile($this->data['auth']['login'], 'fio | nickname | org | country | region | town | nickcheck');
      
      $content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	  $this->data['auth']['name'] = $content['user']->name;
	  $this->db_session->set_userdata('auth',$this->data['auth']);
		
      $content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";  
      header("Location: /".$this->uri->segment(1));    
    }
   else{
   	    foreach ($rules as $val=>$srt){//echo $this->validation->$val;
   		if(!empty($this->validation->$val))  $content['user']->$val = $this->validation->$val;}
   //	print_r($content['user']);
  //	print_r($this->validation);
 //   $this->validation->set_fields($fields);
//    $this->validation->set_rules($rules);
    }
	

	$country = $content['user']->country;
	$region = $content['user']->region;
	
	$content['geo']= $this->auth_model->geo($country, $region);
	$content['geo']['curcountry'] = $country;
	$content['geo']['curregion'] = $region;
	$content['geo']['curtown'] = $content['user']->town;
	
	$content['fields'] = $this->fields;
	
	$this->data['Content']['name']= 'Мой профиль';
	//$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/edit_general', $content, TRUE);
	$content['edit_general'] =true;
	$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/myprofile', $content, TRUE);
	$this->load->view('pagesites', $this->data);
}
function edit_contacts(){
	
	$content['status'] = $this->auth_model->status();
	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
		
	$content['message'] = "";

	$rules['tel']	= "trim|min_length[5]|max_length[14]|xss_clean";
	$rules['mtel']	= "trim|min_length[5]|max_length[14]|xss_clean";
	$rules['icq']	= "trim|numeric|min_length[5]|max_length[10]|xss_clean";
	$rules['skype']	= "trim|min_length[3]|max_length[64]|xss_clean";
	$rules['url']	= "trim|min_length[3]|max_length[100]|xss_clean";

	$content['fields'] = $this->fields;

	$this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
   if (isset($_REQUEST['go']))
    if ($this->validation->run() != FALSE && $this->input->post("go") != "")
    {
      $f = $this->auth_model->changeProfile($this->data['auth']['login'], 'tel | mtel | icq | skype | url');
      if($f) $content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";
      //$content['edit_contacts']=false;  
       header("Location: /".$this->uri->segment(1));  
    }
   else{
   	  foreach ($rules as $val=>$srt){
   		if(!empty($this->validation->$val))  $content['user']->$val = $this->validation->$val;}
//    $this->validation->set_fields($fields);
//    $this->validation->set_rules($rules);
    }
        
//	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	
	$this->data['Content']['name']='Изменить контактные данные';
	
	//$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/edit_contacts', $content, TRUE);	
	$content['edit_contacts'] =true;
	$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/myprofile', $content, TRUE);
	
	$this->load->view('pagesites', $this->data);  
}
function  edit_details(){
	
	$content['status'] = $this->auth_model->status();
	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
	
	$content['message'] = "";

	$rules['nam']		= "trim|min_length[0]|max_length[2000]|xss_clean";

	$content['fields'] = $this->fields;
	
    $this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
    
	if (isset($_REQUEST['go']))
		if ($this->validation->run() != FALSE && $this->input->post("go") != "")
	    {
  	   	$this->auth_model->changeProfile($this->data['auth']['login'], 'detailed_info');
  	    $content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";  
  	    header("Location: /".$this->uri->segment(1));     
		}else{
			foreach ($rules as $val=>$srt){
   				if(!empty($this->validation->$val))  $content['user']->$val = $this->validation->$val;}
		}
		
//	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	//$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/edit_details', $content, TRUE);
	$content['edit_details'] =true;
	$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/myprofile', $content, TRUE);
	
	$this->data['Content']['name'] = 'Изменить информацию о себе';
	$this->load->view('pagesites', $this->data);
}

function change_avatar(){
	$this->data['Js'] .= $this->AddJs('swfupload | upload-avatar | ajaxfileupload-avatar | imgareaselect');
	
	$content['status'] = $this->auth_model->status();
	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
	
	$content["message"] ='';
	
		$this->db->where('user', $this->data['auth']['login']);
		$this->db->where('type', 'avatar');
		$this->db->orderby('id','desc');
		$query = $this->db->get('tempfiles');
		if($result = $query->result())
				$file = $result[0];
				
		if(!empty($file) && isset($_REQUEST['go'])){//print_r($file);
			$foto['name'] = $file->file_name;
			//$foto['size'] = filesize('admin/uploads/'.$file->id);
			$foto['tmp_name'] = 'admin/uploads/'.$file->id;

		//if(!empty($_FILES['avatar']['tmp_name'])){
		//	$foto = $_FILES['avatar'];
			//if($foto['size'] > 1000000){$content["message"] ='Не больше 1Mb';break;}
			
			$this->load->helper('img_resize');
			img_resize($foto['tmp_name'], $foto['tmp_name'], 100, 150,  100, 0xFFFFFF, 0);
			$foto['size'] = filesize($foto['tmp_name']);
			//$foto['name'] = str_ireplace('.png', '.jpg', $foto['name']);
			
			$this->load->model('file_model');
			$user=$this->auth_model->getUser($this->data['auth']['login']);
			if ($user->avatar){
				$id = $this->file_model->upfile($user->avatar, $foto /*,$_POST['fio']*/);
				copy($foto['tmp_name'], 'admin/media/'.$id);}
			else{
				$id = $this->file_model->addfile($foto /*,$_POST['fio']*/);
				copy($foto['tmp_name'], 'admin/media/'.$id);
				$this->file_model->joinfile('members', 'avatar', $id, array('email' => $this->data['auth']['login']));}
			
			$this->db->delete('tempfiles', array('id' => $file->id));		
			@unlink($foto['tmp_name']);
			//$user->avatar = $id;
			$content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";
			
			foreach ($result as $row){
				@unlink('admin/uploads/'.$row->id);
				$this->db->delete('tempfiles', array('user' => $this->data['auth']['login'], 'type'=>'avatar'));
			}
			
			header("Location: /".$this->uri->segment(1));
		}elseif(isset($_REQUEST['go'])) header("Location: /".$this->uri->segment(1));
		
	$content['fields'] = $this->fields;
    $content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	
	//$this->data['Content']['text'] = $this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/change_avatar', $content, TRUE);
	$content['change_avatar'] =true;
	$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/myprofile', $content, TRUE);	
	$this->load->view('pagesites', $this->data);
}
function  change_password(){
	
	$content['status'] = $this->auth_model->status();
	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
	$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);

	$rules['oldpwd'] =   "trim|required|min_length[2]";
	$rules['newpwd1'] =   "trim|required|matches[newpwd2]|min_length[4]";
	$rules['newpwd2'] =   "trim|required|min_length[4]";
	$rules['cod'] = "trim|required|callback_check_captcha";
	
	$content['fields'] = $this->fields;
	
	$this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
    $this->validation->set_rules($rules);
    
    if ($this->validation->run() != FALSE)
    {
	  $content["run"] = true;
 	  $this->auth_model->addUser();//поля настроить
 	  $this->lang->load('auth',$this->db_session->userdata('lang'));
	  if(!$this->auth_model->sendActivationEmail())  $content["message"] = "<div class='report_no'>".$this->lang->line('error_mail')."</div>";
      else    										   $content["message"] = "<div class='report_yes'>".$this->lang->line('mail_good_act')."</div>";
 	  
      $this->validation=false;
      header("Location: /".$this->uri->segment(1));
    }
    
	$this->data['Content']['name']='Изменить пароль';
	//$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/change_password', $content, TRUE);	
	$content['change_password'] =true;
	$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/myprofile', $content, TRUE);
	
	$this->load->view('pagesites', $this->data);	
}

function framing($arr, $pred='', $post=''){
	foreach ($arr as &$elem)
		if(is_string($elem)) $elem = $pred.$elem.$post;
return $arr;
}
function unique_email($str){
	if ($this->auth_model->existEmail($str)){
		$this->validation->set_message('_unique_email', 'Пользователь с таким %s уже существует');
		return FALSE;
	}else 
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
function notnull($str){
	if(empty($str) || $str==null || $str=='null' || $str=='NULL'){
		$this->validation->set_message('notnull', $this->lang->line('notnull'));
		return false;}
	return true;
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
function nickcheck($str){
	if(isset($_POST[$str]) && !empty($_POST[$str])) return true;
	
	$this->validation->set_message('nickcheck', $this->lang->line('emptynick'));
	return false;
}
}
?>