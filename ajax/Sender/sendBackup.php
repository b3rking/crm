<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
    

	require_once "vendor/autoload.php";
	require_once '/var/www/crm.buja/config/_config_mail.php';

	$mail = new PHPMailer;
    //$mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
    //$mail->SMTPDebug = true;
	$mail->setFrom($_from);
	/*if (date("H") == 7) {
		$namefile = "spi_buja_".date("d-m-Y")."_07-01.sql.gz";
	}
	else if (date("H") == 12) 
	{
		$namefile = "spi_buja_".date("d-m-Y")."_12-15.sql.gz";
	}
    else $namefile = "spi_buja_".date("d-m-Y")."_18-15.sql.gz";
	$mail->AddAttachment("/home/admin/backupdb/".$namefile);*/
    //$namefile = "spi_buja_".date("d-m-Y")."_07.sql.gz";
    $namefile = "spi_buja_".date("d-m-Y")."_".date("H").".sql.gz";
   // $mail->AddAttachment("/home/admin/backupdb/".$namefile);
    $mail->AddAttachment("/var/backups/".$namefile);
	$mail->addAddress('alainmusha27@gmail.com');
    //$mail->addAddress('ngabechristian@gmail.com');
   // $mail->addAddress('backup.spidernet.bi@gmail.com');
	$mail->Subject = 'Envoie';
	$mail->Body = 'Backup de donnees pour buja';
	$mail->IsSMTP();
	$mail->SMTPSecure = $_smtp_secure;
	$mail->Host = $_host;
	$mail->SMTPAuth = true;
	$mail->Port = $_port;

	//Set your existing gmail address as user name
	//$mail->Username = 'crmspidernetsender@gmail.com';
	$mail->Username = $_username;

	//Set the password of your gmail address here
	$mail->Password = $_password;
	if(!$mail->send()) {
	  echo 'Email is not sent.';
	  echo 'Email error: ' . $mail->ErrorInfo;
	} else {
	  echo "L'envoie reussie.";
	}