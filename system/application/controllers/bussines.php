<?php
@include_once("base.php");

class bussines extends Base
{
	function __construct()
	{
		parent::Base();
		$this->POST = $_POST;
		$this->load->library('validation');
		$this->lang->load('validation',$this->data['lang']);
		$this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		$this->load->model('catalog_model');

		$this->fields=$this->config_model->fields();
		$this->data['BussinesMenu'] = $this->config_model->getMenuByMarker('bussines_menu');//$this->config_model->ExtendedMenu('menu', 'bussines_menu');
		//print_r($this->data['BussinesMenu']);
		//if($this->data["Cnt"]['bussines']->predl)$this->data['BussinesMenu']['child'][27]['name'].=" (".$this->data["Cnt"]['bussines']->predl.")";
		//if($this->data["Cnt"]['bussines']->spros)$this->data['BussinesMenu']['child'][28]['name'].=" (".$this->data["Cnt"]['bussines']->spros.")";
		$this->data['BussinesMenu'] = $this->load->view('block/bussinesmenu.php', $this->data, true);
		
		$this->data['Content']['text'] = $this->data['BussinesMenu'];
		$this->data['Content']['name'] = "Мой обмен";
		$this->comis = 1+($this->config_model->getConfigName('comis',$this->data['lang']) / 100);
	}
	
	function _remap()
    {
      if(($uri=$this->uri->segment(3))!=''){
           if(method_exists($this, $uri)) $this->$uri();
           //else $this->norun();}
           else $this->index();}
      else $this->index();
    }
    
	function norun(){
		$this->load->view('pagesites', $this->data);
	}	
	function index()
	{
		if(!$srch = $uri=$this->uri->segment(3)) header("Location: /ppage/my_bussines/my_predl");
		
		$this->db->where("catalog.tegs LIKE '%$srch%'");
		$cnt = $content['cnt'] = $this->catalog_model->Cnt();
		
		$str = $this->uri->segment(4);if(!is_numeric($str)) $str=0;
		$this->load->library('pagination');
		$config['base_url'] = "/ppage/my_bussines/".$srch;//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span><font color="#6172BA">|</font>';
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
		
		$this->db->where("catalog.tegs LIKE '%$srch%'");
		$content['catalog'] = $this->catalog_model->Get(null,3,$str);
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/notebook',$content,true);		
		//if(''== $this->uri->uri_string())
       
       
		
		$this->load->view('pagesites', $this->data);
	}
	function imgareaselect(){
		$this->data['Js'] .= $this->AddJs('imgareaselect');
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/imgareaselect','',true);
		$this->load->view('pagesites', $this->data);
	}
	function upload_crop(){
		print_r($this->POST);
		echo "hfghfhfh";
		//$this->load->helper('upload_crop');

	}
	
