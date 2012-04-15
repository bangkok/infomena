$('#regt, #regt3').live('click',reg_form);
$('#regbut').live('click',sabmit_form_register);
$('#but_send').live('click',sabmit_form_forgot);

$('#refresh_but').live('click',refresh_captcha);
$('#pwd_remind').live('click',pwd_remind);


$('#regt2').live('click',auth);
$('#regc_img').live('click',reg_but_open);

		
$('#exit').live('click',logout);
$('#exit2').live('click',logout);

function checkusernickname(nickname){
	//$('#checknickname').html('!'+$.ajax({ url: "/ajax/checkusernickname/"+nickname}));
	$('#checknickname').load("/ajax/checkusernickname/"+nickname.trim());
	$('#asgmt').load("/ajax/checkusernickname2/"+nickname.trim());
	//chengecat(false);
}
function chengecat(id){//alert(id);
	//$('#info').load("/ajax/chengecat/"+id);	
	if(!id){id = $('#asgmt select option').first().val();}
$.ajax({
	url: "/ajax/chengecat/"+id, // указываем URL и
	dataType : "json", // тип загружаемых данных
	success: function(json) {
	// alert($('#valuta option[value="'+json.valuta+'"]').val());
		 $('#info').val(json.cost_info);
		 $('#cash').val(json.price_cash);
		 $('#valuta option[value="'+json.valuta+'"]').attr("selected", "selected");
		 $('#comis').val(json.comis);
		 $('#cost').val(json.cost);
	 
	}
 
});


}
function changeval(elem,id){
	//alert($(elem).children('option[value="'+$(elem).val()+'"]').html());
	if($(elem).val()=='') $('#'+id).html(''); else
	$('#'+id).html($(elem).children('option[value="'+$(elem).val()+'"]').html());
}
function delimg(id, pos){
	//$('#images').load('/ppage/my_bussines/del/'+id);
		var query = {'id':id,'pos':pos};
		//query['pos'] = 0;
		$.post('/ppage/my_bussines/del',query,function(data){
		$('#images').html(data);});
}
function convinfo(){
	$.blockUI({ message: $('#ajax').load('/ajax/convinfo',block), css:{width:'340px',bottom:'90px',top:'none'} });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);	
}
function conv(){
	var val = $('#conv input[name="val"]');
	var summ = $('#conv input[name="summ"]');
	var valuta1 = $('#conv select[name="valuta1"]').val();
	var valuta2 = $('#conv select[name="valuta2"]').val();
	//res = valuta1
	//summ.val(valuta1*val.val());
	
	var query = $("#conv").serialize();
	$.post('/ajax/valuta',query,function(data){
					summ.val(data);
				$('.but_close').click($.unblockUI);
				});
	
	//alert(valuta1.val());
	//$(val).keyup(function(){summ.val(valuta1*val.val())});
	
	$('.but_close').click($.unblockUI);
}

