<div>
	<h2><?=$content_title?></h2>
	<div>
	<form id="authLogin" action="<?=base_url()?>auth/login" method="POST">
		<div><?=$msg?></div>	
<?if (!isset($_SESSION['auth']['login'])||isset($_SESSION['auth']['login'])&&$_SESSION['auth']['login']=='') 
  {?>
		<div>Имя пользователя: </div>
		<div><input type="text" name="username" value="<?=$username?>" /></div>

		<div>Пароль: </div>
		<div><input type="password" name="password" value="" /></div>

		<div><input type="submit" name="sub" value="Войти" /></div>
	</form>
	<p>
		<a id="authForgot" href="<?=base_url()?>auth/forgot">Забыл пароль</a>
		<a id="authRegister" href="<?=base_url()?>auth/register">Регистрация</a>
	</p>
<?}?>
	</div>
</div>