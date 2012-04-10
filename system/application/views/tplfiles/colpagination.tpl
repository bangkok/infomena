<?if(isset($Pagkol[1])&&$Pagkol[1]['n'] < $cnt):?>
<div class="block_str">
<?/*php if ($cnt>$per_page):*/?>
    <div class="pagination">
        <span><b>Выводить по: </b></span>
        <?php foreach ($Pagkol as $p):if($p['n'] < $cnt):
                if($p['n']==$par['v']):?>
                    <span class="config_numpage_page" ><?=$p['n']?></span>
                <?php else:?>     
                   <span><a class="config_numpage_tag" href="<?=$p['link']?>"><?=$p['n']?></a></span>
        <?php endif; endif; endforeach;?> 
    </div>
<?/*php endif;*/?>
</div>
<?endif;?>