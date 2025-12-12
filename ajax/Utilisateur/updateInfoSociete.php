<?php
  require_once("../../model/connection.php");
  require_once("../../model/User.class.php");
  require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

  $user = new User();

        
  if ($user->updateInfoSociete($_GET['id'],strtoupper($_GET['nom']),strtoupper($_GET['ville']),strtoupper($_GET['adresse']),$_GET['phone'],$_GET['email'],$_GET['nif'],$_GET['centreFiscal'],strtoupper($_GET['secteur']),$_GET['boiteP'],$_GET['formeJuridique']) > 0) 
  {
  	if ($comptabilite->setHistoriqueAction($_GET['id'],'info societe',$_GET['userName'],date('Y-m-d'),'modifier'))
  	{
  	echo "ok";
  }
  }
