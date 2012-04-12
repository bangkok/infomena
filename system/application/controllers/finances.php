<?php
@include_once("base.php");

class finances extends Base
{
	function __construct()
	{
		parent::Base();
		$this->POST = $_POST;
		$this->load->library('validation');
		$this->lang->load('validation',$this->data['lang']);
		$this->validation->set_error_delimiters('<div class="report_form">', '</div>');
		$this->load->model('catalog_model');
		$this->load->model('checks_model');	
		$this->load->model('purses_model');

		
		$this->fields=$this->config_model->fields();
		$this->data['BussinesMenu'] = $this->config_model->getMenuByMarker('my_finances_menu');
		$this->data['BussinesMenu'] = $this->load->view('block/bussinesmenu.php', $this->data, true);
		$this->data['Content']['text'] = $this->data['BussinesMenu'];
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
		//if(''== $this->uri->uri_string())
       //header("Location: /about");
		
		$this->load->view('pagesites', $this->data);
	}
	
	function balance(){
		$content['User'] = $this->auth_model->getUser($this->data['auth']['login']);
		//$content['Orders']=$this->checks_model->getUserChecks($content['User']->id);
		$content['Orders']=$this->checks_model->getUserTransactions($content['User']->id);
		//$content='';
		$this->data['Content']['text'].= $this->load->view($this->data['papka'].'/ppage/balance', $content, TRUE);
		$this->load->view('pagesites', $this->data);
	}
	function make_order($id=0){
		//print_r($this->POST);
		//*
		$id=$this->uri->segment(4);
		
		$content['Valuta'] = $this->catalog_model->getValutes();
		$content['User'] = $this->auth_model->getUser($this->data['auth']['login']);
		$content['INum'] = 1+$this->checks_model->numberCheck($content['User']->id);
		if(!empty($_POST)){
			if($asgmt = $this->input->post('asgmt') && $user = $this->checks_model->getUserByNickname($this->input->post('name'),"id")){
				$poles = array(	$this->catalog_model->getval('table_catalog').'.id'=>$_POST['asgmt']);
				
				$catalog = $this->catalog_model->Get($poles);
				//print_r($catalog);
				//$_POST['info'] = $catalog[0]->price_info;
				//$_POST['cash'] = $catalog[0]->price_cash;
				//$_POST['valuta'] = $catalog[0]->valuta;
				
				$comis = round(($_POST['cash'] * $catalog[0]->koef + $_POST['info'])*$this->config_model->getConfigName('comis')/100, 2);
				$_POST['comis'] = $comis;
				//print_r($_POST);
				$id = $this->checks_model->addCheck($content['User']->id, $user->id);
				$_POST = null;

				$this->lang->load('message',$this->data['lang']);
				$this->db_session->set_flashdata('message', $this->lang->line('added_order'));
				header("location: ".$this->uri->uri_string."/".$id);
			}
		}
		
		$content['Orders']=$this->checks_model->getChecksFrom($content['User']->id);

		if($id){
			if($content['Order'] = $this->checks_model->getIdCheck($id)){//print_r($content['Order']);

			$u_table = $this->auth_model->getval('table');
			$u_id = $this->auth_model->getval('id');
			$u_nickname = $this->auth_model->getval('nickname');
			$table_catalog = $this->catalog_model->getval('table_catalog');
			$this->db->select("$table_catalog.*, $u_table.$u_nickname AS nickname");
			$this->db->join($u_table, "$u_table.$u_id  = user", "LEFT");
			$content['Cat'] = $this->config_model->row($table_catalog, array($table_catalog.'.id'=>$content['Order']->asgmt));
			//$content['Cat'] = $this->catalog_model->Get(array($this->catalog_model->getval('table_catalog').'.id'=>$content['Order']->asgmt));
			//echo "<br>"; print_r($content['Cat']);
			//$content['Cat'] = $content['Cat'][0];
			}
		}
		
		if(empty($content['Orders'])) $content['MSG']="Нет счетов";
		
		$this->data['Content']['text'].= $this->load->view($this->data['papka'].'/ppage/make_order', $content, TRUE);
		$this->load->view('pagesites', $this->data);	
	}
	
