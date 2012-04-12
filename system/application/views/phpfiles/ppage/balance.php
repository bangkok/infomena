<style type="text/css">
table.balance td{padding:10px}
</style>

<table width="100%" cellpadding="0" cellspacing="0" class="balance">
<tr>
<td class="gr">Дата</td>
<td>Тип операции</td>
<td>Назначение</td>
<td>Контрагент</td>
<td>Доход</td>
<td>Расход</td>
</tr>

<?$color=array("#c9d687","#ffbe7e")?>
<?$types = array(
	'reg'		=> 'Регистрация',
	'addfriend'	=> 'Приглашение',
	'spros5'	=> 'Спрос',
	'predl5'	=> 'Предложение',
	'order'		=> array('Покупка', 'Продажа')
)?>
<?$i=0;$sum=0;
foreach ($Orders as $order):?>
<tr <?if($i%2==0):?> bgcolor="<?=$color[($i/2)%2]?>" <?endif;?>>
<td><?=$order->date?></td>
<td><?= !empty($types[$order->type])
		? (is_array($types[$order->type])
				? $types[$order->type][(int)$order->income > 0]
				: $types[$order->type])
		: $order->type
	?>
</td>
<td><? if(!empty($order->title)){?><a class="nostyle hoverline" href="/ppage/myfinances/make_order/35"><?=$order->title?></a> <?}?></td>
<td><?if($this->purses_model->getval('FondId') != $order->user_id){?>
	<a class="nostyle hoverline" href="/members/<?=$order->user_id?>"><?=$order->nickname?></a>
	<?}else{?><?=$order->nickname?><?}?>
</td>
<td><?if($order->income > 0){?><?=$order->income?><?}else{?>0<?}?></td>
<td><?if($order->income < 0){?><?=abs($order->income)?><?}else{?>0<?}?></td>
</tr>
<?$i++;
$sum += $order->income;
endforeach;?>

<tr><td colspan="4" align="right">Итого:</td><td><b><?=$sum?></b></td><td></td></tr>
</table>
