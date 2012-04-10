<?php
class Core extends Controller
{
    public $data;
    private $resource =  null;
    private $priviledge = null;

    // роль которая используется если роль пользователья не определена
    protected $default_role = 'guest';


    function Core()
    {
        parent::Controller();
        date_default_timezone_set('UTC'); 
       $this->load->model('config_model');
       $this->router =& load_class('Router');
       
       $this->_log_check();
       $this->_access_check();

       //session_start();
       
       if ($this->router->fetch_method() != 'trf'
        )
        {
            $this->initializeCore();
        }
       else   $this->trf();
    }

    
    function initializeCore()
    {
        //$this->data['lang'] = $this->db_session->userdata('lang');
        
        ///if(!$this->db_session->userdata('lang'))
		      $this->db_session->set_userdata('lang', 'no');
		//$this->data['lang'] = $this->db_session->userdata('lang');
		
	//	if($this->config_model->isLang()) 
		 //  header("location:/".$this->db_session->userdata('lang').$this->uri->uri_string());
		   //header("location:/".$this->db_session->userdata('lang').$this->uri->uri_string());
		   //print"<br> ------- ".$this->db_session->userdata('lang')." --- ".$this->uri->uri_string();
	///	else
		//   $this->db_session->set_userdata('lang', $this->uri->segment(1));
        
        
       $this->data['lang'] = $this->db_session->userdata('lang');		   
		   
        
        
        
        
        // FIX it. Move to DB
       // $this->data["keywords"] = "";

        // FIX it. Move to DB
        //$this->data["description"] = "";


        //		$l_lang['r'] = array(
        //			'Вы авторизованы как:',
        //			'Выйти',
        //			'Войти'
        //		);
        //		$l_lang['u'] = array(
        //			'Ви авторизовані як:',
        //			'Вийти',
        //			'Увійти'
        //		);
        //		$l_lang['e'] = array(
        //			'You are authorized as:',
        //			'Logout',
        //			'Login'
        //		);
        //		$this->data['l_auth'] = $l_lang[$this->data['lang']];

        //		$this->data['catalog'] = $this->main_model->getRooms();
        //		$this->data['curRoom'] = $this->uri->segment(3, 0);
        $this->data["msg"] = '';

        //		if ($this->uri->segment(2, '') != 'compare')
        //			$this->data['decor'] = true;
        //		else
        //			$this->data['decor'] = false;

        //		$this->data['advert'] = $this->load->view('advert.inc.php', $this->data, TRUE);
        //		$this->data['menu'] = $this->load->view('menu.inc.php', $this->data, TRUE);
        //		$this->data['footmenu'] = $this->load->view('footmenu.inc.php', $this->data, TRUE);
        //		$this->data['logo'] = $this->load->view('logo.inc.php', $this->data, TRUE);
        //		$this->data['userinfo'] = $this->load->view('userinfo.inc.php', $this->data, TRUE);
        //
        //		$this->data['basketData'] = $this->order_model->getBasket();
        //		$this->data['basket'] = $this->load->view('basket.inc.php', $this->data, TRUE);
        //		$this->data['basketJS'] = $this->load->view('js/basket.inc.php', $this->data, TRUE);
    }
    
function _remap(){
	//print$metod;
	$this->index();
    }


    
    
function captcha()
    { // print "<br> --------- ";
        $this->load->library('kcaptcha');
        $this->db_session->set_userdata('captcha', $this->kcaptcha->getKeyString());
        exit;
        
    }    
   
function check_captcha($str)
    {
        if ($str !== $this->db_session->userdata('captcha'))
        {
        	//$this->lang->load('forma',$this->db_session->userdata('lang'));
        	$this->CI =& get_instance();
        	$this->lang->load('validation',$this->db_session->userdata('lang'));
        	//print_r($this->CI->lang->language->required);
            //$this->validation->set_message('check_captcha', '�_�� ��_��_��>�_�_�_ ����_�>�_��_�_ ��_�>�� \'<b>�_�_�_ �_�� ���_�'��_���</b>\'');
            $this->validation->set_message('check_captcha', $this->CI->lang->language['code']);
            
            return false;
        }
        else
        {
            return true;
        }
    }

   function trf()
    {
    	$t=$this->uri->segment(3);
        $f = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $x = $this->uri->segment(6);
        $y = $this->uri->segment(7);

        $this->load->plugin('trf');

         create_image_resized($t, $f, $id, $x, $y, $this);

        exit;
    }
    
    function _code_check($str)
    {
        $cap = $this->db_session->userdata('captcha_keystring');
        if (strtolower($str) != strtolower($cap))
        {
            $this->validation->set_message('_code_check', '%s не совпадает с отображенным на картинке');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    // if user not logined go to login
    function _log_check()
    {
        $this->load->model('auth_model');

        $this->data["authed"] = false;

        $user = $this->db_session->userdata('auth');
        
 //       echo "111111111";
//print_r($user);
//print_r($this->auth_model->isUser($user["login"], $user["pass"]));

        if ($user["login"] != "" && $user["pass"] != ""
        && $this->auth_model->isUser($user["login"], $user["pass"]))
        {
            $this->data["authed"] = true;
            $this->default_role = $groups = $this->auth_model->getUserGroups($user["login"]);
            $this->data['auth']["mail"] = $user["mail"];
            $this->data['auth']["userData"] = $this->auth_model->getUser($user['login']);
            $this->data['auth']["logDate"] = $user["logDate"];
            $this->data['auth']["avatar"] = $user["avatar"];
            //print_r($this->data['auth']);
            //print_r( $this->default_role);
        }
        else
        {
            $this->default_role = array('guest');
        }

        // update activity
/*        $log = $this->db_session->userdata('logDate');
        if (isset($log) && $log != "")
        {
            $this->db_session->sess_update();
        }
        else
        {
            $this->db_session->set_userdata('log',date("Y-m-d H:i:s"));
        }
*/
    }

  /***************************************
    
    
    /**
	 * Enter description here...
	 *
	 */
    function _access_check()
    {
        $this->load->model('auth_model');

        // Получаем наш объект из хелпера
        $acl = $this->auth_model->initialization_Acl();
//print_r($acl);
        // обращаемся по ссылке к роутеру для последующего доступа к методам
        $router =& load_class('Router');
        

        // при помощи методов роутера  определяем ресурс и action и устанавливаем их в переменные
        $this->resource = $router->fetch_class();
        $this->priviledge = $router->fetch_method();
        
       // print_r( $this->default_role);

        ///print_r($router);
        // здесь получаем инфу о пользователе и устанавливем её в $default_role
        $allowed = false;
        foreach ($this->default_role as $val)
        {
            try
            {
            	//print"< br> -- ".$this->resource;
            	//print"< br> -- ".$this->priviledge;

                if($acl->isAllowed($val, $this->resource, $this->priviledge))
                {
                    $allowed = true;
                }
            }
            catch(Exception $e)
            {
            }
        }

        if (!$allowed) $this->accessDeny();
       
    }

    /**
	 * Enter description here...
	 *
	 */
    
    
    function accessDeny()
    {
        $this->db_session->userdata('auth');

        $this->lang->load('message','no');

        $this->db_session->set_flashdata('message', $this->lang->line('accessDeny'));

		$url = $_SERVER['HTTP_REFERER'] != "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ? $_SERVER['HTTP_REFERER'] : '/';
		
		header("Location: ".$url);
		
        exit;
    }

}
?>
