<?if(isset($BussinesMenu)):?><?$BussinesMenu = $BussinesMenu['child']?>
<div class="BussinesMenu">
<?$end=end($BussinesMenu);foreach ($BussinesMenu as $m):?> <?$cnt = !empty($m['cnt']) ? " ({$m['cnt']})" : ''?>
	<?if((isset($m['mapId']) && $this->data['Content']['id'] == $m['mapId']) || (!isset($m['mapId']) && $this->data['Content']['id'] == $m['id'])):?>
	<a href="<?=$m['link']?>"><span style="background-color:#6172BA;color:#fff;padding:2px 5px;"><u><?=$m['name'].$cnt?></u></span></a><?else:?>
	<a href="<?=$m['link']?>"><?=$m['name'].$cnt?></a><?endif;?>
	<?if($end['id']!=$m['id']){?>&nbsp;<font color="#6172BA">|</font>&nbsp;<?}?>
<?endforeach;?>
</div>
<?endif;?>