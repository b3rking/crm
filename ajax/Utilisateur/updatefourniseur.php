<?php
  require_once("../../model/connection.php");
  require_once("../../model/User.class.php");
  require_once("../../model/comptabilite.class.php");

    $comptabilite = new Comptabilite();
    $user = new User();
	  	if ($user->modifier_fournisseur($_GET['idfournisseur'],$_GET['nom'],$_GET['prenom'],$_GET['adres'],$_GET['phone'],$_GET['mail'],$_GET['fonction'],$_GET['datecreation'])) 
  		{
  		  //$idAction = $user->getID_fournisseur()->fetch()['ID_fournisseur']; 
        if ($comptabilite->setHistoriqueAction($_GET['idfournisseur'],'fournisseur',$_GET['userName'],date('Y-m-d'),'modifier')) 
          {
            //echo "ok";
          }
  		}
  	
  	