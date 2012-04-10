<?php
@include_once("base.php");

class Main extends Base
{
	function __construct()
	{
		parent::Base();
		$this->fields=$this->config_model->fields();
	}
	
	
	function index()
	{
		$this->data['Js'] .= $this->AddJs('jcarousellite');
		$this->load->model('catalog_model');
		$this->load->library('pagination');
	//	if(''== $this->uri->uri_string())  header("Location: /");
		if(!isset($this->data['auth']) || empty($this->data['auth']['login'])) 
			$this->data['Content']['text'].= $this->config_model->getConfigName('is_guest',$this->data['lang']);
		$auri = $this->uri->uri_to_assoc(2);
		
		//СПРОС
		$cnt = $this->config_model->cnt('catalog',array('type'=>'spros'));
		if($cnt > 18) $cnt = 18;		
		if('s'==key($auri))$num = 3; else $num = 5;
		$str = $this->uri->segment($num);
				
		$config['base_url'] = "/main";
		if(!empty($auri['p'])) $config['base_url'] .= "/p/".$auri['p']; $config['base_url'] .="/s/";
		$config['total_rows'] = $cnt;
		$config['per_page'] = 6; 
		if($config['per_page'] > $cnt) $config['per_page'] = $cnt;
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span>|';
		$config['uri_segment'] = $num;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		$this->data['Pager']['s']->links = $links;
		$this->data['Pager']['s']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;	
		
		//$this->data['Urgently'] = $this->catalog_model->lastspros($str, $config['per_page']);
		//*
		$poles = array(	 'type'=>'spros');
		$this->db->order_by("catalog.ad", 'desc');
		$this->data['Urgently'] = $this->catalog_model->Get($poles, $config['per_page'], $str);
		//*/
		
		//ПРУДЛОЖЕНИЕ
		$this->db->join('cat_img', "cat_img.pos = catalog.id","LEFT");
		$cnt = $this->config_model->cnt('catalog',array('type'=>'predl', 'prevue!='=>'0', "catalog.dl"=>"n"));
		if($cnt > 18) $cnt = 18;
		if('p'==key($auri))$num = 3; else $num = 5;
		$str = $this->uri->segment($num);
				
		$config['base_url'] = "/main";
		if(!empty($auri['s'])) $config['base_url'] .= "/s/".$auri['s']; $config['base_url'] .="/p/";
		$config['total_rows'] = $cnt;
		$config['per_page'] = $cnt; 
		if($config['per_page'] > $cnt) $config['per_page'] = $cnt;
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span>|';
		$config['uri_segment'] = $num;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['Pager']['p']->links = $links;
		$content['Pager']['p']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
		
		//$content['Predl'] = $this->catalog_model->lastpredl($str, $config['per_page']);
		$poles = array(	'type'=>'predl', 'image!='=>'0');
		$this->db->order_by("catalog.ad", 'desc');
		$content['Predl'] = $this->catalog_model->Get($poles, $config['per_page'],$str);

		shuffle($content['Predl']);
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/main',$content,true);
		
		
		//$this->load->library('menu');
		//$menu = new CI_Menu();
		//echo $menu[9]['name'];
		//echo $this->menu->tprint();
			
				
		$this->data['ShowCatalog'] = true;
		//$this->data['ShowMenuLeft'] = true;
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		//print_r($this->data['Catalog']);
		$this->load->view('pagesites', $this->data);
	}
	
	
}
?>