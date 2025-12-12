<?php
require_once("../../model/connection.php");
require_once("../../model/client.class.php");

$client = new Client();

//echo $_GET['webroot'].'fichier_attacher/'.$_GET['fileName'];
if (unlink($_GET['root'].'uploads/customer_file/file/'.$_GET['idfichier'].'/'.$_GET['fileName'])) 
{
	if (rmdir($_GET['root'].'uploads/customer_file/file/'.$_GET['idfichier'])) 
	{
		if ($client->deleteFichierAttacher($_GET['idfichier'])) 
		{
			//echo "ok";
		}
	}
}
