<?if(!empty($MSG)){?><?=$MSG?><?}?>
<?if(empty($Order))return false;?>
<table cellspacing="0" cellpadding="0" border="0" class="myprofile">
<tr>
	<td valign="top">
<!--LEFT TOP-->
<div style="text-align:left">
<p></p>
<?if(!empty($Order) && !$Order->confirmed):?>
Оплатить <b>Счет № <?=$Order->id?> от <?=$Order->date?></b>
<?else:?>
<b>Счет № <?=$Order->id?> от <?=$Order->date?></b> Оплачен
<?endif;?>
<div style="height: 20px"></div>
<form  id="check" name="check" method="POST">
<input type="hidden" name="checkid" value="<?=$Order->id?>">
<table>
<!--<tr><td>Плательщик:</td><td><input type="text" name="name" value="<?=$User->name?>" onkeyup="/*checkusernickname(this.value)*/"> <span id="checknickname"></span></td></tr>-->
<tr><td>Назначение:</td><td><div id="asgmt"><input type="text" size="50" name="asgmt" value="<?if (!empty($Cat->title)){?><?=$Cat->title?><?}?>"></div></td></tr>
<tr><td>Примечания</td><td><textarea name="desc" cols="35"><?=$Order->desc?></textarea></td></tr>
<!--

</table>

<table>
-->
<!--
<tr><td>Стоимость:</td><td><input disabled id="info" type="text" name="info" value="<?=$Order->info?>"> info + </td>
-->
<tr><td>К оплате:</td><td><table><tr><td><input disabled id="cost" type="text" name="cost" value="<?=$Order->info + $Order->comis?>"> info</td>
<td><input disabled id="cash" type="text" name="cash" value="<?=$Order->cash?>" size="5">
	<select id="valuta" name="valuta" style="width:60px; border:0" disabled >
		<?foreach ($Valuta as $v):?><option class="n" curs="<?=$v->koef?>" value="<?=$v->id?>" <?if(empty($Order->valuta)):?><?=$this->validation->set_select('valuta',$v->id)?><?elseif($Order->valuta==$v->id):?>selected<?endif;?>><?=$v->name?></option><?endforeach;?>
	</select>
</td></tr></table></td></tr>
<!--
<tr><td>Комиссия сервиса 5%:</td><td><input disabled id="comis" type="text" name="comis" value="<?=$Order->comis?>"> info</td><td></td></tr>
<tr><td>К оплате:</td><td><input disabled id="cost" type="text" name="cost" value="<?=$Order->info + $Order->comis?>"> info</td><td><a href="#" onclick="convinfo();return false;" style="float:right">Конвертор info</a></td></tr>
-->
</table>
<?if(!empty($Order) && !$Order->confirmed ):?>
<table width="100%">
<tr><td></td><td>
<?//echo "Cat->info $User->info <br> Order->info $Order->info <br> Order->comis $Order->comis"?>
<?if($User->info >= ($Order->info + $Order->comis)){?>
<input type="submit" value="Оплатить счет" style="float:right" class="button">
<?}else{?>
<span style="float:right">средств не достаточно</span>
<?}?>
</td></tr>
</table>
<?endif;?>
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
Входящий <a <?=$style?> href="/ppage/myfinances/pay_order/<?=$order->id?>">№<?=$order->id/*inum*/?>" от <?=$order->date?></a> <br>
<?//print_r($order)?>
<?endforeach;?>		
<!--END RIGHT TOP-->
	</td>
</tr>
</table>