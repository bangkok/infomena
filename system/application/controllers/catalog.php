<?php
@include_once("base.php");

class Catalog extends Base
{
	function __construct()
	{
		parent::Base();
		$this->POST = $_POST;
		$this->load->model('catalog_model');
		$this->fields=$this->config_model->fields();
		
		
	}
	
	function _remap()
    {
      if(($uri=$this->uri->segment(2))!=''){
           if(method_exists($this, $uri)) $this->$uri();
           //else $this->norun();}
           else $this->index();}
      else $this->index();
    }
	function norun(){
		//$this->data['Content']['text'] = $this->config_model->getConfigName('no_text',$this->data['lang']);
		$this->load->view('pagesites', $this->data);
	}
	function index()
	{//print_r($_POST);
		
		$razdel=$this->uri->segment(2);
		if(!is_numeric($razdel))
			if($razdel != 'predl' && $razdel != 'spros'){$poles = array();}
			else{
				$poles['type'] = $this->data['Type']= $razdel;
				$razdel=$this->uri->segment(3);
			}
		$country=null;	$region=null; $town=null; //$razdel = null;
		if(!empty($_POST['country']) && $_POST['country'] != 'null') $country=$_POST['country'];
		if(!empty($_POST['region']) && $_POST['region'] != 'null') $region=$_POST['region'];	
		if(!empty($_POST['town']) && $_POST['region'] != 'null') $town=$_POST['town'];
		if(!empty($_POST['razdel']) && $_POST['razdel'] != 'null') $razdel=$_POST['razdel'];
				
		if(!empty($razdel)) $poles['razdel'] = $razdel;
		if(!empty($country) && $country !='null') $poles['geo_country.id']=$country;
		if(!empty($region) && $region !='null') $poles['geo_region.id']=$region;
		if(!empty($town) && $town !='null') $poles['geo_town.id']=$town;
		
		//$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles);
		//print_r($content['catalog']);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		
		
		$content['geo']= $this->auth_model->geo($country, $region);
		$content['geo']['curcountry'] = $country;
		$content['geo']['curregion'] = $region;
		$content['geo']['curtown'] = $town;
	
		//$this->data['ShowCatalog'] = true;
		//$content['razdel'] =  $this->catalog_model->getCatalog();
		$content['currazdel'] = $razdel;
				
		$content['pager']->links=$content['pager']->nums='';
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/predl',$content,true);		
		$this->load->view('pagesites', $this->data);
	}
/*	
	function predl1(){
		
		$razdel = $this->uri->segment(3);
		$poles = array(	 'type'=>'predl', 'razdel'=>$razdel);
		//$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		$country=null;	$region=null;
		$content['geo']= $this->auth_model->geo($country, $region);
			
		$content['pager']->links=$content['pager']->nums='';
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/predl',$content,true);
				
		$this->data['Type']='predl';
		$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);		
	}
	function spros1(){
		
		$razdel = $this->uri->segment(3);
		$poles = array(	 'type'=>'spros', 'razdel'=>$razdel);
		//$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		$country=null;	$region=null;
		$content['geo']= $this->auth_model->geo($country, $region);
			
		$content['pager']->links=$content['pager']->nums='';
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/spros',$content,true);
				
		$this->data['Type']='spros';
		$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);		
	}
*/
	function show_predl(){
		$content['status']	= $this->auth_model->status();

		$str = $this->uri->segment(3);
		$poles = array(	 'type'=>'predl');
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles,3,$str);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));

		$this->load->library('pagination');
		$config['base_url'] = "/catalog/show_predl";//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span><font color="#6172BA">|</font>';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
	
		$this->data['Content']['name'] = "Предложения";
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/predl',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);			
	}
	function show_spros(){
		$content['status']	= $this->auth_model->status();
		
		$str = $this->uri->segment(3);
		$poles = array(	 'type'=>'spros');
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles,3,$str);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		
		$this->load->library('pagination');
		$config['base_url'] = "/catalog/show_spros";//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span>|';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
		
		$this->data['Content']['name'] = "Спрос";
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/spros',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);
	}
	
	function hispredl(){
		$content['status']	= $this->auth_model->status();
		
		$str = $this->uri->segment(3);
		$poles = array(	 'type'=>'predl' ,'catalog.user'=>$str);
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		$this->load->model('members_model');
		$content['user'] = $this->members_model->GetUser($str);

		$content['pager']->links = "";
		$content['pager']->nums ="";

		$this -> counter_model -> cntHisLots($content['user']->id);
		$this -> counter_model -> fillMenuOfCnt();
		$this->data['Menu'] = $this->config_model->getMenuByMarker('members_area_menu');
		$this->config_model->menulink($this->data['Menu']['child'], $content['user']->id);
		
		$this->data['Content']['name'] = "Предложения ".$content['user']->nickname;
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/predl',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);		
		
	}
	function hisspros(){
		$content['status']	= $this->auth_model->status();
		
		$str = $this->uri->segment(3);
		$poles = array(	 'type'=>'spros' ,'catalog.user'=>$str);
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		$this->load->model('members_model');
		$content['user'] = $this->members_model->GetUser($str);

		$content['pager']->links = "";
		$content['pager']->nums ="";
		
		$this -> counter_model -> cntHisLots($content['user']->id);
		$this -> counter_model -> fillMenuOfCnt();
		$this->data['Menu'] = $this->config_model->getMenuByMarker('members_area_menu');
		$this->config_model->menulink($this->data['Menu']['child'], $content['user']->id);		
		
		$this->data['Content']['name'] = "Спрос ".$content['user']->nickname;
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/spros',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);		
		
	}
}
?>