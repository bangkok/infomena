<?if(!empty($myNetwork['child'])):?>
<?/*$L1=$L2=0; foreach($myNetwork['child'] as $val){$L1++;if(!empty($val['child'])) foreach($val['child'] as $val)$L2++;}*/?>
<table  width="100%"><tr>
<td align="left" nowrap><span class="gr">Моя сеть:</span> Я + <?=$myNetwork['user']->cnt_net?> 
<?switch ($myNetwork['user']->cnt_net % 10){case 1:?>участник<?;break; case 2:case 3:case 4:?>участника<?;break; default:?>участников<?}?>
, из них <?=count($myNetwork['child'])?> в <a>1 линии</a></td>
<td align="right" nowrap><a>Написать письмо</a>&nbsp;&nbsp;&nbsp;<a>Пригласить в чат</a></td>
</tr></table>
<form method="POST"><?//print_r($myNetwork)?>
<div style="text-align:left; margin-bottom:10px">
<?$i=1;foreach ($myNetwork['child'] as $mem):?>
<?	block($this, $mem, $i, 0)?>
<?if(!empty($mem['child'])) foreach ($mem['child'] as $item):$i++;?>
<?	block($this, $item, $i, 1)?>
<?endforeach;?>
<?$i++;endforeach;?>
<form>
<?else:?>
В вашей сети еще никого нет
<?endif;?>

<?
function block($CI, $member, $i, $level=0){
$mem = $member['user'];

	
if($i%2==0){
	$bgcolor="#fff";}else{
	$bgcolor="#E8EAF3";}?>
<?//if($i%2!=0)$bgcolor="#ddd";else $bgcolor="#fff";?>
<?//print_r($mem)?>
<div class="messages" style="float:left;width:100%; padding:5px 0; background-color:<?=$bgcolor?>;  border-bottom:2px #dde solid">

<table cellpadding="0" cellspacing="0" style="margin-left:<?=$level*70?>px;"><tr>
<td rowspan="2"><div class="avatar"><a href="/members/<?=$mem->id?>"><?if(!empty($mem->avatar)){?><img src="/image/<?=$mem->avatar?>.jpg" class="avatar"></img><?}else{?><img src="/img/default.png" class="default_avatar"></img><?}?></a></div></td>
<td width="100%" valign="top" align="left" colspan="2" height="15">
<?$CI->load->view('block/rating',array('rating'=>$mem->rating))?>
<div class="nickname"><a href="/members/<?=$mem->id?>"><?=$mem->nickname?></a></div>
<div style="clear:both"></div>
<div style="float:left; padding-top:5px"><?=date("H:m d.m.Y",strtotime($mem->ad))?></div>
</td>
<td rowspan="2" nowrap style="padding:0 10px;padding-top:0px; text-align:right; vertical-align:middle">
<?if(isset($CI->data['Online'][$mem->id])){?><span style="margin-right:5px">Cейчас на сайте</span><?}?>
<span class="art"><input type="checkbox" name="mem[<?=$mem->id?>]" value="<?=$mem->id?>"></span>
</td>
 </tr><tr><td valign="top" align="left" width="100%">
<div style="clear:both"></div>
<div>Рейтинг сети: <?=$mem->amount/*net_rating*/?>, в сети <?=$mem->cnt_net?> <?switch (($mem->cnt_net)%10){case 1:?>участник<?;break; case 2:case 3:case 4:?>участника<?;break; default:?>участников<?}?></div>
<div class="geo">г. <?=$mem->town?>, <?=$mem->region?>, <?=$mem->country?> </div>
<div>

</div>
</td>
</tr>


</table>
</div>
	
<?	
}
?>