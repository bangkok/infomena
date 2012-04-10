<?php
@include_once("base.php");

class search extends Base
{
	function __construct()
	{
		parent::Base();
	}
	
	
	function index()
	{
		if($search = $this->input->post("searchq"))
			$this->db_session->set_userdata('searchstr', $search);
			else $search = $this->db_session->userdata('searchstr');
		$content['search'] = $search;
		
		$table_catalog = $this->catalog_model->getval('table_catalog');
       $content['user']	= $this->auth_model->getUser($this->data['auth']['login']);

       $country=null;	$region=null; $town=null; //$razdel = null;
		if(!empty($_POST['country']) && $_POST['country'] != 'null') $country=$_POST['country'];
		if(!empty($_POST['region']) && $_POST['region'] != 'null') $region=$_POST['region'];	
		if(!empty($_POST['town']) && $_POST['region'] != 'null') $town=$_POST['town'];
		$content['geo']= $this->auth_model->geo($country, $region);
		$content['geo']['curcountry'] = $country;
		$content['geo']['curregion'] = $region;
		$content['geo']['curtown'] = $town;		

		$poles=array();
		if(!empty($country) && $country !='null') $poles['geo_country.id']=$country;
		if(!empty($region) && $region !='null') $poles['geo_region.id']=$region;
		if(!empty($town) && $town !='null') $poles['geo_town.id']=$town;
		       
       $content['Type']='';
		if(!empty($_POST) && (!empty($_POST['predl']) xor !empty($_POST['spros']))){
			if(!empty($_POST['predl'])) $content['Type'] = $poles["$table_catalog.type"] = 'predl';
			elseif(!empty($_POST['spros'])) $content['Type'] = $poles["$table_catalog.type"] = 'spros';
		}
		
		$this->db->where("($table_catalog.title LIKE '%$search%' OR $table_catalog.desc LIKE '%$search%' OR $table_catalog.tegs LIKE '%$search%')");
		//$this->db->or_like(array("$table_catalog.title"=>$search, "$table_catalog.desc"=>$search, "$table_catalog.tegs"=>$search));
	
       	$content['catalog'] = $this->catalog_model->Get($poles);	
       	$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/search',$content,true);
		$this->load->view('pagesites', $this->data);
	}
	
	
}
?>