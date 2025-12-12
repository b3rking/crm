<?php
require_once('model/comptabilite.class.php');
require_once('model/historique.class.php');
function inc_historique($type,$idAction)
{
	$comptabilite = new Comptabilite();
	$historique = new Historique();
	require_once('vue/admin/historique/historique.php');
}
function inc_historiques()
{
	$historique = new Historique();
	require_once('vue/admin/historique/historiques.php');
} 