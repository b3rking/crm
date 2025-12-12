 <?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php"); 

$comptabilite = new Comptabilite(); 

if ($comptabilite->ajouter_dette($_GET['dette'],$_GET['montant'],$_GET['monnaie'],$_GET['motif'],$_GET['datecreation']))  
{
	$id = $comptabilite->getMaxIddette()->fetch()['ID_dette'];
	if ($comptabilite->setHistoriqueAction($id,'dette',$_GET['userName'],date('Y-m-d'),'creer')) 
	{
		//require_once('repbanque.php'); 
	}
}
?>