<?//$this->load->helper('menu');?>
<?if(!empty($Menu)): $endMenu = end($Menu); foreach ($Menu as $m):?>
<?if ($endMenu['id']!=$m['id']) $sep=' | '; else $sep='';?>

<?//$cur = $this->data['TMap'][$this->data['LMap'][$this->data['Content']['id']]] [$this->data['Content']['id']]?>
<?//if(isparent($cur ,$m['id']) && $this->uri->uri_string()==$m['link'] || $this->uri->uri_string()==$m['link'] ):?>
<?if(false && !stristr($this->uri->uri_string(),$m['link'])):?>

<a style= "font-weight: bold;" href="<?=$m['link']?>" title="<?=$m['name']?>"><?=$m['name']?></a><?=$sep?>
<?else:?>
<a href="<?=$m['link']?>" title="<?=$m['name']?>"><?=$m['name']?></a><?=$sep?>
<?endif;?>
<?endforeach;?>
<?endif;?>