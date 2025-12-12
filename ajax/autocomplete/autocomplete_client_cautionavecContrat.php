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
		    
		     <div class="item" idclient="<?php echo 'ID-'.$value->ID_client.'-'.$value->Nom_client.'_'.$value->ID_contract.'_'.$value->billing_number ?>"><?php echo 'ID-'.$value->ID_client.'  '.$value->Nom_client; ?>
		    </div>
			<?php
		}
	}
?>
 <script src="assets/javascript/autocomplate/caution_client_avec_contract.js"></script>