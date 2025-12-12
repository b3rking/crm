<?php
	/*require '/usr/share/php/libphp-phpmailer/class.phpmailer.php';
	require '/usr/share/php/libphp-phpmailer/class.smtp.php';
	require '../../config/_config_mail.php';*/

    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
    require_once "/home/admin/vendor/autoload.php";

	require_once("/var/www/crm.buja/model/connection.php");
	require_once("/var/www/crm.buja/model/client.class.php");
    require_once '/var/www/crm.buja/config/_config_mail.php';

	$mail = new PHPMailer;
	$mail->setFrom($_from);
	$client = new Client();

	if ($_GET['sendForAll'] == 'yes') 
	{
		foreach ($client->recupererMailDeClientActif() as $value) 
		{
			foreach(preg_split("#[,]+#", $value->mail) as $value2)
			{
				$mail->addAddress($value2);
			}
		}
	}
	else
	{
		foreach ($client->recupererMailDeClientParSecteur($_GET['sendsecteur']) as $value) 
		{
			foreach(preg_split("#[,]+#", $value->mail) as $value2)
			{
				$mail->addAddress($value2);
			}
		}
	}
	/*$mail->addAddress('crmspidernetreceipt2@gmail.com');
	$mail->addAddress('alainmusha27@gmail.com');
	$mail->addAddress('alainmuchiga@hotmail.com');
	$mail->addAddress('crmspidernetreceipt@gmail.com');*/
//	$mail->addAddress('ngabechristian@gmail.com');
	$mail->Subject = $_GET['sujet'];
	$mail->Body = $_GET['message'];
	$mail->IsSMTP();
	$mail->SMTPSecure = $_smtp_secure;
	$mail->Host = $_host;
	$mail->SMTPAuth = true;
	$mail->Port = $_port;
    $mail->CharSet = 'UTF-8';

	//Set your existing gmail address as user name
	//$mail->Username = 'crmspidernetsender@gmail.com';
	$mail->Username = $_username;

	//Set the password of your gmail address here
	$mail->Password = $_password;
	if(!$mail->send()) {
	  echo 'Email is not sent.';
	  echo 'Email error: ' . $mail->ErrorInfo;
	} else {
	  echo 'L\'envoie reussie.';
	}