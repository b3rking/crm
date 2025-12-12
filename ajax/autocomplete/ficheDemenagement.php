<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");

	$client = new Client();
    $result = htmlspecialchars(trim($_POST['result']));

	if (!empty($result)) 
	{
		foreach ($client->autocomplete($result) as $value)
		{
			?>
		    <div class="item" idclient="<?php echo 'ID-'.$value->ID_client.'-'.$value->Nom_client.'_'.$value->adresse?>"><?php echo 'ID-'.$value->billing_number.'  '.$value->Nom_client; ?>
		    </div>
			<?php
		}
	}
?>
 <script src="assets/javascript/autocomplate/ficheDemenagement.js"></script>