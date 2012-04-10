<?if(isset($Catalog) && !empty($Catalog)){?>
<?if(!empty($Type))$Type.='/';else $Type='';?>
<ul>
<?foreach ($Catalog as $item):?>
	<li><a href="/catalog/<?=$Type?><?=$item->id?>"><?=$item->title?> (<?=$item->num?>)</a></li>
<?endforeach;?>
</ul>

<?}?>