
<form method="POST">
<div style="text-align:left; margin-bottom:10px">
<?$new=0;foreach ($messages as $item)if(!$item->new)$new++;?>
Сообщения: <a href="/ppage/talk/messages/onlinew">новые <?=$cnt->new?></a> | <a href="/ppage/talk/messages">всего <?//=count($messages)?><?=$cnt->all?></a>
<span style="float:right"><button class="blink" type="submit" name="del" value="del"><span>удалить</span></button></span>
</div>
<?if(!empty($messages)):?>
<?$i=1;foreach ($messages as $mes):?>
<?if($mes->new){
	$bgcolor="#fff";}else{
	$bgcolor="#E8EAF3";}?>
<?//if($i%2!=0)$bgcolor="#ddd";else $bgcolor="#fff";?>
<?//print_r($mes)?>
<div class="messages" style="float:left;width:100%; padding:5px 0; background-color:<?=$bgcolor?>; border-top:2px #dde solid">

<table cellpadding="0" cellspacing="0"><tr>
<td rowspan="2"><div class="avatar"><a href="/members/<?=$mes->u_id?>"><?if(!empty($mes->avatar)){?><img src="/image/<?=$mes->avatar?>.jpg" class="avatar"></img><?}else{?><img src="/img/default.png" class="default_avatar"></img><?}?></a></div></td>
<td width="100%" valign="top" align="left" colspan="2" height="15">
<?$this->load->view('block/rating',array('rating'=>$mes->urating))?>
<div style="float:right"><?=date("H:m d.m.Y",strtotime($mes->ad))?></div>
<?if($mes->user_to == $user->id){?>
<div class="nickname"><a href="/members/<?=$mes->u_id?>"><?=$mes->nickname?></a> | <?=$user->nickname?></div>
<?}elseif($mes->user_from == $user->id){?>
<div class="nickname"><?=$user->nickname?> | <a href="/members/<?=$mes->u_id?>"><?=$mes->nickname?></a></div>
<?}?>
 </td></tr><tr><td valign="top" align="left" width="100%">
<div style="clear:both"></div>
<div class="theme"><a href="/ppage/talk/messages/<?=$mes->id?>"><?=$mes->theme?></a></div>
<div class="message"><?=str_replace(array("\n", '  '),array("<br>\n", '&nbsp;'), $mes->message)?></div>
<div>

</div>
</td>
<td nowrap style="padding:0 10px;padding-top:10px; text-align:right">
<div style="height:60px;float:left"><?if(isset($this->data['Online'][$mes->u_id])){?><span style="margin-top:28px;float:left">Сейчас на сайте</span><?}?></div>
<div style="clear:both"></div>
<a href="/ppage/talk/messages/newmess/<?=$mes->u_id?>">ответить</a>
</td><td style="vertical-align:middle">
<span class="art"><input type="checkbox" name="del[<?=$mes->id?>]" value="<?=$mes->id?>"></span>
</td>
</tr>


</table>
</div>
<?$i++;endforeach;?>
<form>
<?else:?>
Нет сообщений
<?endif;?>