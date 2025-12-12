<?php
ob_start();
?>

<div class="card">
    <div class="card-body">
    	<h4 class="m-b-0">Etat stock</h4>
        
        <!--<h6 class="card-subtitle">Add class <code>.color-table .success-table</code></h6>-->
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Fabriquant</th>
                        <th>Equipement</th>
                        <th>Numero Serie</th>
                        <th>Mac</th>
                        <th>Usage</th>
                        <th>Creation</th>
                    </tr>
                </thead>
                <tfoot>
                	<tr>
                        <th>Model</th>
                        <th>Fabriquant</th>
                        <th>Equipement</th>
                        <th>Numero Serie</th>
                        <th>Mac</th>
                        <th>Usage</th>
                        <th>Creation</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach($equipement->recupererEquipements() as $value)
                    {
                    ?>
                       <tr>
                            <td><?=$value->model?></td>
                            <td><?=$value->fabriquant?></td>
                            <td><?=$value->type_equipement?></td>         
                            <td><?=$value->numeroSerie?></td>
                            <td>
                            	<?php
                            		foreach ($equipement->recupereMacAdresses($value->ID_equipement) as $mac) 
                            		{
                            			echo "$mac->mac <br>";
                            		}
                            	?>
                            </td>
                            <td><?=$value->usage_switch?></td>
                            <td><?=$value->date_stock?></td>                      
                        </tr>
                    <?php
                    }
                    ?>                  
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>