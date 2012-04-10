<?php
class Viewconfig_model extends Model
{
    /***********************************************
     * constructor
     */
    function Viewconfig_model()
    {
        parent::Model();
    }
    
    function getNumPage($url,$uri,$cnt,$per_page,$lang='no')
    {
    	
    	
    	$this->lang->load('page',$lang);
        
    	
    	$config['base_url'] = $url;
        $config['per_page'] = $per_page; 
        
        $config['total_rows'] = $cnt;
        $config['num_links'] = 4;
        $config['uri_segment'] = $uri;
        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&raquo;';
        $config['next_link'] = "следующая &#8594;";
        $config['next_link']=$this->lang->line('next_link');
        $config['prev_link'] = "&#8592; предыдущая";
        $config['prev_link']=$this->lang->line('prev_link');
        $config['cur_tag_open'] = '<span class="config_numpage_page">';
        $config['cur_tag_close'] = '</span>';
        
        $config['num_tag_open'] = '<span>';
        $config['num_tag_close'] = '</span>';
           	
    	$config['page']=$this->lang->line('page');
    	
        return $config;
    }
    
      function Pagkol($link)
    {
    	$config[] = array( 'n' => 5 ,   'link' => $link.'/v/5');
    	$config[] = array( 'n' => 10 ,  'link' => $link.'/v/10');
    	$config[] = array( 'n' => 15 ,  'link' => $link.'/v/15');
    	$config[] = array( 'n' => 50 ,  'link' => $link.'/v/50');
    	$config[] = array( 'n' => 100 , 'link' => $link.'/v/100');
    	$config[] = array( 'n' => 200 , 'link' => $link.'/v/200');
    	$config[] = array( 'n' => 500 , 'link' => $link.'/v/500');
        return $config;
    }    
    
    
}
?>
