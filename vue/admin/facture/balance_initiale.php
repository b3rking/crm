<?php
ob_start();
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
?>
<input type="text" id="userName" name="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                    <div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Creer la balance initiale</button>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouvelle balance initiale</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0">
                               <div class="row">
                                    <div class="col-lg-12 col-md-8">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-1 control-label">Client</label>
                                            <div class="form-group col-sm-9">
                                                <!--<input type="text" id="idclient_facture" class="form-control" autocomplete="off">
                                                <div id="modal"></div>-->
                                                
                                                <input type="text" id="seachCustomerInvoice<?=$i?>" class="form-control form-control-sm"  autocomplete="off"><br>
					                        	<select id="selectCustomerInvoice" class="form-control" size="3">
					                        		<?php
                                                    foreach ($client->getClientsToCreateBalanceInitiale() as $value1) 
                                                    {
		                        					?>
                                                        <option value="<?=$value1->ID_client?>">
                                                            <?=$value1->Nom_client.' -- code: '.$value1->billing_number?>
                                                        </option>
		                        					<?php
                                                    }
					                        		?>
					                        	</select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Montant</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" id="montant" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
                                            <div class="form-group col-sm-9">
                                                <select class="form-control" id="monnaie">
                                                    <?php
                                                    for ($i=0; $i < count($tbMonnaie); $i++) 
                                                    {
                                                    ?> 
                                                        <option value="<?=$tbMonnaie[$i]?>" selected=""><?=$tbMonnaie[$i]?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <input type="date" value="<?= date('Y-m-d')?>" class="form-control" id="date_creation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 form-group">
                                        <div class="col-lg-12 col-md-12 form-group">
                                            <textarea  class="form-control " id="description" placeholder="Description           ici..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                            <button type="button" class="btn btn-chocolate text-white waves-effect text-left" onclick="creerBallanceInitiale($('#selectCustomerInvoice').val(),$('#date_creation').val(),$('#montant').val(),$('#monnaie').val(),$('#description').val())">Creer
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!--<button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>Importer la balance</button>-->
        </div>
    </div>
</div>
                <div class="table-responsive m-t-0">
                    <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>CLIENT</th>
                                <th>MONTANT</th>
                                <th>DESCRIPTION</th>
                                <th>DATE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>CLIENT</th>
                                <th>MONTANT</th>
                                <th>DESCRIPTION</th>
                                <th>DATE</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i = 0;
                            foreach ($contract->getBalanceInitiales() as $value) 
                            {
                                $i++;
                            ?>
                                <tr>
                                    <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client.'-'.$value->billing_number;?></b></a></td>
                                    <td><?=$value->montant.'_'.$value->monnaie?></td>
                                    <td><?=$value->description?></td>
                                    <td><?=$value->date_creer?></td>
                                    <td>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg<?=$i?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modifier la balance initiale</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="row">
                                        <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client</label>
                                          <div class="form-group col-sm-9 col-lg-10">
                                             <input type="text" name="idbalance<?=$i?>" id="idbalance<?=$i?>" value="<?=$value->id?>" hidden>
                                            <input type="text" class="form-control form-control-sm" value="<?=$value->nom_client?>" disabled>
                                            <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Montant</label>
                                        <div class="form-group col-sm-9">
                                            <input type="number" id="montant<?=$i?>" class="form-control form-control-sm" value="<?=$value->montant?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
                                        <div class="form-group col-sm-9">
                                            <select class="form-control form-control-sm" id="monnaie<?=$i?>">
                                            <?php
                                                for ($v=0; $v < count($tbMonnaie); $v++) 
                                                { 
                                                    if ($tbMonnaie[$v] == $value->monnaie)
                                                    {
                                                ?>
                                                        <option value="<?php echo $tbMonnaie[$v];?>" selected><?php echo $tbMonnaie[$v];?></option>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <option value="<?php echo $tbMonnaie[$v];?>"><?php echo $tbMonnaie[$v];?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                                        <div class="form-group col-sm-9">
                                            <input type="date" value="<?= $value->date_creer?>" class="form-control form-control-sm" id="datebalance<?=$i?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 form-group">
                                            <textarea  class="form-control form-control-sm" id="description<?=$i?>"><?=$value->description?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-chocolate text-white waves-effect text-left" onclick="updateBallanceInitiale($('#idbalance<?=$i?>').val(),$('#idclient<?=$i?>').val(),$('#montant<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#datebalance<?=$i?>').val(),$('#description<?=$i?>').val())">Modifier
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            

            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Suppression de ballance</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer cette </br> information ?
                            <input type="text" id="idDelete<?=$i?>" value="<?= $value->id?>" hidden>
                            <input type="text" id="idclientdel<?=$i?>" value="<?=$value->ID_client?>" hidden>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger waves-effect text-left" onclick="deleteBallance($('#idDelete<?=$i?>').val(),$('#idclientdel<?=$i?>'))" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
                                    </td>
                                </tr>
                            </form>
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

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>