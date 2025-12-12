<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");

	$client = new Client();
    $result = htmlspecialchars(trim($_GET['client']));

	if (!empty($result)) 
	{
		foreach ($client->autocomplete($result) as $value)
		{
			?>
		    <div class="item" idclient="<?php echo 'ID-'.$value->ID_client.'-'.$value->Nom_client ?>"><?php echo 'ID-'.$value->ID_client.'  '.$value->Nom_client; ?>
		    </div>
			<?php
		}
	}
?>
 <script src="assets/javascript/autocomplate/autocomplete_filtre_contrat.js"></script>