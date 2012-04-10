<?if(isset($Users) && !empty($Users)):?>
<style type="text/css">
/*.urgently {text-align:left;width:100%}*/
.urgently table {text-align:left;width:100%;}
/*.urgently table div{border:1px #000 solid}*/
.urgently .image{margin:5px 10px}
.urgently .title{font-size:14px; font-weight:bold;}
</style>
<div style="width:100%">
<?$i=0;foreach($Users as $u):?>
<?if($i%2!=0)$bgcolor="#ddd";else $bgcolor="#fff";?>
<div style="float:left;width:100%; padding:5px 0; background-color:<?=$bgcolor?>;">

<table cellpadding="0" cellspacing="0"><tr>
<td rowspan="2"><div class="avatar"><a href="/members/<?=$u->id?>">
<?if(!empty($u->avatar)){?><img src="/image/<?=$u->avatar?>.jpg"></img><?}else{?><img class="default_avatar" src="/img/default.png"></img><?}?>
</a></div></td>
<td width="100%" valign="top">
<?$this->load->view('block/rating',array('rating'=>$u->rating))?>
<div class="nickname"><a href="/members/<?=$u->id?>"><?=$u->nickname?></a></div>
<div style="clear:both"></div>
<div class="title"><?//=$u->title?></div>
<div class="desc"><?//=$u->desc?></div>
<div style="text-align:left">
Оборот персональнй сети участника: <?=$u->sum1?><br>
Оборот участника: <?=$u->sum?>

</div>
</td>

</tr>


</table>
<?//print_r($u);?>
</div>
<?$i++;endforeach;?>
</div>

<?endif;?>