	function add(){
		$this->data['Js'] .= $this->AddJs('swfupload | upload | ajaxfileupload | imgareaselect');
		//print_r($_POST);
		$this->load->helper(array('form', 'url'));
		$rules['type'] =   "trim|required";
		$rules['title'] =  "trim|required|max_length[255]|xss_clean";
		$rules['desc'] =   "trim|xss_clean";
		
		$rules['razdel'] =   "trim|required|numeric";
		$rules['tegs'] =   "trim|max_length[255]";
		$rules['price_info'] =   "trim|required|numeric|xss_clean";
		$rules['price_cash'] =   "trim|numeric|xss_clean";
		$rules['breack_dat'] =   "callback_date_check";
		

		$content['fields'] = $this->fields;
	
		$this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
	    $this->validation->set_rules($rules);
    
		$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
		
		$this->db->where('user', $content['user']->login);
		$this->db->where('type', 'bussines');
		$query = $this->db->get('tempfiles');
		if($result = $query->result())
				$content['images'] = $result;
			
		
		//if (isset($_REQUEST['go']))
			if ($this->validation->run() != FALSE && $this->input->post("go") != "")
			{
				$old = explode('-', $_POST['breack_date']);
				$_POST['breack_date'] = date("Y-m-d",mktime(0, 0, 0, $old[1], $old[0], $old[2]));
				//$_POST['price_cash']  = $_POST['price_info'] * $_POST['peri']
				//$cat_id = $this->catalog_model->insert($content['user']->id,'type | razdel | title | desc | tegs | pay_type | price_info | price_cash | valuta');
				if($_POST['pay_type'] == 'info100')$_POST['peri'] = 100;
				$cat_id = $this->catalog_model->insert($content['user']->id,'type | razdel | title | desc | tegs | pay_type | peri | price_info | price_cash | valuta | breack_date | status | status_self');

				if(!empty($content['images'])){
					$this->load->model('file_model');					
					foreach ($content['images'] as &$file){
						$bigimgid = false;
						$foto['name'] = $file->file_name;
						$foto['size'] = //filesize('admin/uploads/'.$file->id);
						$foto['tmp_name'] = 'admin/uploads/'.$file->id;
						
						$this->load->helper('img_resize');
						$size = getimagesize($foto['tmp_name']);
						if($size[0] > 500 || $size[1] > 250){
							img_resize($foto['tmp_name'], $foto['tmp_name'], 500, 250,  100, 0xFFFFFF, 0);
						}
						if($size[0] > 220 || $size[1] > 120){
							$id = $this->file_model->addfile($foto);
							$this->db->insert('cat_img', array('pos'=>$cat_id,'image'=>$id));
							$bigimgid = mysql_insert_id();
							copy($foto['tmp_name'], 'admin/media/'.$id);
							img_resize($foto['tmp_name'], $foto['tmp_name'], 220, 120,  100, 0xFFFFFF, 0);	
						}			
						$id = $this->file_model->addfile($foto);
						if(isset($bigimgid) && $bigimgid)
							$this->file_model->joinfile('cat_img', 'prevue', $id, array('id' => $bigimgid));
						else
							$this->db->insert('cat_img', array('pos'=>$cat_id,'prevue'=>$id));
						copy($foto['tmp_name'], 'admin/media/'.$id);
						
						
						$this->db->delete('tempfiles', array('id' => $file->id));
						
						//$this->file_model->joinfile('cat_img', 'pos', $id, array('email' => $this->data['auth']['login']));
						@unlink($foto['tmp_name']);
					}
					unset($content['images']);	
				}

				//$this->validation=false;
				$this->load->model('purses_model');
				$this->purses_model->present($content['user']->id, $_POST['type']);
				$this->auth_model->rating($content['user']->id, 'add'.$_POST['type']);

                $this->lang->load('message',$this->data['lang']);
				$this->db_session->set_flashdata('message', $this->lang->line('addedlot'));
				header('location: #add');
				//$content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";
			}
			
		if(isset($this->data['Catalog'])) $content['Razdel'] = $this->data['Catalog'];
		else {$content['Razdel'] = $this->catalog_model->getCatalog();}
		
		$content['Valuta'] = $this->catalog_model->getValutes();
		$content['Cat_stat'] = $this->config_model->table('cat_status','',array('sort'=>'desc'));
	
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/bussines_add',$content,true);
		$this->load->view('pagesites', $this->data);
	}
	function edit(){
	//$auri = explode("/", $this->uri->uri_string);
	//foreach ($auri as &$segment){if($segment == __FUNCTION__) break; $segment = null;}
	//$auri = array_diff($auri, array(NULL));

	$id = $this->uri->segment(4);
		$this->data['Js'] .= $this->AddJs('swfupload | upload | ajaxfileupload | imgareaselect');
		//print_r($_POST);
		$this->load->helper(array('form', 'url'));
		$rules['type'] =   "trim|required";
		$rules['title'] =  "trim|required|max_length[255]|xss_clean";
		$rules['desc'] =   "trim|xss_clean";
		
		$rules['razdel'] =   "trim|required|numeric";
		$rules['tegs'] =   "trim|max_length[255]";
		$rules['price_info'] =   "trim|required|numeric|xss_clean";
		$rules['price_cash'] =   "trim|numeric|xss_clean";
		$rules['breack_dat'] =   "callback_date_check";
		

		$content['fields'] = $this->fields;
	
		$this->validation->set_fields( $this->framing($this->fields, '"<b>', '</b>"') );
	    $this->validation->set_rules($rules);
    
		$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
		$poles = array('user'=>$content['user']->id, 'catalog.id'=>$id);
		$content['catalog'] = $this->catalog_model->Get($poles);
		$content['catalog'] = $content['catalog'][0];
		//print_r($content['catalog']);
		$content['catalog']->images = $this->catalog_model->images($content['catalog']->id);
		//print_r($content['catalog']);
		
		$this->db->where('user', $content['user']->login);
		$this->db->where('type', 'bussines');
		$query = $this->db->get('tempfiles');
		if($result = $query->result())
				$content['images'] = $result;
			
		
		//if (isset($_REQUEST['go']))
			if ($this->validation->run() != FALSE && $this->input->post("go") != "")
			{
				$old = explode('-', $_POST['breack_date']);
				$_POST['breack_date'] = date("Y-m-d",mktime(0, 0, 0, $old[1], $old[0], $old[2]));
				//$cat_id = $this->catalog_model->insert($content['user']->id,'type | razdel | title | desc | tegs | pay_type | price_info | price_cash | valuta');
				if($_POST['pay_type'] == 'info100')$_POST['peri'] = 100;
				$cat_id = $this->catalog_model->update('',array('user'=>$content['user']->id,'id'=>$id),'type | razdel | title | desc | tegs | pay_type | peri | price_info | price_cash | valuta | breack_date | status | status_self');
				$cat_id = $id;

				if(!empty($content['images'])){
					$this->load->model('file_model');					
					foreach ($content['images'] as &$file){
						$bigimgid = false;
						$foto['name'] = $file->file_name;
						$foto['size'] = //filesize('admin/uploads/'.$file->id);
						$foto['tmp_name'] = 'admin/uploads/'.$file->id;
						
						$this->load->helper('img_resize');
						$size = getimagesize($foto['tmp_name']);
						if($size[0] > 500 || $size[1] > 250)
							img_resize($foto['tmp_name'], $foto['tmp_name'], 500, 250,  100, 0xFFFFFF, 1);	
						if($size[0] > 220 || $size[1] > 110){
							$id = $this->file_model->addfile($foto);
							$this->db->insert('cat_img', array('pos'=>$cat_id,'image'=>$id));
							$bigimgid = mysql_insert_id();
							copy($foto['tmp_name'], 'admin/media/'.$id);
							img_resize($foto['tmp_name'], $foto['tmp_name'], 220, 110,  100, 0xFFFFFF, 1);	
						}			
						$id = $this->file_model->addfile($foto);
						if(isset($bigimgid) && $bigimgid)
							$this->file_model->joinfile('cat_img', 'prevue', $id, array('id' => $bigimgid));
						else
							$this->db->insert('cat_img', array('pos'=>$cat_id,'prevue'=>$id));
						copy($foto['tmp_name'], 'admin/media/'.$id);
						
						
						$this->db->delete('tempfiles', array('id' => $file->id));
						
						//$this->file_model->joinfile('cat_img', 'pos', $id, array('email' => $this->data['auth']['login']));
						@unlink($foto['tmp_name']);
					}
					unset($content['images']);	
				}
				
				$content['catalog'] = $this->catalog_model->Get($poles);
				$content['catalog'] = $content['catalog'][0];
				$content['catalog']->images = $this->catalog_model->images($content['catalog']->id);
				
				$this->validation=false;
				$content["message"] = "<div class='report_yes'>".$this->lang->line('profile')."</div>";      
			}else{
		   	    foreach ($rules as $val=>$srt){//echo $this->validation->$val;
		   		if(!empty($this->validation->$val))  $content['catalog']->$val = $this->validation->$val;}
			}
			
		if(isset($this->data['Catalog'])) $content['Razdel'] = $this->data['Catalog'];
		else {$content['Razdel'] = $this->catalog_model->getCatalog();}
		
		$content['Valuta'] = $this->catalog_model->getValutes();
		$content['Cat_stat'] = $this->config_model->table('cat_status','',array('sort'=>'desc'));
	
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/bussines_edit',$content,true);
		$this->load->view('pagesites', $this->data);
	}	
	function del(){
		//$id= $this->uri->segment(4);
		$id= $this->POST['id'];
		$pos = $this->POST['pos'];
		$output = '';
		$type = 'bussines';

		//print_r($pos);
		//$pos = $pos->pos;
		$images = $this->config_model->table('cat_img',array('id'=>$id));
		if($images) foreach($images as $image){
			if(!empty($image->image)){
				@unlink('admin/media/'.$image->image);
				$this->db->delete('nrfl', array('flid' => $image->image));
			}
			if(!empty($image->prevue)){
				@unlink('admin/media/'.$image->prevue);
				$this->db->delete('nrfl', array('flid' => $image->prevue));
			}
			$this->db->delete('cat_img', array('id' => $id));
		}
		$images = $this->catalog_model->images($pos);
		//print_r($images);
		if($images)	foreach ($images as $file){
			$output .=    '<table><tr><td>
	    	<img src="/image/'.$file->prevue.'.jpg" alt="'.$file->file_name.'" class="upimg"></td><td style="vertical-align:middle;text-align:right"><a href="#" onclick="delimg(\''.$file->id.'\',0);return false;" >Удалить фото<a/><div class="br">
	    	</td></td></table><div class="br"></div>';
		}
		
		$result = $this->config_model->row('tempfiles', array('id' => $id));
		if($result){
			$type = $result->type;
			@unlink('admin/uploads/'.$id);
			$this->db->delete('tempfiles', array('id' => $id));
		}
		$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);
		
