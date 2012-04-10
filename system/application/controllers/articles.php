<?php
@include_once("base.php");

class Articles extends Base
{
 function __construct()
   {
    parent::Base();
    $this->load->library('pagination');
    $this->load->model('viewconfig_model');
    $this->load->model('publication_model');

		$this->data['BussinesMenu'] = $this->config_model->getMenuByMarker('information_menu');
		$this->data['BussinesMenu'] = $this->load->view('block/bussinesmenu.php', $this->data, true);
		
		$this->data['Content']['text'] = $this->data['BussinesMenu'];    
   }

function _remap()
    {
     $link=''; $fl=true;
     for($i=1;$fl&&$this->uri->segment($i);$i++){
        $link.="/".$this->uri->segment($i);
        if(stristr($this->uri->segment($i+1),'page')||
           stristr($this->uri->segment($i+1),'show'))    $fl=false;
        }
     
      if(stristr($this->uri->uri_string(),'show'))
           $this->show ($link,$this->uri->segment($i-1),$this->uri->segment($i+1));
      else 
      	if(($uri=$this->uri->segment(2))!=''){
           if(method_exists($this, $uri)) $this->$uri($link,$this->uri->segment($i-1),$i+1);
           //else $this->norun();}
           else  $this->index($link,$this->uri->segment($i-1),$i+1);}
      else  $this->index($link,$this->uri->segment($i-1),$i+1);
     
     
    }
   
function index($link,$table,$str){
	//$this->news($link,$table,$str);
	header('location: /information/news');
}
    
    
function articles($link,$table,$str)
    {
    	//print "<br> ------ ".$link;
    	//print "<br> ------ ".$table;
    	//print "<br> ------ ".$str;
    	
    	$table = "articles";
    	$type = "articl";
    	
     $this->data['cnt'] = $this->publication_model->getCnt($table,$type,$this->data['lang']);
      if(empty($this->data['cnt'])){
           $this->lang->load('publication',$this->data['lang']);
           $this->data['no_info_all']=$this->lang->line('no_info_all');
         }
      elseif ($this->data['cnt']<$this->uri->segment($str)){
      	   $this->lang->load('publication',$this->data['lang']);
           $this->data['no_info_all']=$this->lang->line('no_info_str',$this->data['lang']);
           $this->data['lenta']=$this->lang->line('lenta');
           $this->data['link2']=$link;
    }
      
          
      $this->data['per_page']=$this->config_model->getConfigName('articles_lenta',$this->data['lang']);
      $config=$this->viewconfig_model->getNumPage(base_url().$link."/page/",$str,$this->data['cnt'],$this->data['per_page'],$this->data['lang']);
      $this->pagination->initialize($config);
      $this->data['links'] = $this->pagination->create_links();
      $this->data['page'] = $config['page'];

      $this->data['Publication'] = $this->publication_model->getPublic($table, $this->data['per_page'], $this->uri->segment($str),$type,$this->data['lang']);
      
     // print_r($this->data['Publication']);
      
      $this->data['link']=$link."/show/";
      $this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/articles', $this->data, true);
      $this->load->view('pagesites', $this->data);
    }
function news($link,$table,$str)
    {
    	//print "<br> ------ ".$link;
    	//print "<br> ------ ".$table;
    	//print "<br> ------ ".$str;
    	
    	$table = "articles";
    	$type = "news";
    	
     $this->data['cnt'] = $this->publication_model->getCnt($table,$type,$this->data['lang']);
      if(empty($this->data['cnt'])){
           $this->lang->load('publication',$this->data['lang']);
           $this->data['no_info_all']=$this->lang->line('no_info_all');
         }
      elseif ($this->data['cnt']<$this->uri->segment($str)){
      	   $this->lang->load('publication',$this->data['lang']);
           $this->data['no_info_all']=$this->lang->line('no_info_str',$this->data['lang']);
           $this->data['lenta']=$this->lang->line('lenta');
           $this->data['link2']=$link;
    }
      
          
      $this->data['per_page']=$this->config_model->getConfigName('articles_lenta',$this->data['lang']);
      $config=$this->viewconfig_model->getNumPage(base_url().$link."/page/",$str,$this->data['cnt'],$this->data['per_page'],$this->data['lang']);
      $this->pagination->initialize($config);
      $this->data['links'] = $this->pagination->create_links();
      $this->data['page'] = $config['page'];

      $this->data['Publication'] = $this->publication_model->getPublic($table, $this->data['per_page'], $this->uri->segment($str),$type,$this->data['lang']);
      
     // print_r($this->data['Publication']);
      
      $this->data['link']=$link."/show/";
      $this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/articles', $this->data, true);
      $this->load->view('pagesites', $this->data);
    }    


    
    
function show($link,$table,$id)
    {   
    	//print "<br> ------ ".$link;
    	///print "<br> ------ ".$table;
    	//print "<br> ------ ".$id;
//------------ N id и линк на страннице -------------
    	$this->data['Publication'] = $this->publication_model->getPublicById($id,$table,$this->data['lang']);
        $this->data['link']=$link;
//------------ N id и линк на страннице -------------
//------------ Подключаются языковые тексты ---------
            //if(eregi('publication',$this->uri->uri_string()))
             $this->lang->load('publication',$this->data['lang']); /*
       else if(eregi('press/',$this->uri->uri_string()))
             $this->lang->load('press'); 
       else  $this->lang->load('news'); */
//------------ Подключаются языковые тексты ---------
//------------ Контент новости ----------------------
       if(!empty($this->data['Publication'])){
          $this->data['Content']['name'].="&nbsp;|&nbsp;".$this->data['Publication']->title;
          if($this->data['Publication']->id == 181) $this->data['Content']['title']= 'Гаупсин';
          if($this->data['Publication']->id == 183) $this->data['Content']['title']= 'Селитра';
         // array_push( $this->data['Content']['sitepath'], array('link'=>$link.'/'.$this->data['Publication']->id, 'name'=>$this->data['Publication']->title));
         }
        else
          $this->data['no_info_num']=$this->lang->line('no_info_num').$id;
        $this->data['lenta']=$this->lang->line('lenta');
        $this->data['origin']=$this->lang->line('origin');
//------------ Контент новости ----------------------


       // $this->data['id']=$id;
        /*
//        include_once("forma/comment1.php");    // ����� ��� �����������
// ========================= ����������� =====================       
$this->load->model('comments_model'); 
$why='press';
include_once("forma/recordcom.php");   // ��� ����� ����� ����� ������������ � ������ �����������
include_once("forma/comment1.php");    // ����� ��� �����������
$this->data['Comment']=$this->comments_model->Comment($id,$why);    
// ========================= ����������� =====================
        */

if ($this->input->post('send')){
	$this->data['t']=1;
    $rules['name'] = "required|max_length[50]";
    $rules['message'] = "required|max_length[500]";
    $rules['captcha'] = "required|callback_check_captcha";

    // set validation rules
     $this->validation->set_rules($rules);
    // set field names for validation
     $fields['name'] = "'Имя'";
     $fields['message'] = "'Текст сообщения'";
     $fields['captcha'] = "'Подтверждающий код'";
    // set field name
     $this->validation->set_fields($fields);
    // check validation
    
     if($this->validation->run() == true)
       {#all ok
       	 $this->data['t']=2;
         $this->konf_model->addComment($id, $this->validation->name, $this->validation->message);
         $this->db_session->set_userdata('captcha', '');
         $show_message[] = "Ваше сообщение успешно добавлено";
       }
     else{
         $show_message[]  = $this->validation->name_error;
         $show_message[]  = $this->validation->message_error;
         $show_message[]  = $this->validation->captcha_error;
         //print($this->validation->captcha_error);
        }
     $this->data['show_message'] = $show_message;
    }
    //$this->data['comments'] = $this->konf_model->getCommentsByProductId($id);
    //$this->data['content'] = $this->load->view('onenews', $this->data, true);
    $this->data['Content']['text'] = $this->load->view($this->data['papka'].'/onearticle', $this->data, true);
    
   /// print_r($this->data['comments']);
        
        
        $this->load->view('pagesites', $this->data);    	
    }
    
    
    
function date($t, $y='',$m='',$d=''){
	
	    $this->data['Calendar']= $this->calendar_model->getValue('/news/date',$y,$m);
    
	    $this->load->library('pagination');

        $config['base_url'] = base_url().'/news/page/';
        $this->data['per_page'] = $config['per_page'] = 10; #news per page
        $this->data['cnt'] = $this->news_model->getCntNews(); #count news
        $config['total_rows'] = $this->data['cnt'];
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&raquo;';
        $config['next_link'] = "следующая &#8594;";
        $config['prev_link'] = "&#8592; предыдущая";
        $config['cur_tag_open'] = '<span class="select">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="link">';
        $config['num_tag_close'] = '</span>';
        
        $this->pagination->initialize($config);
        //$num = $this->uri->segment(3);

        // load templates
        $this->data['links'] = $this->pagination->create_links();
        
        $this->data['news'] = $this->news_model->getNewsDate($config['per_page'], '', $y,$m,$d);
        
        $this->data['content'] = $this->load->view('news', $this->data, true);
	
	
	
	$this->load->view('layout', $this->data);
}    
    
}
?>