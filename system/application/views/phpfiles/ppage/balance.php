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
<?//for ($i=0;$i<7;$i++):?>
<?$types = array('spros'=>'Спрос', 'predl'=>'Предложение')?>
<?$i=0;$sum=0;
foreach ($Orders as $order):?>
<tr <?if($i%2==0):?> bgcolor="<?=$color[($i/2)%2]?>" <?endif;?>>
<td><?=$order->date?></td>
<td><?if($order->income > 0){?>Продажа<?}else{?>Покупка<?}?></td>
<td><?=$order->title?></td>
<td><?=$order->nickname?></td>
<td><?if($order->income > 0){?><?=$order->income?><?}else{?>0<?}?></td>
<td><?if($order->income < 0){?><?=abs($order->income)?><?}else{?>0<?}?></td>
</tr>
<?$i++;
$sum += $order->income;
endforeach;?>
<?//endfor;?>



<tr><td colspan="4" align="right">Итого:</td><td><b><?=$sum?></b></td><td></td></tr>
</table>
