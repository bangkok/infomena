$('#regt, #regt3').live('click',reg_form);
$('#regbut').live('click',sabmit_form_register);
$('#but_send').live('click',sabmit_form_forgot);

$('#refresh_but').live('click',refresh_captcha);
$('#pwd_remind').live('click',pwd_remind);


	
$('#regt2').live('click',auth);	
$('#regc_img').live('click',reg_but_open);

		
$('#exit').live('click',logout);
$('#exit2').live('click',logout);
function delimg(id){
	/*alert(id);*/
	$('#images').load('/ppage/my_bussines/del/'+id);
}
function geo(geo,id){
	query = {'geo':geo, 'id':id};
	if(geo=='c'){
		$.post('/ajax_features/geo',query,function(data){
		$('#region').html(data);});	
		
		query = {'geo':'r', 'id':'null'};
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
	
				query = $("#reg_form").serialize();
				$.post('/ajax_features/register',query,function(data){
					$('#ajax').html(data);
				$('.but_close').click($.unblockUI);
				});
}
function sabmit_form_forgot(){
	
		query = $("#reg_form").serialize();
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
 a=document.getElementById('plus');
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
        '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px',
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
        '-webkit-border-radius': '10px', 
        '-moz-border-radius':    '10px' 
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


});