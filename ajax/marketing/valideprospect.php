<?php
require_once("../../model/connection.php");
require_once("../../model/marketing.class.php");
require_once("../../model/client.class.php");
require_once("../../model/typeClient.class.php");

$marketing = new Marketing(); 

$client = new Client();
$type = new TypeClient();

$idClient;


if($resultat = $marketing->selection1prospect($_GET['idprospect'])->fetch())
{
	//print_r($resultat);
	if ($data = $client->recupererDernierClient()->fetch()) 
	{
	    $idClient = $data['ID_client'] + 1;
	}
    $etat = 'N/A';

	if ($client->saveclient($idClient,$resultat['nom'],$resultat['telephone'],null,$resultat['mail'],$resultat['adresseProspect'],"","",$_GET['type'],date('Y-m-d'),$_GET['location'],$_GET['langue'],$_GET['nif'],$_GET['assujettitva'],$etat,null,$resultat['genre'])) 
	{
		/*($idClient,$idType)*/
		if ($marketing->uptadateEtatprospect($_GET['idprospect'],"valider"))
		{
			//echo "creation reussie";
		}
	    /*if ($type->affecterTypeClient($dernierIdClient,$_GET['type'])) 
	    {    
			/*if ($marketing->uptadateEtatprospect($_GET['idprospect'],"valider")) 
			{
				?> 
				
					<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span>
					</button>
					<h3 class="text-success"><i class="fa fa-check-circle"></i>Validation</h3> Le prospect  <?php echo $resultat['nom']; ?>    devient desormais le client de spidernet
					</div>
			<?php
			} 
	    }*///END IF AFFECTERTYPECLIENT

	}//END IF SAVE CLIENT REUSSI
}