function geo(geo,id){
	var query = {'geo':geo, 'id':id};
	if(geo=='c'){
		$.post('/ajax_features/geo',query,function(data){
		$('#region').html(data);});	
		
		var query = {'geo':'r', 'id':'null'};
		$.post('/ajax_features/geo/',query,function(data){
		$('#town').html(data);});
		//alert(geo+' '+id);
	}
	if(geo=='r'){
		$.post('/ajax_features/geo/',query,function(data){
		$('#town').html(data);});	
	}
	if(geo=='t'){

	}
	
}
function stat(val){
	if(val == -1) {
		document.getElementById('status_self').style.display='block';}
	else {document.getElementById('status_self').style.display='none';}
}
function auth(){
	
		if ($('#regc_img').attr('src')=='/images/top_open.png') 
		{reg_but_open();$('#regc_img').attr('src','/images/top_close.png');} else
		 {
		query = $("#auth").serialize();
		$.post('/ajax_features/auth',query,function(data){
					$('#regall').html(data);
					//$.blockUI({ message: $('#regall').load('/ajax_features/auth',''), css: { width: '450px',top:'10px' } });
					//$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
					//$('#regall').load('/ajax_features/auth');
					//$.growlUI('Вы успешно вошли в систему', '');
					//$('#but_close').click($.unblockUI);
					//$('#exit').click(logout);
					//$('#reg_open_but').click(reg_but_open);
					});
		 }
	
}	
function logout(){
	$.post('/ajax_features/logout','',function(data){
		$('#regall').html(data);
	});	
	
}
function refresh_captcha(){
	$('#codimg').attr('src','/auth/captcha/' + Math.round((Math.random() * (100 - 1))) );
}
function reg_but_open()
{
	$('#regc').slideToggle();
	$('#reg').slideToggle();
	if ($('#regc_img').attr('src')=='/images/top_open.png') 
			$('#regc_img').attr('src','/images/top_close.png'); 
	else	$('#regc_img').attr('src','/images/top_open.png');
}
function block(){
	$('.but_close').click($.unblockUI);
}
function reg_form()
{
//	$('#ajax2').load('http://test.loc/ajax_features/register');
//*

	$.blockUI({ message: $('#ajax').load('/ajax_features/register',reg_succ), css: { width: '470px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
//*/
}

function reg_succ()
{
	$('#refresh_but').click(function(){
		refresh_captcha();
	})
	$('.but_close').click($.unblockUI);		

}
function sabmit_form_register(){
	
				var query = $("#reg_form").serialize();
				$.post('/ajax_features/register',query,function(data){
					$('#ajax').html(data);
				$('.but_close').click($.unblockUI);
				});
}
function sabmit_form_forgot(){
	
		var query = $("#reg_form").serialize();
		$.post('/ajax_features/forgot',query,function(data){
			$('#ajax').html(data);
		$('.but_close').click($.unblockUI);
		});	
}

function pwd_remind()
{
	$.blockUI({ message: $('#ajax').load('/ajax_features/forgot',pwd_succ), css: { width: '470px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
}

function pwd_succ()
{
	$('#refresh_but').click(function(){
		refresh_captcha();
	});
	/*
	$('#but_send').click(function(){
		query = $("#reg_form").serialize();
		$.post('/ajax_features/forgot',query,function(data){
			$('#ajax').html(data);
		});		
	});
	*/
	$('.but_close').click($.unblockUI);	
		
} 

function service_rules(elem,path)
{
	$('#service_rules').load(path,'',service_rules_block);
	//$('#reg_block').slideToggle();
	setTimeout(function(){
		$('#reg_block').toggle();
		$('#service_rules').toggle();	
	},100);

/*	$.blockUI({ message: $(elem).load(path,'',service_rules_block), css: { width: '270px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);*/
}
function bookmark(){
 var url = window.document.location;
 var title = window.document.title;
 var a=document.getElementById('plus');
 if ($.browser.msie  && 9 > $.browser.version && $.browser.version >= 4) window.external.AddFavorite(url,title);
 else if ($.browser.opera) {
  a.href = url;
  a.rel = "sidebar";
  a.title = url+','+title;
  return true;
 }
 else if ($.browser.mozilla) window.sidebar.addPanel(title,url,"");
 else {
		$.blockUI({ message: "<p>Для того, чтобы добавить эту страницу в закладки, нажмите <b>Сtrl+D</b></p>" });
		$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
	  }
 return false;
}
function service_rules_block(){
	$('.but_close').click(function(){
		$('#reg_block').toggle();
		$('#service_rules').toggle();
	});
}

    $.blockUI.defaults = { 
    message:  '<h1></h1>', 
    css: { 
        padding:        0, 
        margin:         0, 
        width:          '30%', 
        top:            '40%', 
        left:           '35%', 
        textAlign:      'center', 
        color:          '#000', 
        border:         '3px solid #aaa', 
        backgroundColor:'#f2f5fa', 
        cursor:         'default' 
    }, 
    overlayCSS:  { 
        backgroundColor: '#000', 
        opacity:         0.3 
    }, 
    growlCSS: { 
        width:    '370px', 
        top:      '30px', 
        left:     '', 
        right:    '10px', 
        border:   'none', 
        padding:  '5px', 
        opacity:   0.9, 
        cursor:    null, 
        color:    '#000', 
        backgroundColor: '#fff9c8', 

    }, 
    iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank', 
    forceIframe: false, 
    baseZ: 100, 
    centerX: true, 
    centerY: true, 
    allowBodyStretch: true, 
    bindEvents: true, 
    constrainTabKey: true, 
    fadeIn:  200, 
    fadeOut:  400, 
    timeout: 0, 
    showOverlay: true, 
    focusInput: true, 
    applyPlatformOpacityRules: true, 
    onUnblock: null, 
    quirksmodeOffsetHack: 4 
}; 

$(document).ready(function(){
	$('#plus').hover(function(){$('#plus_content').toggle();},function(){$('#plus_content').toggle();});
	$('#plus').click(bookmark);
	$('#main_search_predl').click(function(){
		$('#radio1').attr('src','/images/radio_bga.png');
		$('#radio0').attr('src','/images/radio_bg.png');
		$('#form_type').val('1');
	});
	$('#main_search_spros').click(function(){
		$('#radio0').attr('src','/images/radio_bga.png');
		$('#radio1').attr('src','/images/radio_bg.png');
		$('#form_type').val('0');

	});
		
if($('#info100').attr('checked')) {$('.valdisplay').css({'display' : 'none'});}
$('#perc').val(sub100($('#peri').val()));
comis(0,5);

$('#readyTest').corner();
/*$(function(){*/
	$('div.blockPage').each(function() {
	var t = $('p', this).text();
	eval(t);
	});
});
/*});*/

function number(val){
	if(val/1) {return val;}
	return false;
}
function sub100(val){
	if(val/1 && val>0) {return 100-val;}
	return '';
}
function ivaluta(){
	var per = $('#perc').val();
	//val = $('#cost').val();
	var val = $('#price_info').val();
	//curs = $('#valuta').val();
	var curs = $('#valuta option:selected').attr('curs');
	var res = Math.round(val*per/(100-per)/curs*100)/100;
	$('#price_cash').val(res);
	if(res)	$('#cost_cash').html('+ '+res+' '+$('#valuta option:selected').html());
	else $('#cost_cash').html('');
	//(1+per/100)(1-per/100)
}
function comis(elem,percent){
	if(elem==0) elem = $('#price_info');
	if(!percent) percent = 5;
	//alert($(elem).val());
	if($('#info100').attr('checked')) var p=1;
	else var p = 1 - $('#perc').val()/100;
	//alert(p);
	var type = $('input[type="radio"][name="type"][value="predl"]').attr('checked');
	if(type){
		$('#comis2').val(Math.round($(elem).val() /p * percent)/100);
		$('#cost').val(Math.round($(elem).val() *(100+percent / p))/100);
	}else{
		$('#comis2').val('');
		$('#cost').val($(elem).val());
	}
	ivaluta();
}

function ordercomis(elem,percent){	
	if(elem==0) elem = $('#info');
	if(!percent) percent = 5;
	
	var info = $('#info').val();
	var cash = $('#cash').val();
	var curs = $('#valuta option:selected').attr('curs');
	var comis = Math.round((cash*curs + 1*info) * percent)/100;
	
	$('#comis').val(comis);
	$('#cost').val(Math.round((1*info + 1*comis)*100)/100);
	//$('#cost').val(Math.round((cash*curs + 1*info) * (100 + percent))/100);
	
}
function catalog(){
	
	var predl = $('#catalogblock #catpredl').attr('checked');
	var spros = $('#catalogblock #catspros').attr('checked');
	
	var query = {'predl':predl,'spros':spros};
	
	$.post('/ajax/catalog',query,function(data){
		$('#catalogblock .content').html(data);
	});	
}
/*
function CheckboxCheck (Elem) {
  if (Elem.checked) {
	$(Elem).parent().removeClass().addClass('checkboxOn');
   }
	else {
	 $(Elem).parent().removeClass().addClass('checkboxOff');
	}
}

function RadioCheck (Elem) {
  if (Elem.checked) {
	$('input[type='+Elem.type+'][name='+Elem.name+']').parent('span').removeClass().addClass('checkboxOff');
	$(Elem).parent('span').removeClass().addClass('checkboxOn');
   }
}
*/