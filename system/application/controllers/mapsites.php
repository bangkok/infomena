<?php
@include_once("base.php");

class Mapsites extends Base
{
 function __construct()
   {
    parent::Base();
    
   }

function index()
    {
      
   	$this->data['Mapsite']=$this->config_model->getAllMenu(1,$this->data["lang"],'n');
   	//$this->data['Mapsite']=$this->products_model->GetValueMenu($this->data['Mapsite']);

      $this->data['Content']['text'] = $this->load->view($this->data['papka'].'/mapsites', $this->data, true);
      $this->load->view('pagesites', $this->data);
    // print_r($this->data['Menu']);	
    }

}
?>