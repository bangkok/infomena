<?
/**
 * Authorization model class
 *
 */
class Auth_model extends Model
{
	
	var $title  	 	= '';
	var $description 	= '';
	var $link    		= '';
	
	private $table = 'members';
	
	// $Имя поля в модели = 'Название поля в базе'
	private $id = 'id';
	
	private $fio = 'fio';
	private $name = 'name';
	private $sname = 'soname';
	private $nickname = 'nickname';
	private $org = 'org';
	private $nickcheck = 'nickcheck';
	
	private $country = 'country';
	private $region = 'region';
	private $town = 'town';
	
	private $birthdate = 'birthdate';
	private $sex = 'sex';
	private $rating = 'rating';
	
	private $parent_id = 'parent_id';
	 	
	private $login = 'email';
	private $password = 'pwd';
	private $code = 'code';
	private $activated = 'activated';
	private $email = 'email';
	private $avatar = 'avatar';
	
	
	private $tel = 'tel';
	private $mtel = 'mtel';
	private $icq = 'icq';
	private $skype = 'skype';
	private $url = 'url';
	
    private	$status = 'status';
	private	$status_self = 'status_self';
    private	$deviz = 'deviz';
	private	$detailed_info = 'detailed_info';

	private $date_code_gen = 'date_gen';
	private $logdate = 'logdate';
	private $last_login = 'last_login';
	
	

	private $ip = 'ip';
	private $op_sys = 'op_sys';
	private $screen = 'screen';	
	private $browser = 'browser';
	
	private $ad = 'ad';
	private $up = 'up';
	private $dl = 'dl';
	
	private $udata;

	
	function __construct()
	{
		parent::Model();
		$this->db->query('SET NAMES utf8');
		$this->load->model('purses_model');
		
		//$this->datapost();
		//print_r($this->udata);
		
	}

	function datapost($fields = ''){
    	//Заполнение объекта значениями из POST
    	
    	$u->{$this->fio} = $this->input->post("fio");
    	$u->{$this->name} = $this->input->post("nam");
    	$u->{$this->sname} = $this->input->post("fam");
    	$u->{$this->nickname} = $this->input->post("nickname");
    	$u->{$this->org} = $this->input->post("org");
    	$u->{$this->nickcheck} = $this->input->post("nickcheck");
    	
    	$u->{$this->email} = $this->input->post("email");
        $u->{$this->password} = md5($this->input->post("p1"));
        
        $u->{$this->country} = $this->input->post("country");
        $u->{$this->region} = $this->input->post("region");
        $u->{$this->town} = $this->input->post("town");

        $u->{$this->code} = $this->_get_random_word(32);
        
        //$u->dataGen = date("Y-m-d H:i:s");
		//$u->foto = $this->input->post("foto");
		
		$u->{$this->tel} = $this->input->post("tel");
		$u->{$this->mtel} = $this->input->post("mtel");
		$u->{$this->icq} = $this->input->post("icq");
		$u->{$this->skype} = $this->input->post("skype");
		$u->{$this->url} = $this->input->post("url");
		    	
    	$u->{$this->status} = $this->input->post("status");
    	$u->{$this->status_self} = $this->input->post("status_self");
    	$u->{$this->deviz} = $this->input->post("deviz");
		$u->{$this->detailed_info} = $this->input->post("detailed_info");

		$old_y = $this->input->post("year");
		$old_m = $this->input->post("monb");
		$old_d = $this->input->post("dayb");
		//$old = mktime(0, 0, 0, $old_m, $old_d, $old_y);
		$old = $old_y."-".$old_m."-".$old_d;
		$u->{$this->birthdate} = $old;
		$u->{$this->sex} = $this->input->post("sex");
		
   		$u->{$this->up} = $u->{$this->ad} = date("Y-m-d H:i:s");
   		
   		$this->udata = $u; $res=null;
   		if(!empty($fields)){
   			$fieldsa = explode("|",$fields);
	   		foreach ($fieldsa as $field){
	   			$field = trim($field);
	   			if(isset($u->{$this->$field}) && isset($this->$field)){
	   				//$fieldname = $this->$field;
	   				$res->{$this->$field} = $u->{$this->$field};
	   			}
	   		}
   		return $res;
   		}
	}
public function getval($name){
		if(isset($this->$name))
			return $this->$name;
		return false;
	}	
	/**
	 * Check valid username/pasword
	 *
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	function isUser($username, $password)
	{
		//$password = md5($password);
		$sql = "SELECT COUNT(*) AS cnt 
			FROM 
				`".$this->table."` 
			WHERE 
				`".$this->login."`='".$username."' 
				AND `".$this->password."`='".$password."' 
				AND `".$this->activated."`='y'";
		$query = $this->db->query($sql);
		
		$result = $query->result();

		if ($result[0]->cnt > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * Check exist username
	 *
	 * @param string $username
	 * @return boolean
	 */
	function existUsername($username)
	{
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE `".$this->login."`='".$username."'");
		
		$result = $query->result();

		if ($result[0]->cnt > 0)
			return true;
		else 
			return false;
	}

