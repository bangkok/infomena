


<table cellspacing="0" cellpadding="0" border="0" class="myprofile">
<tr>
	<td valign="top">
<!--LEFT TOP-->
<div style="text-align:left">
<p></p>
<?if(!empty($Order)):?>
<b>Счет № <?=$Order->id?> от <?=$Order->date?></b> <?if($Order->confirmed){?>Оплачен<?}else{?>Не оплачен<?}?>
<?else:?>
Выписать счет: <b>Счет от <?=date("d.m.Y")?></b>
<?endif;?>
<div style="height: 20px"></div>
<form  id="check" name="check" method="POST" >
<table>
<tr><td>Плательщик:</td><td><input type="text" name="name" size="50" value="<?if(isset($Cat->nickname)){?><?=$Cat->nickname?><?}?>" onkeyup="checkusernickname(this.value)"> <span id="checknickname"></span></td></tr>
<tr><td>Назначение:</td><td>
	<div id="asgmt">
		<input type="text" size="50" name="asgmt" value="<?if(isset($Cat->title)){?><?=$Cat->title?><?}?>">
		<?if(isset($Cat->title)){?><a href="/ppage/my_bussines/one_<?=$Cat->type?>/<?=$Cat->id?>">подробнее</a><?}?>
	</div>
</td></tr>
<tr><td>Примечания</td><td><textarea name="desc" cols="35"><?if(isset($Order->desc)){?><?=$Order->desc?><?}?></textarea></td></tr>
</table>

<table>
<tr><td>Стоимость:</td><td><input id="info" type="text" name="info" value="<?if(isset($Order->info)){?><?=$Order->info?><?}?>" onkeyup="ordercomis(0,0);"> info + </td>
<td><input id="cash" type="text" name="cash" value="<?if(isset($Order->cash)){?><?=$Order->cash?><?}?>" size="5" onkeyup="ordercomis(0,0);">

	<select id="valuta" name="valuta" style="width:60px; border:0" onchange="ordercomis(0,0);">
		<?foreach ($Valuta as $v):?><option class="n" curs="<?=$v->koef?>" value="<?=$v->id?>" <?if(empty($Order->valuta)):?><?=$this->validation->set_select('valuta',$v->id)?><?elseif($Order->valuta==$v->id):?>selected<?endif;?>><?=$v->name?></option><?endforeach;?>
	</select>

</td></tr>
<tr><td>Комиссия сервиса 5%:</td><td><input disabled id="comis" type="text" name="comis" value="<?if(isset($Order->comis)){?><?=$Order->comis?><?}?>"> info</td><td></td></tr>
<tr><td>К оплате:</td><td><input disabled id="cost" type="text" name="cost" value="<?if(isset($Order->comis)){?><?=$Order->info + $Order->comis?><?}?>"> info</td><td><a href="#" onclick="convinfo();return false;" style="float:right">Конвертор info</a></td></tr>
</table>
<table width="100%">

<?if(empty($Order)):?>
<tr><td><input type="reset" value="Очистить" class="blink"></td><td><input type="submit" value="Отправить счет" style="float:right" class="button"></td></tr>
<?else:?>
<tr><td colspan="2" align="right"><a href="/ppage/myfinances/make_order">Выписать новый счет</a></td></tr>
<?endif;?>

</table>
</form>
</div>		
<!--END LEFT TOP-->
	</td>
	<td width="10" class="pereg_vert"></td>
	<td valign="top">
<!--RIGHT TOP-->
<div>Архив счетов:<br><br></div>
<?if(!empty($Orders))foreach ($Orders as $order):?>
<?if($order->confirmed) $style='style="color:#777"'; else $style='';?>
Исходящий <a <?=$style?> href="/ppage/myfinances/make_order/<?=$order->id?>">№<?=$order->id/*inum*/?> от <?=$order->date?></a> <br>
<?//print_r($order)?>
<?endforeach;?>		
<!--END RIGHT TOP-->
	</td>
</tr>
</table>