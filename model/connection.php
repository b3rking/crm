<?php
function connection()
{
	try{

		$bdd= new PDO('mysql:host=localhost;dbname=spi_buja;charset=utf8',"root","");
		return $bdd;
	}
	catch(Exception $e)
	{
		echo 'erreur trouver '.$e->getMessage();
	}
}