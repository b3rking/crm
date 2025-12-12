
<?php
require_once("../../model/connection.php");
require_once("../../model/marketing.class.php");


$marketing = new Marketing();

if ($marketing->uptadateEtatprospect($_GET['idprospect'],"attente")) 
{
} 
	
