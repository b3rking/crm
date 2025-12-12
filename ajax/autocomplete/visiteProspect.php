<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");

	$prospect = new Marketing();
    $result = htmlspecialchars(trim($_POST['result']));

	if (!empty($result)) 
	{
		foreach ($prospect->autocompleteVisiteProspect($result) as $value)
		{
			?>
		    <div class="item" idclient="<?php echo 'ID-'.$value->ID_prospect.'-'.$value->nom ?>"><?php echo 'ID-'.$value->ID_prospect.'  '.$value->nom; ?>
		    </div>
			<?php
		}
	}
?>
<script src="assets/javascript/autocomplate/visiterProspect.js"></script>