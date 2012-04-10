<?if (! (isset($this->data["authed"]) && $this->data["authed"]) ):?><style type="text/css">#main_menu{display:none}</style><?endif;?>
<?//if (! (isset($this->data["authed"]) && $this->data["authed"]) ) return false;
if(!isset($Content['PageId'])) $Content['PageId'] = $Content['id'];

//print_r($Menu);
if(false && !isset($Menu['child']))
{
$ID = $Content['id'];
$UPID = $Content['upId'];
if(!isset($TMap[$UPID][$ID])) return false;
$CUR = $TMap[$UPID][$ID];


if (!isset($CUR['child']) && isset($CUR['parent']['parent']))
	$Menu = $CUR['parent']['parent'];
elseif(isset($CUR['parent']))
	$Menu = $CUR['parent'];
else 
	$Menu = $CUR;
	
	//if (empty($Menu['child'])) $Menu= $TMap[1][2];
//print_r($Menu);

}
$page_title = $Menu['name'];
/*
$Menu['child'] = $this->data['Menu'];
if(!isset($Menu['child']))
	$Menu['child'] = $Menu;
*/
?>


<div class="block" id="main_menu">

<div class="blheader">
<div class="bltop"><div class="bltleft"><div class="bltright">
<div class="blhcontent"><span class='title'><?=$page_title;?></span></div>
</div></div></div>
</div>

<div class='blcontent'>
<div class="blcleft"><div class="blcright">
<div class='content'>
<?php if(!empty($Menu['child'])):?>
                                                	<ul class="menu">
<?php foreach ($Menu['child'] as $item):?><?if(isset($item['mapId']))$item['id']= $item['mapId'];?><?$cnt = !empty($item['cnt']) ? " ({$item['cnt']})" : ''?>
	<?php if(/*!stristr(*/$item['id'] !=  $Content['PageId']):?>
		<li><a href="<?=$item['link']?>"><?=$item['name'].$cnt?></a>
	<?php else:?>
		<li><a class="active" href="<?=$item['link']?>"><b><?=$item['name'].$cnt?></b></a>
	<?php endif;?>
	<?php if(isset($item['child'])):?>
			<ul>
		<?php foreach ($item['child'] as $subitem):?><?if(isset($subitem['mapId']))$subitem['id']= $subitem['mapId'];?><?$cnt = !empty($subitem['cnt']) ? " ({$subitem['cnt']})" : ''?>
				<?php if($subitem['id'] != $Content['PageId']):?>
				<li><a  href="<?=$subitem['link']?>"><?=$subitem['name'].$cnt?></a></li>
				<?php else:?>
				<li><a  href="<?=$subitem['link']?>"><b><?=$subitem['name'].$cnt?></b></a></li>
				<?php endif;?>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
	</li>
<?php endforeach;?>
                                                	</ul>	
<?php endif;?>	
</div>
</div></div>
</div>

<div class="blfooter">
<div  class="blbot"> <div class="blbleft"> <div class="blbright">
</div></div></div>
</div>

</div>