		$result = $this->config_model->table('tempfiles', array('user'=>$content['user']->login, 'type'=>$type));
		if($result)	foreach ($result as $file)
			$output .=    '<table><tr><td>
	    	<img src="/uploads/'.$file->id.'.jpg?>" alt="'.$file->file_name.'" class="upimg" id="upimg'.$file->id.'" onclick="return ajaxFileUpload('.$file->id.');"></td><td style="vertical-align:middle;text-align:right">
	    	 <a href="#" onclick="return ajaxFileUpload('.$file->id.');">Редактировать</a>
	    	<a href="#" onclick="delimg(\''.$file->id.'\',0);return false;" >Отменить<a/><div class="br">
	    	</td></td></table><div class="br"></div>';
		
		echo $output;
		
	}
	function delite($pos=0){
		if(!$pos) $pos= $this->uri->segment(4);
		if(!$pos) $pos = $this->POST['pos']; 
		if(!$pos) return false;
		
		$user = $this->auth_model->getUser($this->data['auth']['login']);
		if(!$this->config_model->cnt('catalog', array('id'=>$pos,'user'=>$user->id))) return false;

		$this->db->where('id', $pos);
 		$this->db->update('catalog', array('dl' => 'y'));
		//$this->db->delete('catalog', array('id' => $pos));
		header("Location: ".$_SERVER['HTTP_REFERER']);
		//return true;		
		
	}
	function truedelite($pos=0){
		
		if(!$pos) $pos= $this->uri->segment(4);
		if(!$pos) $pos = $this->POST['pos']; 
		if(!$pos) return false;
		
		$user = $this->auth_model->getUser($this->data['auth']['login']);
		if(!$this->config_model->cnt('catalog', array('id'=>$pos,'user'=>$user->id))) return false;
		
	
		$images = $this->config_model->table('cat_img',array('pos'=>$pos,));
		if($images) foreach($images as $image){
			if(!empty($image->image)){
				@unlink('admin/media/'.$image->image);
				$this->db->delete('nrfl', array('flid' => $image->image));
			}
			if(!empty($image->prevue)){
				@unlink('admin/media/'.$image->prevue);
				$this->db->delete('nrfl', array('flid' => $image->prevue));
			}
			$this->db->delete('cat_img', array('pos' => $pos));
		}

		$this->db->delete('catalog', array('id' => $pos));
		header("Location: ".$_SERVER['HTTP_REFERER']);
		//return true;
	}
	
	function my_predl(){
		$content['status']	= $this->auth_model->status();
		$content['user']	= $this->auth_model->getUser($this->data['auth']['login']);

		$str = $this->uri->segment(4);if(!is_numeric($str)) $str=0;
		$poles = array(	 'type'=>'predl'
						,'user'=>$content['user']->id
						//,'TO_DAYS(NOW()) - TO_DAYS(ad) <= 1'=>''
						);
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles,3,$str);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));

		$this->load->library('pagination');
		$config['base_url'] = "/ppage/my_bussines/my_predl";//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span><font color="#6172BA">|</font>';
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
	
		//$this->data['Content']['name'] = "Мои предложения";
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/my_predl',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);	
		
	}
	function my_spros(){
		$content['status']	= $this->auth_model->status();
		$content['user']	= $this->auth_model->getUser($this->data['auth']['login']);

		$str = $this->uri->segment(4);if(!is_numeric($str)) $str=0;
		$poles = array(	 'type'=>'spros'
						,'user'=>$content['user']->id);
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles,3,$str);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		
		$this->load->library('pagination');
		$config['base_url'] = "/ppage/my_bussines/my_spros";//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'перейти к следующему';
		$config['prev_link'] = 'назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span>|';
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
		
		//$this->data['Content']['name'] = "Мой спрос";
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/my_spros',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);
	}
	function predl_of_day(){
		$content['status']	= $this->auth_model->status();

		$str = $this->uri->segment(4);if(!is_numeric($str)) $str=0;
		//$poles = array('type'=>'predl', "DATE_FORMAT(catalog.ad,'%Y-%m-%d')<" => "DATE_FORMAT(time(),'%Y-%m-%d')");
		$poles = array('type'=>'predl', 'DATE_FORMAT(catalog.ad,"%Y-%m-%d") = DATE_FORMAT(NOW(),"%Y-%m-%d")');
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);

		$content['catalog'] = $this->catalog_model->Get($poles,3,$str);
		//print_r($content['catalog']);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));

		$this->load->library('pagination');
		$config['base_url'] = "/ppage/my_bussines/predl_of_day";//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span><font color="#6172BA">|</font>';
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
	
		//$this->data['Content']['name'] = "Мои предложения";
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/predl_day',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);			
	}
	function spros_of_day(){
		$content['status']	= $this->auth_model->status();

		$str = $this->uri->segment(4);if(!is_numeric($str)) $str=0;
		//$poles = array('type'=>'spros');
		$poles = array('type'=>'spros', 'DATE_FORMAT(catalog.ad,"%Y-%m-%d") = DATE_FORMAT(NOW(),"%Y-%m-%d")');
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$content['catalog'] = $this->catalog_model->Get($poles,3,$str);
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		
		$this->load->library('pagination');
		$config['base_url'] = "/ppage/my_bussines/spros_of_day";//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span>|';
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;
		
		//$this->data['Content']['name'] = "Мой спрос";
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/spros_day',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);
	}
	function one_predl(){
		
		if(!$id = $this->uri->segment(4)) $id = 0;

		$content['status']	= $this->auth_model->status();
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));
		
		$poles = array(	'type'=>'predl'
						,'catalog.id'=>$id);
		$content['catalog'] = $this->catalog_model->Get($poles);

		if(!empty($content['catalog'])){
		$user = $this->config_model->table('members',array('id'=>$content['catalog'][0]->user));
		$content['user']	= $this->auth_model->getUser($user[0]->email);
		$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
		
		$this->load->model('comments_model');
		if(!empty($_POST) && !empty($_POST['send']) && !empty($_POST['message'])){
			$temp = $this->auth_model->getUser($this->data['auth']['login']);
			if($this->comments_model->AddCatComment($temp->id))
				$content['message'] = "OK";
		}
		$content['Comments']= $this->comments_model->getCatComments($id);
		$content['CntUserComments'] = $this->comments_model->CntUserComments($content['user']->id);
		$content['CntCatComments'] = $this->comments_model->CntCatComments($id);
		
		$this->data['Menu'] = $this->config_model->getMenuByMarker('members_area_menu');
		$this->config_model->menulink($this->data['Menu']['child'], $content['user']->id);
		//$this->data['Menu']['child'][36]['link'].="/".$content['user']->id;
		if(!empty($content['user']->nickname)) $this->data['Menu']['name'] = str_replace('участника',$content['user']->nickname, $this->data['Menu']['name']);
		}
		$this->data['Content']['name'] = "Мои предложения";
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/one_predl',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);
		
	}
	function one_spros(){
		
		if(!$id = $this->uri->segment(4)) $id = 0;

		$content['status']	= $this->auth_model->status();
		$content['fields'] = $this->fields;
		$content['Valuta'] = $this->config_model->table('valuta','',array('sort'=>'desc'));

		$poles = array(	'type'=>'spros'
						,'catalog.id'=>$id);
		$content['catalog'] = $this->catalog_model->Get($poles);
			
		if(!empty($content['catalog'])){
		$user = $this->config_model->table('members',array('id'=>$content['catalog'][0]->user));
		$content['user']	= $this->auth_model->getUser($user[0]->email);
		$content['geo']= $this->auth_model->geo($content['user']->country, $content['user']->region);
		
		$this->load->model('comments_model');
		if(!empty($_POST) && !empty($_POST['send']) && !empty($_POST['message'])){
			$temp = $this->auth_model->getUser($this->data['auth']['login']);
			if($this->comments_model->AddCatComment($temp->id))
				$content['message'] = "OK";
		}
		$content['Comments']= $this->comments_model->getCatComments($id);	
		$content['CntUserComments'] = $this->comments_model->CntUserComments($content['user']->id);
		$content['CntCatComments'] = $this->comments_model->CntCatComments($id);
		
		$this->data['Menu'] = $this->config_model->getMenuByMarker('members_area_menu');
		$this->config_model->menulink($this->data['Menu']['child'], $content['user']->id);
		//$this->data['Menu']['child'][36]['link'].="/".$content['user']->id;
		if(!empty($content['user']->nickname)) $this->data['Menu']['name'] = str_replace('участника',$content['user']->nickname, $this->data['Menu']['name']);
		}
		$this->data['Content']['name'] = "Мой спрос";
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/one_spros',$content,true);
		//$this->data['Catalog'] = $this->catalog_model->getCatalog();
		$this->load->view('pagesites', $this->data);
		
	}
	function notebook($str=0){
		$table= 'notebook';
		$content['user']	= $this->auth_model->getUser($this->data['auth']['login']);		
		$str = $this->uri->segment(4); 
		$pos_id = $this->uri->segment(5);
		if(is_numeric($pos_id)){
			if($str == 'add'){
				if(!$this->config_model->cnt($table, array('user_id'=>$content['user']->id, 'pos_id'=>$pos_id))){
					$u->user_id = $content['user']->id;
					$u->pos_id = $pos_id;
					$u->up = $u->ad = date("Y-m-d H:i:s");
					$this->db->insert($table, $u);
				}
			}elseif ($str == 'del'){
					$this->db->delete($table,  array('user_id'=>$content['user']->id, 'pos_id'=>$pos_id));
				}
			
		}
		if(!is_numeric($str)) $str=0;
		
		$poles = array(	 "$table.user_id"=>$content['user']->id
						//,'TO_DAYS(NOW()) - TO_DAYS(ad) <= 1'=>''
						);
		$this->db->join($table, "$table.pos_id  = ".$this->catalog_model->getval('table_catalog').".id", "RIGHT");
		$cnt = $content['cnt'] = $this->catalog_model->Cnt($poles);
		$this->db->join($table, "$table.pos_id  = ".$this->catalog_model->getval('table_catalog').".id", "RIGHT");
		$content['catalog'] = $this->catalog_model->Get($poles,3,$str);	
		
		$this->load->library('pagination');
		$config['base_url'] = "/ppage/my_bussines/notebook";//'http://www.your-site.com/index.php/test/page/';
		$config['total_rows'] = $content['cnt'];
		$config['per_page'] = 3; 
		$config['num_links'] = 1;
		$config['next_link'] = 'Вперед';
		$config['prev_link'] = 'Назад';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['cur_tag_open'] = '<span class="config_curpage_tag"><b>';
		$config['cur_tag_close'] = '</b></span>|';
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$links = $this->pagination->create_links();
		
		$content['pager']->links = $links;
		$content['pager']->nums =($str+1)." - ".($str+$config['per_page']<$cnt ? $str+$config['per_page'] : $cnt)." из ".$config['total_rows'] ;		
		$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/notebook',$content,true);
		$this->load->view('pagesites', $this->data);
	}	

function date_check($str){
	$this->lang->load('validation',$this->db_session->userdata('lang'));
	if(empty($str) || $str=='no' || $str=='off'){
		$this->validation->set_message('date_check', $this->lang->line('date_check_no'));
	return false;}
	
	$old = explode('-', $str);
	if(!checkdate($old[1], $old[0], $old[2])){ 
		$this->validation->set_message('date_check', $this->lang->line('date_check_bad'));
		return false;}
	return true;
}
function framing($arr, $pred='', $post=''){
	foreach ($arr as &$elem)
		if(is_string($elem)) $elem = $pred.$elem.$post;
return $arr;
}
}
?>