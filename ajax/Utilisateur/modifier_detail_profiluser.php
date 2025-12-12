 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
	require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

	$user = new User();
	if($user->modif_detailprofil($_GET['identifiant'],$_GET['nomuser'],$_GET['prenomuser'],$_GET['adresmail'],$_GET['loginuser']) > 0)
	{
		/*if ($comptabilite->setHistoriqueAction($_GET['identifiant'],'detail utilisateur',$_GET['nomuser'],date('Y-m-d'),'modifier'))
		{
   
        }*/
    }
  
     