<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require_once "/home/admin/vendor/autoload.php";
	//require_once '/var/www/crm.buja/config/_config_mail.php';
	require_once("/var/www/crm.buja/model/connection.php");
	require_once("/var/www/crm.buja/model/contract.class.php");
    require_once("/var/www/crm.buja/model/comptabilite.class.php");
	require_once '/var/www/crm.buja/config/_config_mail.php';


	$contract = new Contract();
    $comptabilite = new Comptabilite();
    $banque = $comptabilite->getBanqueActiveAndVisibleOnInvoice();

	$facture_id;
	$mailAdress;
	$mois = $_GET['mois_fact'];
	$annee = $_GET['annee_fact'];

	$mail = new PHPMailer;

	$mail->IsSMTP();
	$mail->SMTPSecure = $_smtp_secure;
	$mail->Host = $_host;
	$mail->SMTPAuth = true;
	$mail->Port = $_port;
	$mail->Username = $_username;
	$mail->Password = $_password;
	$mail->SMTPKeepAlive = true;
	$etat = '';

	$mail->setFrom($_from);
	$mail->Subject = "Envoie facture";
    $billing_date = $annee.'-'.$mois.'-01';


	foreach ($contract->recupereIdfactureToSendOnMail($billing_date) as $value) 
	{
		$facture_id = $value->facture_id;
        $client = ['ID_client'=>$value->ID_client,'billing_number'=>$value->billing_number,
                   'nom_client'=>$value->nom_client,'adresse' => $value->adresse,'nif'=>$value->nif,
                  'assujettiTVA'=>$value->assujettiTVA,'telephone'=>$value->telephone,
                   'facture_id'=>$value->facture_id,'numero' => $value->numero,'date_creation'=>$value->date_creation,
                  'show_rate'=>$value->show_rate,'exchange_rate'=>$value->exchange_rate,'tvci'=>$value->tvci,'mail'=>$value->mail];
		//$client = $contract->get_client_by_facture_id($facture_id)->fetch();
		$numero = $value->numero;
		foreach(preg_split("#[,]+#", $value->mail) as $value2)
		{
			$mail->addAddress($value2);
			//echo "addresse : ".$value2;
		}
	  	//$mail->addAddress('ngabechristian@gmail.com');
	  	$mail->Body = 'Bonjour! Voici la facture du mois de(d\') '.$mois;
	  	//require_once("../../printing/fiches/sendFacture.php");
        require_once("../../printing/fiches/imprimerfactureParId.php");

        
	  	$pdf = new myPDF();
	  	/*$pdf->SetLeftMargin(15.2);
		$pdf->AliasNbPages();
		$pdf->init($client,$numero,$facture_id,$banque);
		$pdf->AddPage();
		$pdf->headerTable();
		$pdf->SetWidths(array(50,20,27,30,30,25));
		$pdf->viewTable($contract,$facture_id);*/
        
        //$customer = $pdf->getClient();
        
        $pdf->SetLeftMargin(15.2);
        $pdf->AliasNbPages();
        $pdf->init($client);
        $pdf->setBanque($banque);
        $pdf->AddPage();
        $pdf->headerTable();
        $pdf->SetWidths(array(50,20,25,25,25,25));
        $pdf->viewTable($contract,$facture_id);
        
		$attachment = $pdf->Output('facture_'.$pdf->getClient()['numero'].'.pdf', 'S');
	  	$mail->AddStringAttachment($attachment, 'facture_'.$pdf->getClient()['numero'].'.pdf');

	  	try {
	       $mail->send();
	       $etat = "Envoie reussie";
           $contract->update_Sent_Facture($pdf->getClient()['facture_id'],1);
	  	} catch (Exception $e) {
	      echo $etat =  "Mailer Error : ".$mail->ErrorInfo;
	  	}

	  $mail->clearAddresses();
	  $mail->clearAttachments();
	  unset($pdf);
	}
	//echo $etat;
	$mail->smtpClose();