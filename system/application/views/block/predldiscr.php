<div class="mainopisblock" id="mainopisblock<?=$id?>">
<!--<h3><?=$title?></h3>-->
<table ><tr>
<td rowspan="2">
<a href="/members/<?=$user?>">
<?if(!empty($avatar)){?><img class="avatar" src="/image/<?=$avatar?>.jpg"></img><?}else{?><img class="default_avatar" src="/img/default.png"></img><?}?>
</a>
</td>
<td valign="top">
<a href="/members/<?=$user?>"><?=$nickname?></a><br>
<?$this->load->view('block/ratinga',array('rating'=>$urating))?>
</td>
</tr><tr>
<td><a href="/catalog/hispredl/<?=$user?>">Все мои предложения</a></td>
</tr>
</tr></table>
<?=$this->fields['status_name']?>:	<span style="color: #FF921E;"><?=$status_name?></span><br>
<?=$this->fields['country']?>:		<?=$country?><br>
<?=$this->fields['region']?>:		<?=$region?><br>
<?=$this->fields['town']?>:			<?=$town?><br>
<?=$this->fields['razdel']?>:		<a href="/catalog/<?=$razdel?>"><?=$razdel_title?></a><br>
<?=$this->fields['tegs']?>:			<?$this->load->view('block/tegs')?><br>
<br>
<a <a href="/ppage/my_bussines/one_predl/<?=$id?>">Отзывы (<?=$numcatcomments?>)</a>
<span style="float:right"><a href="/ppage/my_bussines/one_predl/<?=$id?>">Подробнее</a></span>
<?//=$desc?>
</div>
<div class="curent"><?if(!empty($image)){?><img src="/image/<?=$image?>.jpg"></img><?}?></div>
<div class="panel">
	<div style="font-size:20px;padding:5px 0"><b><?=$cost?></b> <i>info</i> <?if(!empty($price_cash)&&$price_cash>0){?>+ <b><?=$price_cash?></b> <i><?=$valuta_name?></i><?}?></div>

	<span style="float:right; color:#999">

		<div class="discr" align=top onclick="$('#mainopisblock<?=$id?>').toggle('narmal');$(this).toggleClass('discl'); return false;">
				<a href="/ppage/my_bussines/one_predl/<?=$id?>" class="mainopis" title="<?=$this->fields['desc']?>" ><?=$this->fields['desc']?></a>
		</div>
	</span>
	<span style="font-size:14px;"><b><a class="nostyle" href="/ppage/my_bussines/one_predl/<?=$id?>"><?=$title?></a></b></span>
</div>