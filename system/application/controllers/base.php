<?php
include_once(APPPATH."libraries/core.php");

class Base extends Core
{
function Base()
{
	parent::Core();

 	$this->load->view('head.inc.php','', true);
 	$this->load->model('catalog_model'); 	
	$this->data['Styles'] = $this->AddStyle('style | style.ie7 | style.ie8- | buttons');
	$this->data['Js'] = $this->AddJs('IE6 | jquery | tools | plugins | blockui | corner | scripts | calendar | buttons | google-analytics-');
date_default_timezone_set('Europe/Minsk');
    $this->data['auth']=$this->db_session->userdata('auth');
    
    if(!empty($this->data['auth']['login'])){
	    $temp = $this->auth_model->getUser($this->data['auth']['login']);
		if($temp->info != $this->data['auth']['info']){
			$this->data['auth']['info'] = $temp->info; $this->db_session->set_userdata('auth',$this->data['auth']);}
    }

  $this->data['Messages']['block_message'] = $this->db_session->flashdata('message');
    //$this->db_session->set_userdata('auth','0');
    //print_r($this->data['auth']);
//======================= Контетн ============================
    $this->data['Content'] = $this->config_model->Get_Page($this->uri->segment_array(),$this->router,$this->data['lang']);
//    print_r($this->data['Content']);
    $this->data['Content']['name']=$this->data['Content']['title'];
    //$this->data['Content']['title']=$this->data['Content']['name'];
    //$this->data['Content']['pathsites'] = $this->config_model->getPathById($this->data['Content']['id'],$this->data['lang']);
    $this->data['Content']['copy']=$this->config_model->getConfigName('copy',$this->data['lang']);
    $this->data['Content']['title']=$this->config_model->getConfigName('title',$this->data['lang']);
    $this->data['Content']['adres']=$this->config_model->getConfigName('adres',$this->data['lang']);

    //==== TITLE =========
    $title=$this->data['Content']['title'];
    //$this->data['Content']['title']=$this->config_model->getTitle($this->data['Content']['pathsites'],$title);
    //==== TITLE =========
    
    $this->data['Content']['logoname']=$this->config_model->getConfigName('logoname',$this->data['lang']);

   //==== KEYWORDS DESCRIPTION ======
	if($this->data['Content']['keywords']=='')
		  $this->data['Content']['keywords']=$this->config_model->getConfigName('keywords',$this->data['lang']);
	if($this->data['Content']['description']=='')
      $this->data['Content']['description']=$this->config_model->getConfigName('description',$this->data['lang']);
    //==== KEYWORDS DESCRIPTION ======
    if('' == $this->data['Content']['text']=$this->config_model->getText($this->data['Content']['id']))
    $this->data['Content']['text'] = $this->config_model->getConfigName('no_text',$this->data['lang']);
    $this->data['papka']    = 'phpfiles';
    $this->data['tplpapka'] = 'tplfiles';
//======================= Контетн ============================

//======================= Меню ===============================
//$this->load->library('menu');
//$menu = new CI_Menu();

	$this->config_model->getAllMenu(0,$this->data["lang"],'n');

	$this->config_model->getMenuByMarker();

	if( !empty($this->data['authed']) ) {

		$this -> load -> model('counter_model');

		$this -> counter_model -> setCntIntoMenu();

		$this -> data['Cnt'] = $this -> counter_model -> cnt;
	}
		
	$this->data['Menu'] = $this->config_model->getMenuByMarker('my_cabinet');

	$this->data['MenuTop'] = $this->config_model->getMenuByMarker('top_menu');
	//print_r($this->data['MenuTop']);
	$this->data['MenuLeft'] = $this->config_model->getMenuByMarker('how_the_service_works_menu');
	//print_r($this->data['TopMenu']);

//======================= Меню ===============================
	if( !empty($this->data['authed']) ){

		$this -> data['CntUserComments'] = $this -> counter_model -> cnt['comments'];

		$this -> data['CntMessagesNew'] = $this -> counter_model -> cnt['messages'];
	}



//======================= Блок ===============================

$this->data['Catalog'] = $this->catalog_model->getCatalog(array("type"=>'predl'));

$this->db->select('members.id as id');
$this->db->where('activated','y');
$this->db->join('ci_sessions',"ci_sessions.session_data LIKE CONCAT( '%_', members.email, '_%' )");
$resalt = $this->db->get('members');
$res = $resalt->result();
foreach ($res as $item)
	$online[$item->id] = true;
@$this->data['Online'] = $online;



//print_r($this->data['Online']);
	if($savelogin = $this->db_session->userdata('saveauth')) {
		setcookie ('saveauth', $savelogin);
		$this->db_session->unset_userdata('saveauth'); $this->data['saveauth']=$savelogin;}	
	elseif(!empty($_COOKIE['saveauth'])) $this->data['saveauth']=$_COOKIE['saveauth'];
	
  }



     
    
    
function AddStyle($styleString)
{	
	if(isset($this->data['StylesArray'])) 
		$dataStyle = $this->data['StylesArray'];
	else return false;
	
	$stylesArray = explode('|',$styleString);
	$styleString = '';
	foreach ($stylesArray as $style)
	{
		$style = trim($style);
		if(isset($dataStyle[$style]))
		$styleString .= $dataStyle[$style]."\n";
	}
	return $styleString;
}


function AddJs($jsString)
{	
	if(isset($this->data['JsArray'])) 
		$dataJs = $this->data['JsArray'];
	else return false;
	
	$jsArray = explode('|',$jsString);
	$jsString = '';
	foreach ($jsArray as $js)
	{
		$js = trim($js);
		if(isset($dataJs[$js]))
		$jsString .= $dataJs[$js]."\n";
	}
	return $jsString;
}       
    
}
?>
