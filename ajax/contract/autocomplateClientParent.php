<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");

	$client = new Client();
    $result = htmlspecialchars(trim($_GET['client']));

	if (!empty($result)) 
	{
		foreach ($client->autocompleteClientParentContract($result) as $value)
		{
			?>
		    <div class="item" idclient="<?php echo 'ID-'.$value->billing_number.'-'.$value->Nom_client.'_'.$value->ID_contract.'_'.$value->ID_client.'_'.$value->monnaie;?>"><?php echo 'ID-'.$value->billing_number.'-'.$value->Nom_client; ?>
		    </div>
			<?php
		}
	}
?>
 <script src="assets/javascript/contract/itemSelectedClient.js"></script>