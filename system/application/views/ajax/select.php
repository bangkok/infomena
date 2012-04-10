<?if(isset($CUR['child']) && !empty($CUR['child'])):?>
	<div style="float:left; margin:0 0 5px 5px;">
		<select name="filter[types][<?=$CUR['id']?>]" size = 1 >
			<option onclick="select(<?=$CUR['id']?>, 'all')" value=0>Все</option>
	<?foreach ($CUR['child'] as $item):?>
			<option <?if(!empty($item['child'])):?>onclick="select(<?=$item['upId']?>, <?=$item['id']?>)"<?endif;?> value=<?=$item['id']?>><?=$item['name']?>(<?=$item['products_count']?>)</option>
	<?endforeach;?>
		</select>
	</div>
	<div style="float:left" id="select_<?=$CUR['id']?>"></div>
<?endif;?>