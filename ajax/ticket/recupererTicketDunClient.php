<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");

$ticket = new ticket();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h6 class="m-b-0 text-white">Information sur les tickets</h6>
            </div>
            <div class="card-body">
            	<div class="table-responsive">
		            <table id="myTable" class="table table-bordered table-striped">
		                <thead>
		                    <tr>
		                        <th>TICKET</th>
		                        <th>CREATION</th>
		                        <th>DESCRIPTION</th>
		                        <th>TECHNICIEN EN CHARGE</th>
		                        <th>STATUS</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>TICKET</th>
		                        <th>CREATION</th>
		                        <th>DESCRIPTION</th>
		                        <th>TECHNICIEN EN CHARGE</th>
		                        <th>STATUS</th>
		                    </tr>
		                </tfoot>
		                <tbody>
		                    <?php 
		                	foreach($ticket->recupererTousTicketDunClient($_GET['idclient']) as $value)
		                	{
		                	?>
		                    <tr>
		                        <td><?php echo $value->ID_ticket?></td>
		                        <td><?php echo $value->date_description?></td>
		                        <td><?php echo $value->corp_ticket?></td>
		                        <td><?php echo $value->nom_user?></td>
		                        <td>
		                        	<?php if($value->statut=='ouvert')
                                {
                                    ?>
                                    <span class="label label-danger"><?php echo $value->statut?></span>
                                    <?php
                                }
                                elseif($value->statut == 'fermer') 
                                {?>
                                    <span class="label label-success"> <?php echo $value->statut?></span>
                                <?php   
                                }
                                ?>
		                        </td>
		                    </tr>
		                    <?php
		                	}
		                    ?>
		                </tbody>
		            </table>
		        </div>
            </div>
        </div>
    </div>
</div>