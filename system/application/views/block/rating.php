<?
if(!isset($rating) || empty($rating)) $rating = 0;
$true_rating= $rating;
$max_rating = 500;
$max_width=65;
if($rating > 500) $rating = 500;
$width = round($max_width * $rating / 500);
?>
<div class="rating" style="float:left" title="рейтинг: <?=$true_rating?>">
<table cellpadding="0" cellspacing="0" style="table-layout:fixed; width:<?=$max_width?>px; height:10px;background:url('/img/wstar13.png') "><tr>
<td style="width:<?=$width?>px; height:10px;background:url('/img/bstar13.png') ;" nowrap></td><td></td>
</tr></table>
</div>