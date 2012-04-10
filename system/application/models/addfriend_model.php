<?class Addfriend_model extends Model 
   {function Addfriend_model()
       {parent::Model();}
    
function Record($mail,$fields)
  { 
  $name = "SITE ".$_SERVER['HTTP_HOST']." | INVITATION";
  $text_mail = "Контакты: ";

  
  $sql="INSERT INTO contacts VALUES(''";   
// ------------------------------
if(isset($_POST['fio'])){
  $text_mail=$text_mail."\r\n\r\n- Ф.И.О: ".$_POST['fio']."\r\n";  
//  $sql=$sql.",'".$_POST['fio']."'"; 
  }
// ------------------------------

// ------------------------------    
if(isset($_POST['message'])){
  $text_mail .= "- Сообщение: ".$_POST['message']."\r\n";
//  $sql=$sql.",'".$_POST['message']."'";
  }
// ------------------------------

//-------------------------------
if($temp = $this->auth_model->getUser($this->data['auth']['login']))
	$user = $this->members_model->GetUser($temp->id);
$text_mail .= '<a href="'.$_SERVER['HTTP_HOST'].'/invite/'.$user->id.'">'.$_SERVER['HTTP_HOST'].'/invite/'.$user->id.'</a>';
//-------------------------------

// $sql=$sql.",'".date("Y-m-d H:i:s")."')";  
 // $this->config_model->sendMsg($name, $mail, $text_mail) ;
$text_mail = "<pre>".$text_mail."</pre>";

if(/*isset($sql)&&$this->db->query($sql)&&*/
	$this->config_model->sendMsg($name, $mail, $text_mail)
	        ) 
		   return '<div class="report_yes" >'.$fields['alertyes'].'</div>';
    else   return '<div class="report_no" >'.$fields['alertno'].'</div>';
	}

	
	
function AddFriendMail(){
		$this->lang->load('email',$this->data['lang']);	
		$name = $_SERVER['HTTP_HOST']."| INVITATION";
		$mail = $this->input->post("mail");
		$user = $this->auth_model->getUser($this->data['auth']['login']);
		$text_mail = str_replace(
										array('%NAME%','%USER%', '%CODE%'),
										array($this->input->post("fio"), $user->nickname, $user->id), 
										$this->lang->line('TextAddfriendEmail')
									);
										
if($this->config_model->sendMsg($name, $mail, $text_mail)) 
		return '<div class="report_yes" >'.$this->lang->line('sendyes').'</div>';
else	return '<div class="report_no" >'.$this->lang->line('sendno').'</div>';	
}	
}


?>