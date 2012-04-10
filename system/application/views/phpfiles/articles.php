<?if(!empty($Publication)&&count($Publication)>0):?>
   <?$i=1;foreach($Publication as $p):
    //if($Publication[0]==$p):?>
<?if($i%2==0){
	$style="";}else{
	$style='style="background-color:#E8EAF3;"';}?>    
    
    <div class="Publication" <?=$style?>>
     <table class="block" ><tr><td>

        <div>
         <?php if (!empty($p->imagesmall)):?>
            <div class='image'><a  href="<?= $link.$p->id?>" title="<?=$p->title?>">
              <img src="/image/<?= $p->imagesmall?>.jpg"  title="<?=$p->title?>">
             </a></div>
         <?php endif;?>
                 <div class="title"><?=$p->title?></div>
        <div class="date"><?= $p->dates?></div>
        <div style="clear:both; height:10px"></div>
         <?if(!empty($p->anons)):?><?=$p->anons?><?endif;?>
        </div>
     </td></tr></table>
    </div>
  
<?php $i++; endforeach; 
 $this->load->view($tplpapka.'/pagination.tpl');
else:?>
    <p class='inform'>
        <?//=$no_info_all?>
        <?if(isset($lenta)):?><div class="publication_lenta"><a href="<?=$link2?>" title="<?=$lenta?>"><?=$lenta?></a></div><?endif;?>
    </p>
<?//php endif; 
endif;?>
