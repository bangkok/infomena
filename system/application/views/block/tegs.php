<?if(!empty($tegs)):?>
<?$tegsa = explode(",",$tegs)?>
<?foreach ($tegsa as $teg):?>
<a href="/ppage/my_bussines/<?=$teg?>"><?=$teg?></a><?if($teg!=end($tegsa)){?>, <?}?>
<?endforeach;?>
<?endif;?>