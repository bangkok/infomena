$("#authLogout").submit(function(){
	ajax.doLoad({
		block:'<?=$block?>', method:'logoutAjax', loadInfo:'<?=$info?>',
		param: new Array(new Array(''),0),
		hist:true, infoBlock:'<?=$infoBlock?>', controller:'<?=$controller?>'});
	return false;
});

$("#auth>span").html('<span>Вы авторизованы как <strong><?=$user->login?></strong></span>');
