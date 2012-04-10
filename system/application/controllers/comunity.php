<?php
@include_once("base.php");

class Comunity extends Base
{
	function __construct()
	{
		parent::Base();
	}
	
	
	function index()
	{
		$this->load->model('comunity_model');
		
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
		
		$Comunity = $this->comunity_model->Comunity($poles);
		//$this->comunity_model->tprint();
		$content['comunity'] = $Comunity;
		$this->data['Content']['text'] = $this->load->view($this->data['papka'].'/comunity', $content, true);
		$this->load->view('pagesites', $this->data);
	}
	
	
}
?>