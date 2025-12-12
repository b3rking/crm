
<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");


	/*$contract = new Contract();
    if ($contract->updatefichierClient($_GET['numerofichier'],$_GET['nom_fichier'],$_GET['fichier_doc'])) 
	{
		require_once('repfichier.php');
	}*/
	//echo "idfichier= ".$_POST['idfichier']." nom_fichier= ".$_POST['nom_fichier']." fichier= ".$_POST['fichier'];
	//$currentDir = getcwd();
	$currentDir = $_POST['root'];
	$uploadDirectory = "/fichier_attacher/";
	$fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions
	//$fileName = $_FILES['fichier']['name'];
	$fileSize = $_FILES['fichier']['size'];
	$fileTmpName = $_FILES['fichier']['tmp_name'];
	$fileType = $_FILES['fichier']['type'];
	$extension = explode('/', $fileType);
	//$new_name = $_POST['nom'].'.'.$extension[1];
	//$fileExtension = strtolower(end(explode('.',$fileName)));
	$uploadPath = $currentDir . $uploadDirectory . $_POST['nom_fichier'].'.'.$extension[1];
	$fileName = $_POST['nom_fichier'].'.'.$extension[1];
	  
	if ($fileType != 'image/jpg' AND $fileType != 'image/jpeg' AND $fileType != 'image/png') 
	{
		$errors[] = "Ce fichier n'est supporté! Veuillez choisir l'extension JPEG ou PNG";
	}
	if ($fileSize > 2000000) 
	{
	    $errors[] = "Ce fichier depasse 2MB";
	}
	if (empty($errors)) 
	{
		$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
	    //creerfichier_client($_POST['idclientOnContract'],$_POST['nom'],$fileTmpName,$uploadPath,$fileName);
	}
?>