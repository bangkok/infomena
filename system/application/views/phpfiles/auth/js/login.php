$("#authLogin").submit(function(){
	ajax.doLoad({
		block:'<?=$block?>', method:'loginAjax', loadInfo:'<?=$info?>',
		param: new Array(new Array($("#authLogin").find("input[name='username']").val(),
			$("#authLogin").find("input[name='password']").val(),
			'sub'),0),
		hist:true, infoBlock:'<?=$infoBlock?>', controller:'<?=$controller?>'});
	return false;
});

$("#authForgot").bind("click", function(){
	ajax.doLoad({
		block:'<?=$block?>', method:'forgotAjax', loadInfo:'<?=$info?>',
		param: new Array(new Array(''),0),
		hist:true, infoBlock:'<?=$infoBlock?>', controller:'<?=$controller?>'});
	return false;
});

$("#authRegister").bind("click", function(){
	ajax.doLoad({
		block:'<?=$block?>', method:'registerAjax', loadInfo:'<?=$info?>',
		param: new Array(new Array(''),0),
		hist:true, infoBlock:'<?=$infoBlock?>', controller:'<?=$controller?>'});
	return false;
});