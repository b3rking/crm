<?php
ob_start();
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" id="responsive">
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>TICKET</th>
                                <th>CLIENT</th>
                                <th>CREATION</th>
                                <th>TYPE</th>
                                <th>PROBLEME</th>
                                <th>CONNEXION</th>
                                <th>ETAT</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>TICKET</th>
                                <th>CLIENT</th>
                                <th>CREATION</th>
                                <th>TYPE</th>
                                <th>PROBLEME</th>
                                <th>CONNEXION</th>
                                <th>ETAT</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i =0;
                            foreach ($ticket->recupereTousTicketParStatut($statut) as $value) 
                            {
                                $i++;
                                ?>
                            <tr>
                                <td>
                                    <?php echo $value->ID_ticket;?>
                                </td>
                                <td>
                                    <a href="<?=WEBROOT;?>detailClient-<?= $value->ID_client;?>"><?=$value->Nom_client?></a>
                                </td>
                                <td><?php echo $value->date_description?></td>
                                <td><?php echo $value->type_ticket?></td>
                                <td><?php echo $value->corp_ticket?></td>
                                <td><?php echo $value->type_connection?></td>
                                <td><?php if($value->statut=='ouvert')
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
                            ?><!-- END FOREACH-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
    /*if ($_SESSION['role'] == 'commercial') 
    {
        $home_commercial_content = ob_get_clean();
        require_once('vue/admin/home.commercial.php');
    }
    elseif ($_SESSION['role'] == 'admin') 
    {
        $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
    }*/
?>
