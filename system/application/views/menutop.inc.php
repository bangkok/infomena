<?$this->load->helper('menu');?>
<?if(!empty($Menu)) foreach ($Menu as $m):?>
 <li>
 <?if(isset($this->data['LMap'][$this->data['Content']['id']])) $cur = $this->data['TMap'][$this->data['LMap'][$this->data['Content']['id']]] [$this->data['Content']['id']];else $cur = NULL;?>
   <?if(isparent($cur ,$m['id'])/* && $this->uri->uri_string()==$m['link']*/ || $this->uri->uri_string()==$m['link'] ):?>
 <a class="active" href="<?=$m['link']?>" title="<?=$m['name']?>"><span class="l"></span><span class="r"></span><span class="t"><?=$m['name']?></span></a>
   <?else:?>
 <a href="<?=$m['link']?>" title="<?=$m['name']?>"><span class="l"></span><span class="r"></span><span class="t"><?=$m['name']?></span></a>
     
 
    <?endif;?>     
  </li>
   <?endforeach;?>

