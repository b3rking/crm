<?php
require_once("model/client.class.php");
require_once("model/typeClient.class.php");
require_once("model/ticket.class.php");
require_once("model/equipement.class.php");
require_once("model/localisation.class.php");
require_once("model/contract.class.php");
require_once("model/User.class.php");
require_once('model/comptabilite.class.php');
require_once('model/service.class.php');
require_once('model/customerNote.class.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function inc_client()
{
	$user = new User();
	$client = new Client();
	$type = new TypeClient();
	$equipement = new Equipement();
	$localisation = new Localisation();
	$contract = new Contract();
    
    $billing_number = "";
	$nom_client = "";
	$secteur = "";
	$date1 = "";
	$date2 = "";
	$typeClient = "" ;
	$status = "";
	$print = "";
    
    $result = $client->afficheTousClients();
	require_once('vue/admin/client/client.php');
}
function sendMailToClient($sendmode,$sujet,$message,$sendsecteur,$sendForAll,$file,$fileName)
{
	/*use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;*/
    require_once "/home/admin/vendor/autoload.php";

	require_once("/var/www/crm.buja/model/connection.php");
	require_once("/var/www/crm.buja/model/client.class.php");
    require_once '/var/www/crm.buja/config/_config_mail.php';

	$mail = new PHPMailer;
	$mail->setFrom($_from);
	$client = new Client();

	if ($sendForAll) 
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
		foreach ($client->recupererMailDeClientParSecteur($sendsecteur) as $value) 
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
	$mail->addAddress('crmspidernetreceipt@gmail.com');
    $mail->addAddress('ngabechristian@gmail.com');*/
    
    $mail->AddAttachment($file,$fileName);
	$mail->Subject = $sujet;
	$mail->Body = $message;
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
	  echo 'L\'envoie reussie.';
	}
}
function filtreClient($billing_number,$nom_client,$secteur,$date1,$date2,$typeClient,$status,$print,$asExcel)
{
	$user = new User();
	$client = new Client();
	$type = new TypeClient();
	$equipement = new Equipement();
	$localisation = new Localisation();
	$contract = new Contract();

	$condition1;
    $condition2;
    $condition3;
    $condition4;
    $condition5;
    $condition6;
    $condition7;
    $query = '';
    //$url = $_GET['url'];
    //$session_user = $_GET['session_user'];
    //$profil_name = $_GET['profil_name'];

    $condition1 = ($billing_number == "" ? "" : " billing_number=".$billing_number);
	$condition2 = ($nom_client == "" ? "" : " nom_client LIKE '%".$nom_client."%' ");
	$condition3 = ($secteur == "" ? "" : " s.ID_secteur='".$secteur."' ");
	$condition4 = ($date1 == "" ? "" : " date_creation='".$date1."' ");
	if ($date2 == '') 
	{
		$condition5 = '';
	}
	else
	{
		if ($date1 != '') 
		{
			$condition5 = " date_creation BETWEEN '".$date1."' AND '".$date2."'";
			$condition4 = '';
		}
		else $condition5 = " date_creation='".$date2."' ";
	}
	$condition6 = ($typeClient == "" ? "" : " type_client='".$typeClient."'");
	$condition7 = ($status == "" ? "" : " etat='".$status."'");

	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
	$condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
	$condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);
	$condition6 = ($condition6 == '' ? '' : 'AND' .$condition6);
	$condition7 = ($condition7 == '' ? '' : 'AND' .$condition7);
	$condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6.$condition7;
	if ($_GET['secteur'] != '') 
	{
		$query = "SELECT c.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,nif,type_client,langue,assujettiTVA,etat,genre FROM client c,point_acces p,secteur s,installation ins WHERE c.ID_client = ins.ID_client AND p.ID_point_acces = ins.ID_point_acces AND c.isDelete = 0 AND p.secteur = s.ID_secteur $condition ORDER BY billing_number DESC ";
	}
	else
	{
		//$condition = substr($condition, 3);
		$query = "SELECT client.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,type_client,nif,langue,assujettiTVA,etat,genre FROM client WHERE isDelete = 0 $condition ORDER BY billing_number DESC ";
	}
	
	$result = $client->filtreClient($query);
    
    //Define the filename with current date
    /*$fileName = "liste-des-clients-gratuit-".date('d-m-Y').".xls";

    //Set header information to export data in excel format
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$fileName);

    //Add the MySQL table data to excel file
    if(!empty($result)) 
    {
        echo implode("\t", ["ID","NOM","OBSERVATION"]) . "\n";
        foreach($result as $item) 
        {
            echo implode("\t", [$item->ID_client,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $item->Nom_client),""]) . "\n";
        }
    }
    exit();*/
    
	if ($print == 1 && !empty($condition)) 
	{
		require_once 'printing/fiches/printFiltreClient.php';
	}
	else
	require_once('vue/admin/client/client.php');
}
function exportFiltreClientAsExcel($data)
{}
function filtreCustomerChild($name,$billing_number)
{
	$condition = '';

	$condition1 = $name == '' ? '':" ch.nom_client LIKE '%".$name."%' OR par.nom_client LIKE '%".$name."%'";
	$condition2 = $billing_number == '' ? '' :" ch.billing_number=".$billing_number." OR par.billing_number =".$billing_number." ";
	$condition = $name != '' && $billing_number != ''? $condition2 : $condition1.$condition2;

	if ($condition != '') 
	{
		$client = new Client();
		$customer_parents = $client->customers_with_contract();
		$children_to_assign = $client->customers_to_assign_parent();
		$children_customers = $client->filtreCustomerChild("WHERE ".$condition);
		require_once('vue/admin/contract/customer_under_contract.php');
	}
	else
	{
		$_SESSION['message'] = "Aucun filtre effectué";
		header('location:customer_under_contract');
	}
}
function inc_service_rendu()
{
	require_once('vue/admin/client/service_rendu.php');
}
function client_coupures()
{
	$client = new Client();
	$contract = new Contract();
	$comptabilite = new Comptabilite();
	require_once 'printing/fiches/client_coupure.php';
}
function inc_contact()
{
	require_once('vue/admin/client/contact.php');
}
function in_article()
{
	require_once('vue/admin/client/article.php');
}
function inc_connexion()
{
	require_once('vue/admin/client/connexion.php');
}
function inc_fichier_client()
{
	require_once('vue/admin/client/fichier_client.php');
}
/*function inc_message()
{
	require_once('vue/admin/client/message.php');
}*/
function detailClient($id)
{
	$client = new Client();
	$ticket = new ticket();
	$contract = new Contract();
	$equipement = new Equipement();
	$user = new User();
	$comptabilite = new Comptabilite();
	$service = new Service();
    $customerNote = new CustomerNote();
	require_once('vue/admin/client/detailClientOldForm.php');
}
function printFiltreClient($type)
{
	$client = new Client();
	require_once 'printing/fiches/printFiltreClient.php';
}
function resumeclient($id)
{
	$client = new Client();
	$contract = new Contract();


	$user = new User();
	$comptabilite = new Comptabilite();
	$ticket = new ticket();
	$type = new TypeClient();
	$equipement = new Equipement();
	$localisation = new Localisation();
	require_once 'printing/fiches/printDetailDunClient.php';
}
function sendmail($sujet,$message)
{
	require '/usr/share/php/libphp-phpmailer/class.phpmailer.php';
	require '/usr/share/php/libphp-phpmailer/class.smtp.php';
	$mail = new PHPMailer;
	$mail->setFrom('admin@example.com');
	$mail->addAddress('crmspidernetreceipt2@gmail.com');
	$mail->addAddress('hamed@spidernet-bi.com');
	$mail->addAddress('alainmuchiga@hotmail.com');
	$mail->addAddress('crmspidernetreceipt@gmail.com');
	$mail->addAddress('ngabechristian@gmail.com');
	$mail->Subject = $sujet;
	$mail->Body = $message;
	$mail->IsSMTP();
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'ssl://smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Port = 465;

	//Set your existing gmail address as user name
	$mail->Username = 'crmspidernetsender@gmail.com';

	//Set the password of your gmail address here
	$mail->Password = 'sender2020';
	if(!$mail->send()) {
	  echo 'Email is not sent.';
	  echo 'Email error: ' . $mail->ErrorInfo;
	} else {
	  echo 'Email has been sent.';
	}
} 
function rapports_etat_client() 
{
	$user = new User();
	$comptabilite =new Comptabilite();
	$client = new Client();
	$localisation = new Localisation();
	$contract = new Contract();
	require_once('vue/admin/client/rapports_etat_client.php');
}
function print_client_derogation()
{
	$client = new Client();
	$contract = new Contract();
	$comptabilite =new Comptabilite();
	require_once('printing/fiches/client_derogation.php');
}
function client_coupure()
{
	$client = new Client();
	require_once('printing/fiches/client_coupure.php');
}
function client_sansdette()
{
	$client = new Client();
	$contract = new Contract();
	require_once('printing/fiches/client_sans_dette.php');
}
function clientSoldeNegatif()
{
	$user = new User();
	$client = new Client();
	$type = new TypeClient();
	$equipement = new Equipement();
	$localisation = new Localisation();
	$contract = new Contract();
	require_once('vue/admin/client/clientSoldeNegatif.php');
}
function clientPartiAvecDette()
{
	$client = new Client();
	$contract = new Contract();
	$comptabilite = new Comptabilite();
	//require_once('vue/admin/client/clientPartiAvecDette.php');
	require_once('printing/fiches/clientPartiAvecDette.php');
}
function clientPartiSansDette()
{
	$client = new Client();
	$contract = new Contract();
	$equipement = new Equipement();
	//require_once('vue/admin/client/clientPartiSansDette.php');
	require_once('printing/fiches/clientPartiSansDette.php');
}
function client_delinquant()
{
	$client = new Client();
	$contract = new Contract();
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/client_delinquant.php');
}
function client_actif()
{
	$client = new Client();
	$contract = new Contract();
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/client_actif.php');
}
function print_client_en_pause()
{
	$client = new Client();
	$contract = new Contract();
	require_once('printing/fiches/print_client_en_pause.php');
}
function nbClientSoldeSupZero()
{
	$contract = new Contract();
	$client = new Client();
	$i = 0;
	foreach ($client->getClientActifs() as $value) 
	{
		$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
        if ($solde > 0) 
        {
        	$i++;
        }
	}
	return $i;
}
function nbClientActif()
{
	$contract = new Contract();
	$client = new Client();
	//$i = 0;
	$nb = count($client->getClientActifs());
	/*foreach ($client->getClientActifs() as $value) 
	{
		$i++;
	}*/
	return $nb;
}
function nbClientSoldeInfOuEgalZero()
{
	$contract = new Contract();
	$client = new Client();
	$i = 0;
	foreach ($client->getClientActifs() as $value) 
	{
		$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
        if ($solde <= 0) 
        {
        	$i++;
        }
	}
	return $i;
}
function nbClientSoldeNegatif()
{
	$contract = new Contract();
	$client = new Client();
	$i = 0;
	foreach ($client->getClientPayants() as $value) 
	{
		$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
        if ($solde < 0) 
        {
        	$i++;
        }
	}
	return $i;
}
function nbClientPartiAvecDette()
{
	$contract = new Contract();
	$client = new Client();
	$i = 0;
	foreach ($client->recupererClientParType('gone') as $value) 
	{
		$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
        if ($solde > 0) 
        {
        	$i++;
        }
	}
	return $i;
}
function nbClientPartiSansDette()
{
	$contract = new Contract();
	$client = new Client();
	$i = 0;
	foreach ($client->recupererClientParType('gone') as $value) 
	{
		$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
        if ($solde == 0) 
        {
        	$i++;
        }
	}
	return $i;
}
function clientRecuperer()
{
	$client = new Client();
	require_once('printing/fiches/client_arecuperer.php');
}
function client_installer() 
{

    $ticket = new ticket();
	$client = new Client();
	require_once('printing/fiches/client_installer.php');
}

function client_voulantdemenager()
{
	$client = new Client();
	require_once('printing/fiches/client_demenager.php');

}
function detail_panneclient()
{
	$client = new Client();
	require_once('printing/fiches/clienDetail_panne.php');
}
function installation_dumois()
{
	$client = new Client();
	require_once('printing/fiches/installation_mensuelle.php');
}
function client_sansfacture()
{
	$client = new Client();
	$contract = new Contract();
	require_once('printing/fiches/client_sansfacture.php');
}
function print_clientSanscontrat()
{
	$client = new Client();
	$contract = new Contract();
	require_once('printing/fiches/client_sanscontrat.php');
}
function printCustomer()
{
	$client = new Client();
	 require_once('printing/fiches/print_clientFree_terminated.php');
}