<?$MenuTop = $MenuTop['child'];
$end=end($MenuTop);
foreach ($MenuTop as $item):?>
<?
		if(!empty($item['htmlid'])) $class= ' id="'.$item["htmlid"].'" ';else $id ='';
		if(!empty($item['htmlclass'])) $class= ' class="'.$item["htmlclass"].'" ';else $class ='';
		if(!empty($item['title'])) $title = ' title="<span>'.$item["title"].'</span>" ';else $title ='';
?>
<a href="<?=$item['link']?>"<?=$title?>><?=$item['name']?></a><?if($end['id']!=$item['id']):?> | <?endif;?>
<?endforeach;?>
<style type="text/css">

.tooltip{
	display: table;
	width:277px;
	height:99px;
	background:transparent url(/img/toptool.png) top center no-repeat;
	/*padding: 25px 15px;*/
	text-align:left;
}
.tooltip span{
	padding:25px 15px 10px 15px;
	display: table-cell; 
	vertical-align: middle;
}
</style>
<script type="text/javascript">
$(".top_menu a[title]").tooltip({position: 'bottom rigth',	offset: [0, -55]});
</script>