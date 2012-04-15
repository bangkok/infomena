$("#registerCaptAjax").click(function(){
	$("#registerCaptAjax").attr("src", "/main/captcha/"+Math.random());
});

$("#registerCaptAjax").tooltip({
	track: true,
	delay: 0,
	showURL: false,
	showBody: "|",
	opacity: 0.85
});

$("#registerAjax").submit(function(){
	ajax.doLoad({
		block:'<?=$block?>', method:'registerAjax', loadInfo:'<?=$info?>',
		param: new Array(new Array(
			$("#registerAjax").find("input[name='name']").val(),
			$("#registerAjax").find("input[name='username']").val(),
			$("#registerAjax").find("input[name='password']").val(),
			$("#registerAjax").find("input[name='password2']").val(),
			$("#registerAjax").find("input[name='email']").val(),
			$("#registerAjax").find("input[name='tel']").val(),
			$("#registerAjax").find("input[name='code']").val(),
			'sub'),0),
		hist:true, infoBlock:'<?=$infoBlock?>', controller:'<?=$controller?>'});
	return false;
});

//$("#<?=$block?>").jScrollPane({scrollbarWidth:10, scrollbarMargin:0, showArrows:true, arrowSize: 10, scrollbarOnLeft:false});