	function pay_order($id=0){
		$id=$this->uri->segment(4);
		
		if(!empty($_POST) && $checkid = $this->input->post('checkid')){
			$Order = $this->checks_model->getIdCheck($checkid);
			if($Order->confirmed == 0){
				if($Order->info >0)
				$this->purses_model->f1($Order->id_user_to, $Order->id_user_from, $Order->info, 'order', $Order->id);
				if($Order->comis >0){
					$this->load->model('comunity_model');
					$this->data['UserNet'] = $this->comunity_model->MyNetwork($Order->id_user_to);
					$this->purses_model->comis($Order->id_user_to, $Order->comis);
				}
					//$this->purses_model->f1($Order->id_user_to, $this->purses_model->getval('InfomenaId'), $Order->comis, 'comis');
				$this->checks_model->confirmed($checkid);
				
				$this->auth_model->rating($Order->id_user_from, 'bue');
				$this->auth_model->rating($Order->id_user_to, 'sale');
			}
		$content['User'] = $this->auth_model->getUser($this->data['auth']['login']);
		$this->data['auth']['info'] = $content['User']->info;
		//$this->db_session->unset_userdata('auth');
	  	$this->db_session->set_userdata('auth',$this->data['auth']);
		}
		//print_r($this->data['auth']);
		//echo $id;
		$content['Valuta'] = $this->catalog_model->getValutes();
		$content['User'] = $this->auth_model->getUser($this->data['auth']['login']);
		//$content['INum'] = 1+$this->checks_model->numberCheck($content['User']->id);
		
		$content['Orders']=$this->checks_model->getChecksTo($content['User']->id);
		if(empty($id) && !empty($content['Orders']))
			$id = $content['Orders'][0]->id;
			
		if($id){
			if($content['Order'] = $this->checks_model->getIdCheck($id)){//print_r($content['Order']);

			$this->data['Hacks']['ShowDelitedLots'] = TRUE;
			$content['Cat'] = $this->catalog_model->Get(array($this->catalog_model->getval('table_catalog').'.id'=>$content['Order']->asgmt));
			$this->data['Hacks']['ShowDelitedLots'] = FALSE;
				
			if(!empty($content['Cat']))
				$content['Cat']=$content['Cat'][0];
			}
		}
		if(empty($content['Orders'])) $content['MSG']="Нет счетов";

		$this->data['Content']['text'].= $this->load->view($this->data['papka'].'/ppage/pay_order', $content, TRUE);
		$this->load->view('pagesites', $this->data);
		
	}
function	buy_info(){
	$buy=$this->uri->segment(4);
switch ($buy)	{
	case 'wm' : $text = '
<html> 
<head> 
<title>Pay</title> 
</head> 
<body> 
<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" target="_blank"> 
<p>пример платежа через сервис Web Merchant Interface</p> <p>заплатить 1 WMZ...</p> <p> 
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="1.0"> 
<input type="hidden" name="LMI_PAYMENT_DESC" value="тестовый платеж"> 
<input type="hidden" name="LMI_PAYMENT_NO" value="1"> 
<input type="hidden" name="LMI_PAYEE_PURSE" value="Z145179295679"> 
<input type="hidden" name="LMI_SIM_MODE" value="0"> 
</p> <p> 
<input type="submit" value="Оплатить"> </p> </form> </body> </html>
';break;
	default: $content=""; $text = $this->load->view($this->data['papka'].'/ppage/buy_info', $content, TRUE); break;
}


$this->data['Content']['text'].= $text;
$this->load->view('pagesites', $this->data);	
}

function framing($arr, $pred='', $post=''){
	foreach ($arr as &$elem)
		if(is_string($elem)) $elem = $pred.$elem.$post;
return $arr;
}
}
?>