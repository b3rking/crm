<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

$data = $comptabilite->getMontantPaiementVerser($_GET['idbank'],$_GET['datepaiement'])->fetch();
echo "Le montant total = ".$data['montant'];