	/**
	 * Check exist email address
	 *
	 * @param string $_email
	 * @return boolean
	 */
	function existEmail($_email)
	{
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE `".$this->email."`='".$_email."'");
		
		$result = $query->result();

		if ($result[0]->cnt > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * Enter description here...
	 * 
	 * username from session info
	 * 
	 * @param unknown_type $_email
	 * @return unknown
	 */
	function existEmailExclude($_email)
	{
		$user = $this->db_session->userdata('user');
		
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE `".$this->email."`='".$_email."' AND `".$this->login."`!='".$user['username']."'");
		
		$result = $query->result();

		if ($result[0]->cnt > 0)
			return true;
		else 
			return false;
	}	

	/**
	 * Get user data by username
	 *
	 * @param string $username
	 * @return Object
	 */
	function getUser($username, $fields ='')
	{
		//$query = $this->db->query("SELECT * FROM `".$this->table."` 
		//	WHERE `".$this->login."`='".$username."'");
		
		$this->db->select("$this->table.*");
		$this->db->select("purses.info as info");
		$this->db->join('purses', "purses.id_user = $this->table.id", "LEFT");
		$this->db->where($this->login,$username);
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			$userLogin = $this->login;
			$userEmail = $this->email;
			$userName  = $this->nickname;
			$row->login = $row->$userLogin;
			$row->email = $row->$userEmail;
			$row->avatar = $row->avatar;
			if(isset($row->nickcheck) && !empty($row->nickcheck))
				$userName = $row->nickcheck;
			$row->name = $row->$userName;
			//$row->old = $row->$userEmail;
			
			if(!empty($fields)){
		   		foreach (explode("|",$fields) as $field){
		   			$field = trim($field);
		   			$res->$field = $row->{$this->$field};
		   		}
	   		return $res;
	   		}

		}
		else 
		{
			$row = null;
		}
		//print_r($row);
		return $row;
	}

	/**
	 * Get user data by Email
	 *
	 * @param string $_email
	 * @return object
	 */
	function getUserByEmail($_email)
	{
		$query = $this->db->query("SELECT * FROM `".$this->table."` 
			WHERE `".$this->email."`='".$_email."'");
		
		$result = $query->result();

		return $result[0];
	}	
	
	/**
	 * Added new user
	 *
	 */
    function addUser()
    {  	
    	$u = $this->datapost('email | password | code
    						| nickname
    						| birthdate | sex 
    						| country | region | town
    						| ad | up
    						');
		//print_r($u);
		$u->reg_date = date("Y-m-d H:i:s");
		$u->ip = $_SERVER['REMOTE_ADDR'];
		if(preg_match('/\((.*)\)/',$_SERVER['HTTP_USER_AGENT'], $matches))
			$u->op_sys = $matches[1];
		$u->screen = $this->input->post("screen");
		$u->browser = $_SERVER['HTTP_USER_AGENT'];
		
        $this->db->insert($this->table, $u);
 /*       
        $id = mysql_insert_id();
	        //$this->load->model('purses_model');
	        $this->purses_model->createPurse($id);
	        $info_reg = $this->config_model->getConfigName('info_reg',$this->data['lang']);
	        $this->purses_model->f1($this->purses_model->getval('InfomenaId'), $id, $info_reg);
*/
    }
    
    function addAddress()
    {
        $u->login = $this->input->post("username");
        $u->state = $this->input->post("state");
        $u->city = $this->input->post("city");
        $u->street = $this->input->post("street");
        $u->house = $this->input->post("house");
        $u->building = $this->input->post("building");
        $u->block = $this->input->post("block");
        $u->apartment = $this->input->post("apartment");
        $u->additional = $this->input->post("additional");

        $this->db->insert('address', $u);
    }
    

	
    function activationUser($user, $code)
    {
		$query = $this->db->query("SELECT * FROM `".$this->table."` 
			WHERE `".$this->login."`='".$user."' AND `".$this->code."`='".$code."'");
		
		$result = $query->result();
		
		if (count($result) > 0)
		{
    		$userActivated = $this->activated;
    				
	        $u->$userActivated = 'y';
	        
			$this->db->where($this->login, $user);
	        $this->db->update($this->table, $u);
	        
//	        $this->load->model('purses_model');
	        $this->purses_model->createPurse($result[0]->id);
	        $info_reg = $this->config_model->getConfigName('info_reg',$this->data['lang']);
	        $this->purses_model->f1($this->purses_model->getval('InfomenaId'), $result[0]->id, $info_reg);
	        
	        if ($this->db->affected_rows() > 0)
	        {
	        	$this->db->query("INSERT user_groups VALUES('".$user."','member','".date("Y-m-d H:i:s")."','')");
	        	return true;
	        }
	        else 
	        	return false;
		}
		else 
		{
			return false;
		}
    }
    
    /**
     * Clear unactivated users accounts after 1 day
     *
     * @return num deleted accounts
     */
    function clearUnactivated()
    {
		$query = $this->db->query("DELETE FROM `".$this->table."` WHERE `".$this->activated."`='n' AND 
			`".$this->date_code_gen."` <'".date("Y-m-d H:i:s", mktime() - (3600*24))."'");
		
		//$result = $query->result();
		
       	return $this->db->affected_rows();
    }
    

    function changeActivationCode($user, $code)
    {
    	$userCode = $this->code;
    	$userDateGen = $this->date_code_gen;    	
    	
    	$u->$userCode = $code;
    	//$u->$userDateGen = date("Y-m-d H:i:s");
		$this->db->where($this->login, $user);
        $this->db->update($this->table, $u);
        
        if ($this->db->affected_rows() > 0)
        	return true;
        else 
        	return false;
    }
    
	/**
	 * Change user password
	 *
	 * @param String $user
	 * @param String $code
	 * @param String $passwd
	 * @return true if changed, false if not changed
	 */
    function changePassword($user, $code, $passwd)
    {
    	/*
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE 
				`".$this->login."`='".$user."' 
				AND `".$this->code."`='".$code."' 
				AND `".$this->date_code_gen."` >='".date("Y-m-d H:i:s", mktime() - (3600*24))."'");
		
		*/
    		$sql = "SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE 
				`".$this->login."`='".$user."' 
				AND `".$this->code."`='".$code."'";
    		
				$query = $this->db->query($sql);
				
			//return true;	
		$result = $query->result();
		
		if ($result[0]->cnt == 0)
		{
        	return false;
		}
		
    	$userPassword = $this->password;
    	$userActivated = $this->activated;
    	
		$u->$userPassword = md5($passwd);
		$u->$userActivated = 'y';
		$this->db->where($this->login, $user);
		$this->db->where($this->code, $code);
		//$this->db->where('`'.$this->login.'` >=', date("Y-m-d H:i:s", mktime() - (3600*24)));
        $this->db->update($this->table, $u);
        
//        if ($this->db->affected_rows() > 0)
       	return true;
//        else 
//        	return false;
    }    
    
    /**
     * Activation check
     *
     * @param String $user
     * @return true if is activated, false if not
     */
    function isActivation($user)
    {
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE `".$this->login."`='".$user."' AND `".$this->activated."`='y'");
		
		$result = $query->result();
		
		if ($result[0]->cnt > 0)
		{
        	return true;
		}
		else 
		{
			return false;
		}
    }	
    
    /**
     * Enter description here...
     *
     * @param unknown_type $user
     * @return unknown
     */
	function sendNewPasswordRequest($user,$mail)
	{
		if ($this->existUsername($user))
		{
			$user = $this->getUser($user);
		}
		else if ($this->existEmail($mail))
		{
			$user = $this->getUserByEmail($mail);
		}
		else return false;
		
		$code = $this->_get_random_word(32);
		
		$userLogin = $this->login;
		$this->changeActivationCode($user->$userLogin, $code);
		
		
		$name = $_SERVER['HTTP_HOST']."| Confirm password change";
		$text_mail = "Ссылка для изменения пароля: ".base_url()."auth/newpassword/".urlencode($user->$userLogin)."/".$code;

		
		return $this->config_model->sendMsg($name, $user->email, $text_mail);

		
		
		//Create the message
//		$message =& new Swift_Message("Подтверждение изменения пароля CityMap", 
//		"Ссылка для изменения пароля: ".base_url()."auth/newpassword/".$user->adid."/".$code, 
//		"text/plain", 
//		"8bit", 
//		"windows-1251");
		/*
		$subj = $_SERVER['HTTP_HOST']."/Подтверждение изменения пароля/";
		$txt = "Ссылка для изменения пароля: ".base_url()."auth/newpassword/".urlencode($user->$userLogin)."/".$code;

		$this->config->load('admin');
		
		require_once APPPATH."libraries/swift/Swift.php";
		require_once APPPATH."libraries/swift/Swift/Connection/SMTP.php";
		
		//Start Swift
		try {
			$smtp =& new Swift_Connection_SMTP($this->config->item('A_SMTP'), $this->config->item('A_SMTP_port'));
			$smtp->setUsername($this->config->item('A_SMTP_user'));
			$smtp->setpassword($this->config->item('A_SMTP_pass'));
			 
			$swift =& new Swift($smtp);
			
			$subj = mb_convert_encoding($subj, 'cp1251', 'utf8');
			$txt = mb_convert_encoding($txt, 'cp1251', 'utf8');
						
			//Create the message
			$message =& new Swift_Message($subj, $txt, "text/plain", "base64", "cp1251");
			
//			$message =& new Swift_Message($subj);
			$message->headers->setLanguage('ru');
			$message->headers->setCharset('cp1251');
			
//			$part1 =& new Swift_Message_Part($txt);
//			$part1->setCharset('UTF-8');
//			$message->attach($part1);
			
			$recipients =& new Swift_RecipientList();
			$userEmail = $this->_email;
			$recipients->addTo($user->$userEmail);
			//Use addCc() - temporary to tests
//			foreach ($this->config->item('A_admin_mail') AS $val)
//				$recipients->addCc($val);
//			foreach ($this->config->item('A_admin_mail') AS $val)
//			$recipients->addCc($this->config->item('A_admin_mail'));
				
			//Now check if Swift actually sends it
			if ($swift->send($message, $recipients, $this->config->item('A_admin_mail_From')))
				return "<p>Вам выслано письмо для подтверждения изменения пароля.</p>";
			else
				return "<p>Произошла ошибка отсылки письма для подтверждения изменения пароля.</p>";
//			return true;
		} catch (Swift_ConnectionException $e) {
//			return false;
			return "Произошла ошибка во время отсылки письма для подтверждения изменения пароля."
				." Пожалуйста, сообщите администратору сервиса по адресу<br />"
				." <a href=\""
				.$this->config->item('A_admin_mail')."\">"
				.$this->config->item('A_admin_mail')."</a>"
				.'<div style="padding-top: 10px; font-weight: normal; font-size: 0.8em;"> ['."There was a problem communicating with SMTP: " . $e->getMessage().']</div>';				
		} catch (Swift_Message_MimeException $e) {
//			return false;
			return "Произошла ошибка во время отсылки письма для подтверждения изменения пароля."
				." Пожалуйста, сообщите администратору сервиса по адресу<br />"
				." <a href=\""
				.$this->config->item('A_admin_mail')."\">"
				.$this->config->item('A_admin_mail')."</a>"
				.'<div style="padding-top: 10px; font-weight: normal; font-size: 0.8em;"> ['."There was an unexpected problem building the email:" . $e->getMessage().']</div>';				
		}
		*/
	}
	
	/**
	 * Generate random string
	 *
	 * @param int $len 
	 * @return random string
	 */
	function _get_random_word($len)
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$str = '';
		for ($i = 0; $i < $len; $i++)
		{
			$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		
		$word = $str;
		
		return $word;
	}
	
	/**
	 * Get user groups by username
	 *
	 * @param string $username
	 * @return Object
	 */
	function getUserGroups($username)
	{
		$groups = array('guest');
		
		$query = $this->db->query("SELECT * FROM `user_groups` 
			WHERE `login`='".$username."'");
		
		$result = $query->result();
		
		if ($query->num_rows() > 0)
		{
			foreach ($result as $val)
			{
				$groups[] = $val->group;
			}
		}
		
		return $groups;
	}
	
	function initialization_Acl() 
	{
		ini_set("include_path",APPPATH."libraries/");
		
		//Подклучаем зендовский загрузчик  
		require_once "Zend/Loader.php";
		$CI =& get_instance();
		$CI->db->query('SET NAMES utf8');
		
		//Загружаем необходимые нам библиотеки ( контроль доступа, роли, ресурсы )  
		Zend_Loader::loadClass('Zend_Acl');  
		Zend_Loader::loadClass('Zend_Acl_Role');  
		Zend_Loader::loadClass('Zend_Acl_Resource');  
	   
		//Создаём новый объект контроля доступа  
		$acl = new Zend_Acl();  
	   
		// определяем роли
		$query = $CI->db->query('SELECT * FROM `groups`');
		
		//print_r($query);
		//print "<br> --- ".$query->num_rows();
		$result = $query->result();
		
		if (is_array($result))
		{
			foreach ($result as $val)
			{
//				var_dump($val);
				$acl->addRole(new Zend_Acl_Role($val->id));		
				$acl->deny($val->id, null);
			}
		}
	   
		//определяем ресурс  
		$query = $CI->db->query("SELECT * FROM `map` WHERE upId!=0 AND resource!=''");
		//print_r($query);
        
        
		$result = $query->result();
		
		if (is_array($result))
		{
			foreach ($result as $val)
			{
				//print"<br><br> ----- ".($val->resource);
				$acl->add(new Zend_Acl_Resource($val->resource));
				
//				echo 'T: ',$val->template,"<br>";
			}
		}
		
		// запрещяем какие либо действия с profile для guest'а и member'а  
	//	$acl->deny('guest','main');  
	//	$acl->deny('member','main');  
	   
		// даем полный доступ admin'у для ресурса profile
		$query = $CI->db->query("SELECT * FROM `acl`");
		//print "<br> ----- ";
		//print_r($query);

		
		$result = $query->result();
		if (is_array($result))
		{
			foreach ($result as $val)
			{
//				var_dump($val);
				try
				{
					if ($val->action != '')
					{
						$acl->allow($val->group, $val->resource, $val->action);
//						echo $val->group,'/',$val->resource,$val->action;
					}
					else
					{
						$acl->allow($val->group, $val->resource);
//						echo $val->group,'/',$val->resource,'/',$val->action,"<br>";
					}
				}
				catch(Exception $e)
				{
//					echo 'EX: ',$val->group,'/',$val->resource,'/',$val->action,"<br>";
				}
			}
		}
	
		// разрешаем member'у доступ для ресурса profile на действия index и modify  
	//	$acl->allow('member' , 'main' , array('index','modify'));  
	   
		return $acl;
	}	
    

	function changeEmailRequest($user, $_email)
    {
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE `login`='".$user."'");
		
		$result = $query->result();
		
		if ($result[0]->cnt == 0)
		{
        	return false;
		}

		$u->uremn = $_email;
		$u->up = 'y';
		$this->db->where($this->login, $user);
        $this->db->update($this->table, $u);
        
		$user = $this->getUser($user);
		$code = $this->_get_random_word(32);
		
		$userLogin = $this->login;
		$this->changeActivationCode($user->$userLogin, $code);
		
		//Create the message
		$subj = $_SERVER['HTTP_HOST']."/Подтверждение изменения Email/";
		$txt = "Ссылка для изменения email: ".base_url()."auth/newemail/".urlencode($user->$userLogin)."/".$code;

		$this->config->load('admin');
		
		require_once APPPATH."libraries/swift/Swift.php";
		require_once APPPATH."libraries/swift/Swift/Connection/SMTP.php";
		
		//Start Swift
		try {
			$smtp = new Swift_Connection_SMTP($this->config->item('A_SMTP'), $this->config->item('A_SMTP_port'));
			$smtp->setUsername($this->config->item('A_SMTP_user'));
			$smtp->setpassword($this->config->item('A_SMTP_pass'));
			 
			$swift = new Swift($smtp);
			
			$subj = mb_convert_encoding($subj, 'cp1251', 'utf8');
						
			//Create the message
			$message = new Swift_Message($subj, $txt, "text/plain", "base64", "UTF-8");
			
//			$message =& new Swift_Message($subj);
			$message->headers->setLanguage('ru');
			$message->headers->setCharset('cp1251');
			
			$recipients = new Swift_RecipientList();
			$userEmail = $this->email;
			$recipients->addTo($user->$userEmail);
			//Use addCc() - temporary to tests
//			foreach ($this->config->item('A_admin_mail') AS $val)
//				$recipients->addCc($val);
//			foreach ($this->config->item('A_admin_mail') AS $val)
//			$recipients->addCc($this->config->item('A_admin_mail'));
				
			//Now check if Swift actually sends it
			if ($swift->send($message, $recipients, $this->config->item('A_admin_mail_From')))
				return "<p>Вам на новый адрес выслано письмо для подтверждения изменения Email.</p>";
			else
				return "<p>Произошла ошибка отсылки письма для подтверждения изменения Email.</p>";
//			return true;
		} catch (Swift_ConnectionException $e) {
//			return false;
			return "Произошла ошибка во время отсылки письма для подтверждения изменения Email."
				." Пожалуйста, сообщите администратору сервиса по адресу<br />"
				." <a href=\""
				.$this->config->item('A_admin_mail')."\">"
				.$this->config->item('A_admin_mail')."</a>"
				.'<div style="padding-top: 10px; font-weight: normal; font-size: 0.8em;"> ['."There was a problem communicating with SMTP: " . $e->getMessage().']</div>';				
		} catch (Swift_Message_MimeException $e) {
//			return false;
			return "Произошла ошибка во время отсылки письма для подтверждения изменения Email."
				." Пожалуйста, сообщите администратору сервиса по адресу<br />"
				." <a href=\""
				.$this->config->item('A_admin_mail')."\">"
				.$this->config->item('A_admin_mail')."</a>"
				.'<div style="padding-top: 10px; font-weight: normal; font-size: 0.8em;"> ['."There was an unexpected problem building the email:" . $e->getMessage().']</div>';				
		}
    }
    
    function changeEmail($user, $code)
    {
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` 
			WHERE 
				`".$this->login."`='".$user."' 
				AND `".$this->code."`='".$code."' 
				AND `".$this->date_code_gen."` >='".date("Y-m-d H:i:s", mktime() - (3600*24))."'");
		
		$result = $query->result();
		
		if ($result[0]->cnt == 0)
		{
        	return false;
		}
		
    	$userEmail = $this->email;
    	
    	$qs = "UPDATE `".$this->table."`
    		SET `$userEmail`=`uremn`
			WHERE 
				`".$this->login."`='".$user."' 
				AND `".$this->code."`='".$code."' 
				AND `".$this->date_code_gen."` >='".date("Y-m-d H:i:s", mktime() - (3600*24))."'";
    	$query = $this->db->query($qs);
		
//		$query->result();
		
       	return true;
    }     

   	function changeProfile($login,$poles)
    { //print"<br> --- ".$_SESSION['auth']['login'];
		$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$this->table."` WHERE $this->login ='".$login."'");
		
		$result = $query->result();
		//print"<br> ---- ";
		if ($result[0]->cnt == 0)
		{
        	return false;
		}
    	$u = $this->datapost($poles);

		
		$this->db->where($this->login, $login);
        $r= $this->db->update($this->table, $u);
    
       	return $r;
       
    }   
    
	function getAddress($username)
	{
		$sql = "SELECT * FROM `address` 
			WHERE `login`='".$username."'";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function delAddressById($id)
	{
		$sql = "DELETE FROM `address` 
			WHERE `id`='".$id."'";
		$query = $this->db->query($sql);
	}
	
	function getAddressById($id)
	{
		$sql = "SELECT * FROM `address` 
			WHERE `id`='".$id."'";
		$query = $this->db->query($sql);
		
		return $query->row();
	}
	
	function  addAddressIfUnique($username)
	{
		$params = $_POST;
		
		$sql = "SELECT * FROM `address` 
			WHERE `login`='".$username."'
			AND state = '".$params['state']."'
			AND city = '".$params['city']."'
			AND street = '".$params['street']."'
			AND house = '".$params['house']."'
			AND building = '".$params['building']."'
			AND block = '".$params['block']."'
			AND apartment = '".$params['apartment']."'
			AND additional = '".$params['additional']."'
			";
		$query = $this->db->query($sql);
		
		$result = $query->result();
		if (count($result) == 0)
		{
	        $u->login = $username;
	        $u->state = $this->input->post("state");
	        $u->city = $this->input->post("city");
	        $u->street = $this->input->post("street");
	        $u->house = $this->input->post("house");
	        $u->building = $this->input->post("building");
	        $u->block = $this->input->post("block");
	        $u->apartment = $this->input->post("apartment");
	        $u->additional = $this->input->post("additional");
	
	        $this->db->insert('address', $u);	
		}
	}
	
	function getMessages($username)
	{
		$sql = "SELECT * FROM `messages` 
			WHERE `user`='".$username."' ORDER BY ad DESC";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function delMessage($id)
	{
		$sql = "DELETE FROM `messages` 
			WHERE `id`='".$id."'";
		$query = $this->db->query($sql);
	}
	
	function getMessage($id)
	{
		$sql = "SELECT * FROM `messages` 
			WHERE `id`='".$id."'";
		$query = $this->db->query($sql);
		
		return $query->row();
	}	
	
	function sendActivationEmail()
	{

		$query = $this->db->query("SELECT * FROM `".$this->table."` WHERE `".$this->email."`='".$this->udata->email."'");
		$result = $query->result();
		
		if (count($result) > 0)
		{
	    	//$userCode = $this->code;
	    	$codepolename = $this->code;
			$code = $result[0]->$codepolename;
		}
		else 
		{
			return false;
		}
		
		$name = $_SERVER['HTTP_HOST']."| Register";
		//$text_mail = "Ссылка для активации: ".base_url()."auth/activation/".urlencode($this->udata->email)."/".$code;
		$this->lang->load('email',$this->data['lang']);
		$text_mail = str_replace(
										array('%NAME%','%CODE%'),
										array($this->udata->nickname, urlencode($this->udata->email)."/".$code), 
										$this->lang->line('TextActivationEmail')
									);
		$text_mail .= $this->lang->line('TextFooterEmail');
		return $this->config_model->sendMsg($name, $this->udata->email, $text_mail);

	}
function geo($country=null, $region=null, $town=null){
	
		$sql = "SELECT * FROM `geo_country` ";
		$sql.=" ORDER BY `title` asc";
		$query = $this->db->query($sql);
		$result = $query->result();
		foreach ($result as $item) $temp[$item->id] = $item;
		$geo['countrys'] = $temp; $temp=null;
		
	if($country != null){
		$sql = "SELECT * FROM `geo_region` ";
		$sql.="WHERE `country_id`='".$country."'";
		$sql.=" ORDER BY `title` asc";
		$query = $this->db->query($sql);
		$result = $query->result();
		foreach ($result as $item) $temp[$item->country_id][$item->id] = $item;
		$geo['regions'] = $temp; $temp=null;
	}
	if($region != null) {
		$sql = "SELECT * FROM `geo_town` ";
		$sql.="WHERE `region_id`='".$region."'";
		$sql.=" ORDER BY `title` asc";
		$query = $this->db->query($sql);
		$result = $query->result();
		foreach ($result as $item) $temp[$item->region_id][$item->id] = $item;
		$geo['towns'] = $temp; $temp=null;
	}
		return $geo;
}
function status(){
	
	$sql = "SELECT * FROM `status` ";
	$sql.=" ORDER BY `sort` desc";
	$query = $this->db->query($sql);
	$res = $query->result();
	foreach ($res as $row)
		$result[$row->id] = $row;
return $result;
}

	function unique($pole, $value, $table='')
	{
		if(empty($table))$table = $this->table;
		$this->db->select("COUNT(*) AS cnt");
		$this->db->where($pole , $value);
		$query=$this->db->get($table);
		//$query = $this->db->query("SELECT COUNT(*) AS cnt FROM `".$table."` 
		//	WHERE `".$pole."`='".$value."'");
		$result = $query->result();
		if ($result[0]->cnt > 0)
			return false;
		else 
			return true;
	}
	function unique_nickname($value){
		$this->db->select("COUNT(*) AS cnt");
		$this->db->where($this->nickname, $value);
		if(isset($this->data['auth']['login']))
			$this->db->where($this->login."!=", $this->data['auth']['login']);
		$query=$this->db->get($this->table);
		$result = $query->result();
		if ($result[0]->cnt > 0)
			return false;
		else 
			return true;
	}
}
?>
