<?
define('DOMAIN_NAME',$_SERVER['HTTP_HOST']);
	function makePassword($len = 4)
                {
        $vowels = array('a', 'e', 'i', 'o', 'u', 'y');
        $confusing = array('I', 'l', '1', 'O', '0','o');
        $replacements = array('A', 'k', '3', 'U', '9','e');
        $choices = array(0 => rand(0, 1), 1 => rand(0, 1), 2 => rand(0, 2));
        $parts = array(0 => '', 1 => '', 2 =>'');

        if ($choices[0]) $parts[0] = rand(1, rand(9,99));
        if ($choices[1]) $parts[2] = rand(1, rand(9,99));

        $len -= (strlen($parts[0]) + strlen($parts[2]));
        for ($i = 0; $i < $len; $i++)
        {
                if ($i % 2 == 0) $parts[1] .= chr(rand(97, 122));
                else $parts[1] .= $vowels[array_rand($vowels)];
        }
        if ($choices[2]) $parts[1] = ucfirst($parts[1]);
        if ($choices[2] == 2) $parts[1] = strrev($parts[1]);

        $r = $parts[0] . $parts[1] . $parts[2];
        $r = str_replace($confusing, $replacements, $r);
        return $r;
                }
		
	if (isset($run) && $run){
?>
<div class='but_close'><img src='/images/close_button.png'></div>
					<table cellspacing=0 cellpadding=2 border=0 id='regf'>
							<tr><td><img src='/images/slogo.png'></td><td align=left><span class='head' id='forgot'>Восстановление пароля</span></td></tr>
					</table>
		<p>
<?=$message?>
		</p>	
		<p style="margin-bottom:20px;"></p>	

<?}else{?>
				<div class='but_close'><img src='/images/close_button.png'></div>
					<form method='post' id='reg_form'>
					<table cellspacing=0 cellpadding=2 border=0 id='regf'>
							<tr><td class="td_logo"><img src='/images/slogo.png'></td><td align=left><span class='head' id='forgot'>Забыли пароль?</span></td></tr>
							<tr><td colspan="2"><center><?=$message?></center></td></tr>
							<tr><td colspan="2"><span id='error_email' class='ferr'><?if($this->validation){?><?=$this->validation->email_error?><?}?></span></td></tr>
							<tr><td align=right><?=$fields['email']?>:</td><td align=left><input type=text class=input name=email id='email'></td></tr>
							<tr><td align=right><span id='refresh_but'><?=$fields['torenew']?></span></td><td align=left ><img src="/auth/captcha/<?=rand();?>" id='codimg'></td></tr>
							<tr><td colspan="2"><span id='error_cod' class='ferr'><?if($this->validation){?><?=$this->validation->cod_error?><?}?></span></td></tr>
							<tr><td align=right><?=$fields['cod']?>:<span id='error_cod' class='ferr'></span></td><td align=left><input type=text name=cod class=input id='cod'></td></tr>
							<tr><td>&nbsp;</td><td align=left><span class=subhead>Введите код подтверждения</span></td></tr>
							<tr><td></td><td align=left><input type=button id='but_send'></td></tr>
					</table>
					</form>
<?}?>