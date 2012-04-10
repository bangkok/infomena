<?if(isset($cnt)&&isset($per_page)):?>
<div class="block_str">
<?php if ($cnt>$per_page):?>
    <div class="pagination">
        <span><b>Странницы: </b></span>
        <?php echo $links ?> 
    </div>
<?php endif;?>
</div>
<?endif;?>