<?php
function connection()
{
	try{

		$bdd= new PDO('mysql:host=localhost;dbname=spi_buja;charset=utf8',"admin","202@5+sp100");
		return $bdd;
	}
	catch(Exception $e)
	{
		echo 'erreur trouver '.$e->getMessage();
	}
}
