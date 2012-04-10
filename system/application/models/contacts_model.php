<?class Contacts_model extends Model 
   {function Contacts_model()
       {parent::Model();}
    
function Record($mail,$fields)
  { 
  $name = "SITE ".$_SERVER['HTTP_HOST']." | CONTACTS";
  $text_mail = "Контакты: ";

  
  $sql="INSERT INTO contacts VALUES(''";   
// ------------------------------
if(isset($_POST['fio'])){
  $text_mail=$text_mail."\r\n\r\n- Ф.И.О: ".$_POST['fio']."\r\n";  
  $sql=$sql.",'".$_POST['fio']."'"; 
  }
// ------------------------------

// ------------------------------    
if(isset($_POST['mail'])){ 
  $text_mail .= "- E-mail: ".$_POST['mail']."\r\n";
  $sql=$sql.",'".$_POST['mail']."'";
  }
// ------------------------------

// ------------------------------
if(isset($_POST['phone'])){
  $text_mail=$text_mail."- Телефон: ".$_POST['phone']."\r\n";  
  $sql=$sql.",'".$_POST['phone']."'"; 
  }
// ------------------------------

// ------------------------------    
if(isset($_POST['message'])){
  $text_mail .= "- Сообщение: ".$_POST['message']."\r\n";
  $sql=$sql.",'".$_POST['message']."'";
  }
// ------------------------------

 $sql=$sql.",'".date("Y-m-d H:i:s")."')";  
 // $this->config_model->sendMsg($name, $mail, $text_mail) ;
$text_mail = "<pre>".$text_mail."</pre>";

if(isset($sql)&&$this->db->query($sql)
  &&$this->config_model->sendMsg($name, $mail, $text_mail)
	        ) 
		   return '<div class="report_yes" >'.$fields['alertyes'].'</div>';
    else   return '<div class="report_no" >'.$fields['alertno'].'</div>';
	}
	
}
?>