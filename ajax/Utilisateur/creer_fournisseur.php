<?php
  require_once("../../model/connection.php");
  require_once("../../model/User.class.php");
  require_once("../../model/comptabilite.class.php");

    $comptabilite = new Comptabilite();
    $user = new User();
	  	if ($user->ajouter_fournisseur($_GET['nom'],$_GET['prenom'],$_GET['adres'],$_GET['phone'],$_GET['mail'],$_GET['fonction'],$_GET['datecreation'],$_GET['userName'])) 
  		{
  		  $idAction = $user->getID_fournisseur()->fetch()['ID_fournisseur']; 
        if ($comptabilite->setHistoriqueAction($idAction,'fournisseur',$_GET['userName'],date('Y-m-d'),'creer')) 
          {
            //echo "ok";
          }
  		}
  	
  	