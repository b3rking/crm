<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('model/User.class.php');
function login()
{
	require_once('vue/admin/login.php');
}
function traiterLogin($login, $password, $remember_me)
{
    $user = new User();
    $data = $user->recupererUnUser($login, $password);

    if ($data) 
    {
        $_SESSION['ID_user'] = $data['ID_user'];
        $_SESSION['userName'] = $data['nom_user'];
        $_SESSION['profil_name'] = $data['profil_name'];
        $_SESSION['profil_id'] = $data['profil_id'];

        // Infos société
        $_SESSION['nomSociete'] = $user->getNomSociete()->fetch()['nom'];
        $_SESSION['adresse'] = $user->get_adresse()->fetch()['localisation'];
        $_SESSION['telephone'] = $user->get_phone()->fetch()['phone'];
        $_SESSION['email'] = $user->get_mail()->fetch()['email'];

        // Cookies Remember me (attention: idéalement stocker un token, pas le mot de passe)
        if (!empty($remember_me)) {
            setcookie("remember_login", $login, time() + (10*365*24*60*60));
        } else {
            if (isset($_COOKIE['remember_login'])) setcookie("remember_login", "");
        }

        // Vérification du champ must_change_password
        if ($data['must_change_password'] == 1) 
        {
            $_SESSION['force_change'] = true;
            header('Location: vue/force_change_pswd.php');
            exit;
        } 
        else 
        {
            header('Location: dashboard');
            exit;
        }
    }
    else 
    {
        login();
        echo '<div class="alert alert-danger text-center">Login ou mot de passe incorrect</div>';
    }
}


/*
function traiterLogin($login, $password, $remember_me)
{
    $user = new User();
    if ($data = $user->recupererUnUser($login, $password)->fetch()) 
    {
        $_SESSION['ID_user'] = $data['ID_user'];
        $_SESSION['userName'] = $data['nom_user'];
        $_SESSION['profil_name'] = $data['profil_name'];
        $_SESSION['profil_id'] = $data['profil_id'];

        $_SESSION['nomSociete'] = $user->getNomSociete()->fetch()['nom'];
        $_SESSION['adresse'] = $user->get_adresse()->fetch()['localisation'];
        $_SESSION['telephone'] = $user->get_phone()->fetch()['phone'];
        $_SESSION['email'] = $user->get_mail()->fetch()['email'];

        // Cookies Remember me
        if (!empty($remember_me)) {
            setcookie("remember_login",$login,time()+(10*365*24*60*60));
            setcookie("remember_password",$password,time()+(10*365*24*60*60));
        } else {
            if (isset($_COOKIE['remember_login'])) setcookie("remember_login","");
            if (isset($_COOKIE['remember_password'])) setcookie("remember_password","");
        }

        //  Vérification du champ must_change_password
        if ($data['must_change_password'] == 1) 
        {
            $_SESSION['force_change'] = true;
            //  Redirection correcte
            header('Location: vue/force_change_pswd.php');
            exit;
        } 
        else 
        {
            header('Location: dashboard');
            exit;
        }
    }
    else {
        login();
        echo '<div class="alert alert-danger text-center">Login ou mot de passe incorrect</div>';
    }
}
*/


function resetPassword($email)
{
	$user = new User();
	if (count($user->getUserInfoByEmail($email)) > 0) 
	{
		//use PHPMailer\PHPMailer\PHPMailer;
        //use PHPMailer\PHPMailer\SMTP;
        //use PHPMailer\PHPMailer\Exception;

        require_once "/home/admin/vendor/autoload.php";
        require_once 'config/_config_mail.php';

        $mail = new PHPMailer;
        $mail->setFrom($_from);

		$string = implode('', array_merge(range('A', 'Z'),range('a', 'z'),range('0', '9')));
		$token = substr(str_shuffle($string), 0,20);

		// on modifie la date de reinitialisation et le geton
		// ....
		// On prepare l'envoie de couriel
		// on stock lien vers le formulaire de modification de mot de pass 
        //$headers = "From: Sendmail Tests" . PHP_EOL;
        //$headers .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;

		$link = 'http://'.$_SERVER['SERVER_ADDR'].WEBROOT.'recoverpwdform-'.$token;
		$subject = "reinitialisation de votre mot de passe";
		$message  = '<p>pour reinitialiser votre mot de passe, Veuillez suivre ce lien: <a href ="'.$link.'">'.$link.'</>';
        
        
        $mail->addAddress('ngabechristian@gmail.com');
        $mail->Subject = 'Envoie';
        $mail->Body = $message;
        $mail->IsSMTP();
        $mail->isHTML(true);
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
          echo "Erreur lors de l'envoi de l'email";
          echo 'Email error: ' . $mail->ErrorInfo;
        } else {
            $user->updateRecoveryToken($email,date('Y-m-d'),$token);
			echo "le mail vous a été envoyé, veuillez consulter votre boite de messagerie";
        }

		/*$mail = new PHPMailer;
		$mail->setFrom($_from);
		$mail->addAddress($email);
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->IsSMTP();
		$mail->SMTPSecure = $_smtp_secure;
		$mail->Host = $_host;
		$mail->SMTPAuth = true;
		$mail->Port = $_port;
		$mail->Username = $_username;
		$mail->Password = $_password;

		if(!$mail->send()) 
		{
			echo 'Email is not sent.';
			echo 'Email error: ' . $mail->ErrorInfo;
		} 
		else 
		{
			echo 'L\'envoie reussie.';
		}*/
	}
	else echo "l'adresse email n'est pas retrouvable!";
}
function inc_recoverpwdform($token)
{
	require_once 'vue/admin/login/recover-password.php';
}
function inc_homeAdmin()
{
	$user = new User();
	require_once('vue/admin/home.admin.php');
}
function inc_homeCommercial()
{
	require_once('vue/admin/home.commercial.php');
}
function deconnexion()
{
	session_destroy();
	login();
	//in_login();
}
?>