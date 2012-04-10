<?if(!empty($geo)) $this->load->view('block/filter',array('geo'=>$geo));?>
<?if(!empty($comunity)):?>
<table  width="100%"><tr>
<td align="right" nowrap><a>Написать письмо</a>&nbsp;&nbsp;&nbsp;<a>Пригласить в чат</a></td>
</tr></table>
<form method="POST">
<div style="text-align:left; margin-bottom:10px">
<?$i=1;foreach ($comunity as $mem):?>
<?//$mem = $mem['user'];?>
<?if($i%2==0){
	$bgcolor="#fff";}else{
	$bgcolor="#E8EAF3";}?>
<?//if($i%2!=0)$bgcolor="#ddd";else $bgcolor="#fff";?>
<?//print_r($mem)?>
<div class="messages" style="float:left;width:100%; padding:5px 0; background-color:<?=$bgcolor?>; border-bottom:2px #dde solid">

<table cellpadding="0" cellspacing="0"><tr>
<td rowspan="2"><div class="avatar"><a href="/members/<?=$mem->id?>"><?if(!empty($mem->avatar)){?><img src="/image/<?=$mem->avatar?>.jpg" class="avatar"></img><?}else{?><img src="/img/default.png" class="default_avatar"></img><?}?></a></div></td>
<td width="100%" valign="top" align="left" colspan="2" height="15">
<?$this->load->view('block/rating',array('rating'=>$mem->rating))?>
<div class="nickname"><a href="/members/<?=$mem->id?>"><?=$mem->nickname?></a></div>
<div style="clear:both"></div>
<div style="float:left"><?=date("H:m d.m.Y",strtotime($mem->ad))?></div>

 </td>
<td rowspan="2" nowrap style="padding:0 10px;padding-top:0px; text-align:right; vertical-align:middle">
<?if(isset($this->data['Online'][$mem->id])){?><span style="margin-right:5px">Cейчас на сайте</span><?}?>
<span class="art"><input type="checkbox" name="mem[<?=$mem->id?>]" value="<?=$mem->id?>"></span>
</td>
 </tr><tr><td valign="top" align="left" width="100%">
<div style="clear:both"></div>
<div>Рейтинг сети: <?=$mem->amount/*net_rating*/?><?/*(<?=$mem->receipts?>)*/?>, в сети <?=$mem->cnt_net?> <?switch (($mem->cnt_net)%10){case 1:?>участник<?;break; case 2:case 3:case 4:?>участника<?;break; default:?>участников<?}?></div>
<div class="geo">г. <?=$mem->town?>, <?=$mem->region?>, <?=$mem->country?> </div>
<div>

</div>
</td>
</tr>


</table>
</div>
<?$i++;endforeach;?>
<form>
<?$this->load->view($this->data['tplpapka'].'/pagination.tpl', $this->data);?>
<?else:?>
Нет участников.
<?endif;?>