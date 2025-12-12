<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");

	$client = new Client();
    $result = htmlspecialchars(trim($_POST['result']));

	if (!empty($result)) {
		foreach ($client->autocompleteClientTicket($result) as $value)
		{
			?>
		    <div class="item" idclient="<?php echo 'ID-'.$value->ID_client.'-'.$value->Nom_client.'_'.$value->nomService ?>"><?php echo 'ID-'.$value->ID_client.'  '.$value->Nom_client; ?>
		    </div>
			<?php
		}
	}
?>
 <script src="assets/javascript/autocomplate/itemSelectedCreerTicket.js"></script>