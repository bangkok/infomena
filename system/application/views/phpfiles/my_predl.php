<style type="text/css">
.main .block .content{margin:5px 2px}
</style>
<?if(!empty($catalog)){$i=0; foreach ($catalog as $c):?>
<div class="predl"<?if($i%2==0){?>style="background-color:#e8eaf3"<?}?>>
<?//print_r($c)?>
			<table cellspacing="0" cellpadding="0" class="myprofile"><tr>
			<td width="220" valign="top">
				<table cellspacing="0" cellpadding="0">
				<tr><td colspan="2"><span style="color:#ff921e;float:left"><i><b><?=$c->status_name?></b></i></span></td></tr>
				<tr><td  colspan="2"><span style="float:left">
				<b><?=$c->cost?></b> <i>info</i> <?if(!empty($c->price_cash)&&$c->price_cash>0){?> + <b><?=$c->price_cash?></b> <?=$c->valuta_name?><?}?></span></td></tr>
				<tr><td colspan="2"><div class="image"><?if(!empty($c->prevue)){?><img class="image" src="/image/<?=$c->prevue?>.jpg"><?}?></div></td></tr>
				<tr><td>Опубликовано:<br> Активно до: </td><td><b><?=$c->ad?></b> <br> <b><?=$c->breack_date?></b></td></tr>
				</table>
			</td>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" width="100%">
				<tr><td>
					<table cellspacing="0" cellpadding="0"><tr>
						<td nowrap align="right"><a href="/ppage/my_bussines/edit/<?=$c->id?>">Редактировать</a></td>
					</tr></table>
				</td></tr>
				<tr><td height="100%"><div class="title"><?=$c->title?></div><div class="text"><?=$c->desc?></div></td></tr>
				<tr><td>
					<table cellspacing="0" cellpadding="0" width="100%"><tr>
						<td nowrap >Рубрика: <a href="/catalog/<?=$c->razdel?>"><?=$c->razdel_title?></a><br>Ключевые слова: <?$this->load->view('block/tegs',$c)?></td>
						<td nowrap align="right" valign="bottom"><a href="/ppage/my_bussines/delite/<?=$c->id?>" onclick="if (confirm('Вы действительно хотите удалить \&quot;<?=$c->title?>\&quot;?')){return true;}else{return false;}">Удалить</a></td>
					</tr></table>					
				</td></tr>
				</table>			
			</td>
			</tr></table>

</div>
<?$i++;endforeach;?>
<table cellspacing="0" cellpadding="0" class="myprofile" style="margin-top:10px"><tr>
						<td nowrap class="gr" width="220"><?=$pager->nums?></td>
						<td nowrap align="left" style="padding:0 10px"><a  href="/ppage/my_bussines/add">Добавить предожение</a></td>
						<td nowrap align="right"><?=$pager->links?></td>
</tr></table>

<?}?>