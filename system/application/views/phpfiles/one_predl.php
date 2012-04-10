<?if(isset($this->data['authed']) && !empty($catalog)):?>
<div>
<table cellspacing="0" cellpadding="0" border="0" class="myprofile">
<tr>

	<td>
<!--LEFT TOP-->
		<table cellspacing="0" cellpadding="0">
		<tr><td>
			<table cellspacing="0" cellpadding="0"><tr>
					<td align="left"><img class="avatar" src=<?if($user->avatar):?>"/image/<?=$user->avatar?>.jpg/<?=rand();?>"<?else:?>"/img/default.png"<?endif;?>></img></td>
					<td width="100%" style="padding-left:10px; vertical-align:middle;">
					
					<table  cellspacing="0" cellpadding="0">
					
					<tr><td colspan="2">
						<table cellspacing="0" cellpadding="0"><tr>
						<td width="100%" align="left">
						<?$this->load->view('block/rating',array('rating'=>$user->rating))?>
						<div><a href="/members/<?=$user->id?>"><?=$user->name?></a></div></td>
						</tr></table>
					</td></tr>	
						
					<tr><td style="padding-top:10px;">
				г. <?=$geo['towns'][$user->region][$user->town]->title?>,
				<?=$geo['regions'][$user->country][$user->region]->title?>, 
				<?=$geo['countrys'][$user->country]->title?></td></tr>

					<tr><td><?=date('Y')-date('Y',strtotime($user->birthdate));?> лет</td></tr>
					<tr><td><?=$fields['inservicewith']?>: <?=date('d.m.Y',strtotime($user->ad))?></td></tr>
					<tr><td><span>Рейтинг сети: </span><?=$user->amount?></td></tr>
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
			<td align="left">Мои контакты</td>
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

<tr>
	<td  colspan="3"style="padding-top:10px">
		<a href="/members/<?=$user->id?>">Отзывы</a> (<?=$CntUserComments?>)
	</td>

</tr>
</table>
</div>
<?endif;?>

<?if(!empty($catalog)){ foreach ($catalog as $c):?>
<div class="pereg_horiz"></div>
<div class="predl">
<?//print_r($c)?>
			<table cellspacing="0" cellpadding="0" class="myprofile"><tr>
			<td width="220">
				<table cellspacing="0" cellpadding="0">
				<tr><td colspan="2"><span style="color:#ff921e;float:left"><i><b><?=$c->status_name?></b></i></span></td></tr>
				<tr><td  colspan="2"><span style="float:left">
				<b><?=$c->cost?></b> <i>info</i> <?if(!empty($c->price_cash)){?>&nbsp;<b><?=$c->price_cash?></b> <?=$Valuta[$c->valuta]->name?><?}?></span></td></tr>
				<tr><td colspan="2"><div class="image"><?if(!empty($c->prevue)){?><img class="image" src="/image/<?=$c->prevue?>.jpg"><?}?></div></td></tr>
				<tr><td>Опубликовано:<br> Активно до: </td><td><b><?=$c->ad?></b> <br> <b><?=$c->breack_date?></b></td></tr>
				</table>
			</td>
			<td>
				<table cellspacing="0" cellpadding="0" width="100%">
				<tr><td>
					<table cellspacing="0" cellpadding="0"><tr>
						<td nowrap width="100%"><div><a href="/members/<?=$user->id?>"><?=$user->name?></a></div></td>
						<td nowrap class="gr"><?//=$pager->nums?></td>
						<td nowrap><?//=$pager->links?></td>
					</tr></table>
				</td></tr>
				<tr><td height="100%"><div class="title"><?=$c->title?></div><div class="text"><?=$c->desc?></div></td></tr>
				<tr><td>
					<table cellspacing="0" cellpadding="0" width="100%"><tr>
						<td nowrap >Рубрика: <a href="/catalog/<?=$c->razdel?>"><?=$c->razdel_title?></a><br>Ключевые слова: <?$this->load->view('block/tegs',$c)?></td>
						<td nowrap align="right"><a href="#">Порекомендовать другу</a> <br> <a href="/ppage/my_bussines/notebook/add/<?=$c->id?>">Записать в блокнот</a></td>
					</tr></table>					
				</td></tr>
				</table>			
			</td>
			</tr></table>
<table width="100%">
<tr><td style="padding:5px"><span style="float:left"><a href="#">Отзывы</a> (<?=$CntCatComments?>) </span> <span style="float:right"><a href="#" onclick="$('#sendcomment').toggle();return false;">Оставить отзыв</a></span></td></tr>

<tr><td>
<div id="sendcomment" style="display:none">
<div class="pereg_horiz"></div>
<form method="POST"><textarea name="message" rows="1"></textarea><br><input class="button" type="submit" name="send" value="Отправить"></input>
<input type="hidden" value="<?=$c->id?>" name="pos"></form></div>
</td></tr>

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
<?endforeach;}?>

