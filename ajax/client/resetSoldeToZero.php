<?php

require_once("/var/www/crm.buja/model/connection.php");
require_once("/var/www/crm.buja/model/client.class.php");



$client = new Client();

$client->resetSoldeToZero();