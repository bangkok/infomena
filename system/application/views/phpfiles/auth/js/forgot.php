$("#forgotCaptAjax").click(function(){
	$("#forgotCaptAjax").attr("src", "/main/captcha/"+Math.random());
});

$("#forgotCaptAjax").tooltip({
	track: true,
	delay: 0,
	showURL: false,
	showBody: "|",
	opacity: 0.85
});

$("#authForgot").submit(function(){
	ajax.doLoad({
		block:'<?=$block?>', method:'forgotAjax', loadInfo:'<?=$info?>',
		param: new Array(new Array($("#authForgot").find("input[name='user']").val(),
			$("#authForgot").find("input[name='code']").val(),
			'sub'),0),
		hist:true, infoBlock:'<?=$infoBlock?>', controller:'<?=$controller?>'});
	return false;
});