<?if(isset($Urgently) && !empty($Urgently)):?>
<style type="text/css">
/*.urgently {text-align:left;width:100%}*/
.urgently table {text-align:left;width:100%;}
/*.urgently table div{border:1px #000 solid}*/
.urgently .image{margin:5px 10px}
.urgently .title{font-size:14px; font-weight:bold; padding-left:5px}
.urgently .desc, .urgently .keywords {padding-left:5px}
</style>
<div style="width:100%">
<?$i=0;foreach($Urgently as $u):?>
<?if($i%2!=0)$bgcolor="#ddd";else $bgcolor="#fff";?>
<div style="float:left;width:100%; padding:5px 0; background-color:<?=$bgcolor?>;">

<table cellpadding="0" cellspacing="0"><tr>
<td rowspan="2" class="td-avatar"><div class="avatar"><a href="/members/<?=$u->user?>">
<?if(!empty($u->avatar)){?><img src="/image/<?=$u->avatar?>.jpg" /><?}else{?><img class="default_avatar" src="/img/default.png" /><?}?>
</a></div></td>
<td valign="top">
<?$this->load->view('block/rating',array('rating'=>$u->urating))?>
<div class="nickname"><a href="/members/<?=$u->user?>"><?=$u->nickname?></a></div>
<div style="clear:both"></div>
<div class="title"><?=$u->title?></div>
<div class="desc"><?=$u->desc?></div>
<div>

</div>
</td>
<td nowrap style="padding-right:10px;padding-top:10px; text-align:right">
<a href="/ppage/my_bussines/one_spros/<?=$u->id?>">Подробнее</a>
</td>
</tr>

<tr>
<td>
	<div class="keywords"><span style="float:left">Рубрика: <a href="/catalog/<?=$u->razdel?>"><?=$u->razdel_title?></a></span><span style="float:left;margin-left:10px">Ключевые слова: <?$this->load->view('block/tegs',$u)?></span></div>
</td>
<td nowrap style="padding-right:10px;text-align:right"><a href="/catalog/hisspros/<?=$u->user?>">Весь мой спрос</a></td>
</tr>
</table>
<?//print_r($u);?>
</div>
<?$i++;endforeach;?>
</div>
<div style="clear:both"></div>
<div class="pager">
<table><tr><td style="color:#999;padding-left:10px">
<?=$this->data['Pager']['s']->nums?>
</td><td align="right">
<?=$this->data['Pager']['s']->links?>
</td></tr>
</table>
</div>
<?endif;?>

