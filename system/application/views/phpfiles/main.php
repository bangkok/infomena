<style type="text/css">
.curpredl{ width:500px;background:#999; margin:0 auto; margin-top:5px}
.curpredl .curent{ height:250px; text-align:center; overflow: hidden;}
.curpredl{overflow:hidden}
.curpredl .curent img{width:500px;}
.curpredl .panel{height:60px;background:#333;text-align:left; color:#fff;padding:0 10px}
.curpredl .panel img{cursor:pointer}
.nav{height:100px; border:0px #000 solid; overflow: hidden;}
.nav ul li {list-style-type: none;}
.lastpredl{width:115px;height:57px;background:#999; float:left;margin-top:20px; margin-left:13px;cursor:pointer}
.lastpredl img {width:115px;}
div.lastpredl:first-child {margin-left:0px;}
.pager{margin-top:5px}
.nums{width:50%;float:left; color:#999; text-align:left}
.links{width:50%;float:left; text-align:right}
a.mainopis{color:#999;text-decoration:none}
.mainopisblock{background-color:#000; color:#FFF; text-align:left; padding:10px; min-height:230px;max-height:230px; width:230px; position: relative; float:right; display:none;}
.curpredl .panel .discr{padding-right:20px;background:url('/img/discr.png') no-repeat right;cursor:pointer}
.curpredl .panel .discl{background:url('/img/discl.png') no-repeat right}

</style>

	<div class="curpredl" id="predl">
	<?$this->load->view('block/infodiscr')?>
	</div>
<?$cur=current($Predl); foreach ($Predl as $p):?>
	<div class="curpredl" id="predl<?=$p->id?>" <?if(true || $cur->id != $p->id){?>style="display:none"<?}?>>
	<?//print_r($p)?>
	<?$this->load->view('block/predldiscr',$p)?>
	</div>
<?endforeach;?>


<div class="nav">
<ul>
<?foreach ($Predl as $p):?><li style="margin:5px;list-style-type: none;">
<div class="lastpredl" onclick='$(".curpredl").fadeOut(0); $("#predl<?=$p->id?>").fadeIn(0);'>
<?if(!empty($p->prevue)){?><img src="/image/<?=$p->prevue?>.jpg" alt="<?=$p->title?>"></img><?}?>
</div></li>
<?endforeach;?>
</ul>
</div>


<div style="clear:both"></div>
<div class="pager">

	<div class="nums"><?=$Pager['p']->nums?></div>
	<div class="links">
    <a class="prev" href="#">Назад</a> |
    <a class="next" href="#">Вперед</a>	
	<?//=$Pager['p']->links?></div>
</div>


<?if(!empty($Predl))foreach ($Predl as $p):?>

<?endforeach;?>
<?//print_r($Predl)?>
