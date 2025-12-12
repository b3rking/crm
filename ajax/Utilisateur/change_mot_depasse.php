 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
	require_once("../../model/comptabilite.class.php");
	
	$user = new User();
	$comptabilite = new Comptabilite();

	if($user->changemp($_GET['nomss'],$_GET['nouveaupassword']) > 0)
	{
		
		/*$idAction = $user->getLastUser()->fetch()['ID_user'];
	 	  if ($comptabilite->setHistoriqueAction($idAction,'utilisateur',$_GET['nomss'],date('Y-m-d'),'modifier mot de passe')) 
			{
				echo "Vous venez de changer votre mot de passe avec succès";
			}*/
   
    }
  
     
