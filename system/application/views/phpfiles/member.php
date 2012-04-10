<?if(isset($this->data['authed'])):?>
<div>
<table cellspacing="0" cellpadding="0" border="0" class="myprofile">
<tr>

	<td>
<!--LEFT TOP-->
		<table cellspacing="0" cellpadding="0">
		<tr><td>
			<table cellspacing="0" cellpadding="0"><tr>
					<td align="left" valign="top"><?if($user->avatar):?><img class="avatar" src="/image/<?=$user->avatar?>.jpg/<?=rand();?>"></img><?else:?>
					<img class="default_avatar" src="/img/default.png"></img><?endif;?></td>
					<td width="100%" style="padding-left:10px; vertical-align:middle;">
					
					<table  cellspacing="0" cellpadding="0">
					
					<tr><td colspan="2">
						<table cellspacing="0" cellpadding="0"><tr>
						<td width="100%" align="left" >
						<?$this->load->view('block/rating',array('rating'=>$user->rating))?>
						<div><?=$user->nickname?></div></td>
						</tr></table>
					</td></tr>	
						
					<tr><td style="padding-top:10px;">
				г. <?=$geo['towns'][$user->region][$user->town]->title?>,
				<?=$geo['regions'][$user->country][$user->region]->title?>, 
				<?=$geo['countrys'][$user->country]->title?></td></tr>
<?
$y1= date('Y',strtotime($user->birthdate));
$m1= date('m',strtotime($user->birthdate));
$d1= date('d',strtotime($user->birthdate));
$y2= date('Y');
$m2= date('m');
$d2= date('d');
//$d= max(($d1-$d2)/abs($d1-$d2),0);
//@$m= max(($m1-$m2+$d)/abs($m1-$m2+$d),0);
$d= ($d1-$d2)>0 ? 1 : 0;
$m= ($m1-$m2+$d)>0 ? 1 : 0;
?>	
					<tr><td><?=$y2-$y1-$m?> лет</td></tr>
					<tr><td><?=$fields['inservicewith']?>: <?=date('d.m.Y',strtotime($user->ad))?></td></tr>
					<tr><td><span>Рейтинг сети: </span><?=$user->amount/*rating*/?></td></tr>
					<tr><td style="color:#ff921e"><?if($user->status && $user->status != -1):?><?=$status[$user->status]->name?><?else:?><?=$user->status_self?><?endif;?></td></tr>
					<tr><td style="color:green"><?=$user->deviz?></td></tr>
					</table>
				<td></tr>
			</table>
		</td></tr>
		</table>
<!--END LEFT TOP-->
	</td>
	<td class="pereg_vert" width="10"></td>
	<td>
<!--RIGHT TOP-->
		<table>
		<tr>
			<td align="left"><b>Мои контакты</b></td>
		</tr>
		<tr>
			<td>
			<table cellspacing="0" cellpadding="0" align="left">
				<tr><td class="gr"><?=$fields['email']?>:</td><td width="100%"><?=$user->email?></td></tr>
				<tr><td class="gr"><?=$fields['tel']?>:</td><td width="100%"><?=$user->tel?></td></tr>
				<tr><td class="gr"><?=$fields['mtel']?>:</td><td><?=$user->mtel?></td></tr>
				<tr><td class="gr"><?=$fields['icq']?>:</td><td><?=$user->icq?></td></tr>
				<tr><td class="gr"><?=$fields['skype']?>:</td><td><?=$user->skype?></td></tr>
				<tr><td class="gr"><?=$fields['url']?>:</td><td><a href="http://<?=str_ireplace("http://",'',$user->url)?>" target="_blank"><?=$user->url?></a></td></tr>
			</table>
			</td>
		</tr>
		</table>
<!--END RIGHT TOP-->
	</td>
</tr>
<?if(!empty($user->detailed_info)):?>
<tr><td colspan="3">
<div style="margin-top:10px"><b>Обо мне</b></div>
<div class="pereg_horiz"></div>
<div><?=$user->detailed_info?></div>
</td></tr>
<?endif;?>

</table>
<?endif;?>
<table width="100%">
<tr><td style="padding:5px"><span style="float:left"><a href="#">Отзывы</a> (<?=$CntUserComments?>) </span> <span style="float:right"><a href="#" onclick="$('#sendcomment').toggle();return false;">Оставить отзыв</a></span></td></tr>
<tr><td>
<div id="sendcomment" style="display:none">
<div class="pereg_horiz"></div>
<form method="POST">
<textarea name="message" rows="1"></textarea><br><input class="button" type="submit" name="send" value="Отправить"></input>
<input type="hidden" value="<?=$user->id?>" name="user">
</form></div></td></tr>
<?if(!empty($Comments)):?><tr><td>
<div class="pereg_horiz"></div>
<div class="comments">
<?$i=1;foreach ($Comments as $comment):?>
<?if($i%2!=0)$bgcolor="#EEEEF5";else $bgcolor="#fff";?>
<div class="comment" style="padding:5px;background-color:<?=$bgcolor?>;">
<table cellpadding="0" cellspacing="0"><tr>
<td rowspan="2" style="padding-right:5px">
	<div class="avatar"><a href="/members/<?=$comment->u_id?>"><?if(!empty($comment->avatar)){?><img src="/image/<?=$comment->avatar?>.jpg" class="avatar"></img><?}else{?><img src="/img/default.png" class="default_avatar"></img><?}?></a></div>
</td>
<td width="100%" valign="top" align="left"  height="15">
<?$this->load->view('block/rating',array('rating'=>$comment->urating))?>
<div class="nickname"><a href="/members/<?=$comment->u_id?>"><?=$comment->nickname?></a></div>
<div style="clear:both;"></div>
<div><?=date("H:m d.m.Y",strtotime($comment->ad))?></div>
</td></tr>
<tr><td valign="top" align="left" style="padding-top:5px">
<div class="message"><?=$comment->message?></div>
</td></tr>
</table>
</div>
<?$i++;endforeach;?>
</div>
</td></tr><?endif;?>
</table>

</div>
