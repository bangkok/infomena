<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
	Admin configuration file
*/

if ($_SERVER['HTTP_HOST'] == 'shift.loc')
{
	$config["A_SMTP"] = "localhost";
	$config["A_SMTP_port"] = "25";
	$config["A_SMTP_user"] = "";
	$config["A_SMTP_pass"] = "";
	$config["A_admin_mail"] = "";
	$config["A_admin_mail_CC"] =array("");
	$config["A_admin_mail_From"] = "";

	$config["A_language"] = "russian";
	
}
else
{
	$config["A_SMTP"] = "localhost";
	$config["A_SMTP_port"] = "25";
	$config["A_SMTP_user"] = "";
	$config["A_SMTP_pass"] = "";
	$config["A_admin_mail"] = "";
	$config["A_admin_mail_CC"] =array("");
	$config["A_admin_mail_From"] = "";
	$config["A_language"] = "russian";
}

?>
