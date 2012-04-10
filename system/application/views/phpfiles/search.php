<style type="text/css">
.main .block .content{margin:5px 2px}
</style>
<?if(!empty($geo)) $this->load->view('block/search',array('geo'=>$geo));?>
<?if(!empty($catalog)){$i=0; foreach ($catalog as $c):?>
<div class="predl"<?if($i%2==0){?>style="background-color:#e8eaf3"<?}?>>
<?//print_r($c)?>
			<table cellspacing="0" cellpadding="0" class="myprofile"><tr>
			<td width="220" valign="top">
				<table cellspacing="0" cellpadding="0">
				<tr><td colspan="2" align="left"><span style="color:#ff921e;"><i><b><?=$c->status_name?></b></i></span></td></tr>
				
				<tr><td colspan="2"><div class="image"><?if(!empty($c->prevue)){?><img class="image" src="/image/<?=$c->prevue?>.jpg"><?}?></div></td></tr>
				<tr><td  colspan="2" align="center"><span><?if($c->type == 'spros'){?>≈<?}?>
				<b><?=$c->cost?></b> <i>info</i> <?if(!empty($c->price_cash)&&$c->price_cash>0){?> + <b><?=$c->price_cash?></b> <?=$c->valuta_name?><?}?></span></td></tr>
				</table>
			</td>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" width="100%">

				<tr><td height="100%">
					<table cellspacing="0" cellpadding="0"><tr>
						<td width="100%">
						<?$this->load->view('block/rating',array('rating'=>$c->urating))?>
						<div class="username"><a href="/members/<?=$c->user?>"><?=$c->nickname?></a>
					</td><td nowrap align="right"><a><?if($c->type == 'predl'){?>Все мои предложения<?}elseif($c->type == 'spros'){?>Весь мой спрос<?}?></a></td>
					</tr></table>
					</td></tr>
					<tr><td height="100%"><div class="title"><?=$c->title?></div><div class="text"><?=$c->desc?></div></td></tr>
				<tr><td>
					<table cellspacing="0" cellpadding="0" width="100%"><tr>
						<td nowrap >Рубрика: <a href="/catalog/<?=$c->razdel?>"><?=$c->razdel_title?></a>&nbsp;&nbsp;&nbsp;Ключевые слова: <?$this->load->view('block/tegs',$c)?>
						</td>
						<td nowrap align="right" valign="bottom"><a href="/ppage/my_bussines/<?if($c->type=='spros'){?>one_spros<?}else{?>one_predl<?}?>/<?=$c->id?>">Подробнее</a></td>
					</tr></table>					
				</td></tr>
				</table>			
			</td>
			</tr></table>

</div>
<?$i++;endforeach;?>
<table cellspacing="0" cellpadding="0" class="myprofile" style="margin-top:10px"><tr>
						<td nowrap class="gr"><?=@$pager->nums?></td>
						
						<td nowrap align="right"><?=@$pager->links?></td>
</tr></table>

<?}else{?>
Ничего не найдено
<?}?>