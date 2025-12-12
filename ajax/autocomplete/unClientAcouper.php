<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");

	$client = new Client();
    $result = htmlspecialchars(trim($_POST['result']));

	if (!empty($result)) 
	{
		foreach ($client->getUnClientAcouper($result) as $value)
		{
			?>
		    <div class="item" idclient="<?php echo 'ID-'.$value->ID_client.'-'.$value->Nom_client.'-'.$value->type_client?>"><?php echo 'ID-'.$value->ID_client.'  '.$value->Nom_client.' '.strtoupper($value->type_client); ?>
		    </div>
			<?php
		}
	}
?>
 <script src="assets/javascript/autocomplate/unClientAcouper.js"></script>