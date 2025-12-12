<?php
  require_once("../../model/connection.php");
  require_once("../../model/User.class.php");
  require_once("../../model/comptabilite.class.php");

    $comptabilite = new Comptabilite();
    $user = new User();

  	if (empty($user->getInfoSociete())) 
  	{
	  	if ($user->setInfoSociete(strtoupper($_GET['nom']),strtoupper($_GET['adresse']),$_GET['phone'],$_GET['email'],$_GET['nif'],$_GET['centreFiscal'],strtoupper($_GET['secteur']),$_GET['boiteP'],$_GET['formeJuridique'])) 
  		{
  		  	$idAction = $user->getID_societe()->fetch()['ID_societe']; 
        if ($comptabilite->setHistoriqueAction($idAction,'info societe',$_GET['userName'],date('Y-m-d'),'modifier')) 
          {
            //echo "ok";
          }
  		}
  	}
  	else 
      echo "La societe existe deja, vous ne pouvez pas la creer deux fois";
