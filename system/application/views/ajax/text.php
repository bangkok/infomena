<?if(isset($Content) && !empty($Content)):?>
<div class='but_close'><img src='/images/close_button.png'></div>
<?if(isset($Content['name']) && !empty($Content['name'])){?><h1><?=$Content['name']?></h1><?}?>
<?if(isset($Content['text']) && !empty($Content['text'])){?><?=$Content['text']?><?}?>

<?endif;?>