<?php
@include_once("base.php");

class communication extends Base
{

function __construct()
{
	parent::Base();

	//$this->data['BussinesMenu'] = $this->data["TMap"][68][82];
	$this->data['BussinesMenu'] = $this->config_model->getMenuByMarker('my_communication_menu');
	$this->data['BussinesMenu'] = $this->load->view('block/bussinesmenu.php', $this->data, true);
	$this->data['Content']['text'] = $this->data['BussinesMenu'];
}
function _remap()
{
  if(($uri=$this->uri->segment(2))!=''){
	   if(method_exists($this, $uri)) $this->$uri();
	   else $this->norun();}
  else $this->index();
}
function norun(){
	$this->load->view('pagesites', $this->data);
}
function index()
{
	$this->load->view('pagesites', $this->data);
}

function talk()
{
  if(($uri=$this->uri->segment(3))!=''){
	   if(method_exists($this, $uri)) $this->$uri();
  }

	//if(''== $this->uri->uri_string())
   //header("Location: /about");
	$this->load->view('pagesites', $this->data);
}

function network(){
	$this->load->model('comunity_model');

	$content['user'] = $this->auth_model->getUser($this->data['auth']['login']);

	$MyNetwork = $this->comunity_model->MyNetwork($content['user']->id);

	if ( !empty($MyNetwork['child']) ) {

		$MyNetwork['user'] -> net_rating = $this -> comunity_model -> ratingNetwork($MyNetwork['user'] -> id);

		$MyNetwork['user'] -> cnt_net = $this -> comunity_model -> cntNetwork($MyNetwork['user'] -> id);

		foreach ($MyNetwork['child'] as &$member) {

			$member['user'] -> net_rating = $this -> comunity_model -> ratingNetwork($member['user'] -> id);

			$member['user'] -> cnt_net = $this -> comunity_model -> cntNetwork($member['user'] -> id);

			if ( !empty($member['child']) ) {

				foreach ($member['child'] as &$line2) {

					$line2['user'] -> net_rating = $this -> comunity_model -> ratingNetwork($line2['user'] -> id);

					$line2['user'] -> cnt_net = $this -> comunity_model -> cntNetwork($line2['user'] -> id);

				}
				unset($line2);
			}
		}
		unset($member);
	}

	$content['myNetwork'] = $MyNetwork;

	$this->data['Content']['text'] .= $this->load->view($this->data['papka'].'/mynetwork', $content, true);

}
	
}
?>