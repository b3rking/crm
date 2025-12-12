<?php
ob_start();

if(isset($_POST["export"])) 
{
    //Define the filename with current date
    $fileName = "liste-des-$libelle[$action]s-".date('d-m-Y').".xls";

    //Set header information to export data in excel format
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$fileName);

    //Add the MySQL table data to excel file
    if(!empty($result)) 
    {
        echo implode("\t", ["ID","NOM","OBSERVATION"]) . "\n";
        foreach($result as $item) 
        {
            echo implode("\t", [$item->billing_number,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $item->nom_client),$item->comment]) . "\n";
        }
    }
    $fileName = "liste-des-clients-actifs-juillet-".date('Y').".xls";

    //Set header information to export data in excel format
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$fileName);

    //Add the MySQL table data to excel file
    /*if(!empty($result)) 
    {
        $total_usd = 0;
        $total_bif = 0;
        /*echo implode("\t", ["ID","NOM","MENSUALITE","MONNAIE","JANVIER","FEVRIER","MARS","AVRIL","MAI","JUIN","JUILLET","AOUT","SEPTEMBRE","OCTOBRE","NOVEMBRE","DECEMBRE"]) . "\n";*
        echo implode("\t", ["ID","NOM","MENSUALITE","JUILLET","AOUT","SEPTEMBRE","OCTOBRE","NOVEMBRE","DECEMBRE"]) . "\n";
        foreach($result as $item) 
        {
            //$prixTva = $item->montant*18/100;
            $total_bif += $item->monnaie == 'BIF' ? $item->montant:$item->montant*2000;
            //$total_usd += $item->monnaie == 'USD' ? $item->montant*2000:0;
            $montant = $item->monnaie == 'BIF' ? $item->montant:$item->montant*2000;
            
            echo implode("\t", [$item->billing_number,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $item->nom_client),round($montant),"","","","","",""]) . "\n";
        }
        echo implode("\t", ["TOTAL BIF","",round($total_bif),"","","","","",""]) . "\n";
        //echo implode("\t", ["TOTAL USD",round($total_usd),"","","","","","",""]) . "\n";
    }*/
    exit();
}
?>
<div class="row page-titles"><div class="col-md-5 align-self-center"></div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center"><!--<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Fac</a></li>
                <li class="breadcrumb-item active">pro forma</li>
            </ol>-->
            <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle"></i> Ajouter un client a la liste</button>

            <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lgs">
                    <div class="modal-content">
                        <div class="modal-header text-white">
                            <h4 class="modal-title" id="myLargeModalLabel">Coupure d'un client</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0" id="form-creerDerogation">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client* </label>
                                            <div class="col-sm-9 col-lg-10">
                                                    <!--<input type="text" class="form-control" name="client" id="clientAcouper">
                                                    <input type="text" name="idclient" id="idclient" hidden="">
                                                    <input type="text" name="type_client" id="type_client" hidden="">
                                                    <div id="modal"></div>-->
                                                <input type="text" id="seachCustomerToAddToList" class="form-control form-control-sm" autocomplete="off">
                                                <select id="selectCustomerToAddToList" class="form-control" size="3">
                                                    <?php
                                                        foreach ($client->getClientActifs() as $value) 
                                                        {
                                                    ?>
                                                            <option value="<?=$value->ID_client?>">
                                                                <?=$value->Nom_client.' -- code: '.$value->billing_number?>
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
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Action* </label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select class="form-control" id="action">
                                                        <option value="couper">Couper</option>
                                                        <option value="recouvrer">Recouvrer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Observation </label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <textarea class="form-control" id="observation"></textarea>
                                                    <input type="text" id="idUser" value="<=$_SESSION['ID_user']?>" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  onclick="ajouterClientAuListeDeCoupure($('#selectCustomerToAddToList').val(),$('#action').val(),$('#observation').val(),$('#idUser').val())"  class="btn btn-chocolate waves-effect text-left text-white">Ajouter
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" onclick="print_coupure_action()"><i class="mdi mdi-printer"></i> Generer pdf</button>

            <form action="#" method="post">
               <button type="submit" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" name="export"><i class="mdi mdi-printer"></i> Exporter vers excel</button> 
            </form>
            

            <form class="form-horizontal p-t-20" method="post" action="<?=WEBROOT?>print_coupure_action" id="print_coupure_action">
                <input type="text" name="action" value="<?=$action?>" hidden>
                <input type="text" name="coupure_id" id="cutoff_id" value="<?=$cutoff_id?>" hidden>
                <input type="text" name="mois" value="<?=$mois?>" hidden>
                <input type="text" name="annee" value="<?=$annee?>" hidden>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <a href="<?=WEBROOT?>coupure">Retour</a>
                <div class="table-responsive m-t-0">
<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID CLIENT</th>
            <th>CLIENT</th>
            <th>MONTANT</th>
            <th>ACTION</th>
            <th>OBSERVATION</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID CLIENT</th>
            <th>CLIENT</th>
            <th>MONTANT</th>
            <th>ACTION</th>
            <th>OBSERVATION</th>
            <th>ACTIONS</th>
        </tr>
    </tfoot>
    <tbody id="rep">
        <?php
        $i = 0;
        foreach ($result as $value) 
        {
            $i++;
        ?>
            <tr>
                <td><?=$value->billing_number?></td>
                <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client;?></b></a></td>
                <td><?php
                //$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
                echo $value->owed_amount.' '.$value->currency;
                ?></td>
                <td><?=$value->action?></td>
                <td><?=$value->comment?></td>
                <td>
                    <!--<button type="button" class="btn text-white waves-effect text-left" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" style="background-color: chocolate"><i class="ti-pencil"></i>
                    </button>-->
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Modifier action</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                    <form class="form-horizontal p-t-20">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group row">
                                    <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Action </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select class="form-control" id="action<?=$i?>" onchange="//checkActionCoupure($(this).val(),'<?= $value->id?>','<?=$i?>')">
                                                <?php
                                                if ($value->action == 'couper') 
                                                {
                                                ?>
                                                    <option value="couper" selected="">
                                                    couper
                                                    </option>
                                                    <option value="recouvrer">
                                                        recouvrer
                                                    </option>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                    <option value="couper">
                                                    couper
                                                    </option>
                                                    <option value="recouvrer" selected="">
                                                        recouvrer
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="motif_contener<?=$i?>" hidden>
                            <?php
                            if ($value->action == 'couper') 
                            {
                            ?>
                                <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Motif </label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="form-control" id="motif<?=$i?>">
                                                    <?php
                                                    if ($value->motif == 'dette') 
                                                    {
                                                    ?>
                                                        <option value="dette" selected="">
                                                        Dette
                                                        </option>
                                                        <option value="partie">
                                                            Partie
                                                        </option>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <option value="dette">
                                                        Dette
                                                        </option>
                                                        <option value="partie" selected="">
                                                            Partie
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            else
                            {
                            ?>
                                <input type="text" id="motif<?=$i?>" value="derogation" hidden>
                            <?php
                            }
                            ?>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group row">
                                    <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Observation </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <textarea class="form-control" id="observation<?=$i?>"> <?php echo $value->comment?></textarea>

                                            <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>" hidden>
                                            <!--<input type="text" id="mois<=$i?>" value="<=$mois?>" hidden>
                                            <input type="text" id="annee<=$i?>" value="<=$annee?>" hidden>-->
                                            <input type="text" id="i<?=$i?>" value="<?=$i?>" hidden>
                                            <input type="text" id="coupure_id<?=$i?>" value="<?=$value->id?>" hidden>
                                            <!--<input type="text" name="type_client<=$i?>" id="type_client<=$i?>" value="<=$value->typeclient?>" hidden>
                                            <input type="text" id="date_creation<=$i?>" value="<=$value->date_creation?>" hidden>
                                            <input type="text" id="old_action<=$i?>" value="<=$value->action?>" hidden>
                                            <input type="text" id="old_motif<=$i?>" value="<=$value->motif?>" hidden>-->
                                            <input type="text" id="montant_du<?=$i?>" value="<?=$value->owed_amount?>" hidden>
                                            <input type="text" id="monnaie<?=$i?>" value="<?=$value->currency?>" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden="">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group row">
                                    <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Date </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="newDate<?=$i?>" value="<?=$value->date_creation?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="factureContener<?=$i?>">
                            <div></div>
                        </div>
                    </form>
                </div>
        <div class="modal-footer">
            <span id="msg<?=$i?>"></span>
             <button type="button" class="btn btn-chocolate text-white"  onclick="updateCoupure($('#action<?=$i?>').val(),$('#observation<?=$i?>').val(),$('#idclient<?=$i?>').val(),$('#i<?=$i?>').val(),$('#coupure_id<?=$i?>').val(),$('#montant_du<?=$i?>').val(),$('#monnaie<?=$i?>').val())" class="btn waves-effect text-left text-white">Modifier
                    </button>
            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

                    <!--<button type="button"  onclick="genererListeFactureNoPayer($('#dateGenerer').val())"  class="btn text-white waves-effect text-left" style="background-color: chocolate"><i class="ti-trash"></i>
                    </button>-->
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

                       <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Suppression de l'action </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" id="del_coupure_id<?=$i?>" value="<?=$value->id?>" hidden>
                            <input type="text" id="del_idclient<?=$i?>" value="<?=$value->ID_client?>" hidden>
                            <input type="text" id="type_client_del<?=$i?>" value="<?=$value->typeclient?>" hidden>
                            <input type="text" id="del_mois<?=$i?>" value="<?=$mois?>" hidden>
                            <input type="text" id="del_annee<?=$i?>" value="<?=$annee?>" hidden>
                            Voulez-vous supprimer cette action à ce client?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteCoupureAction($('#del_coupure_id<?= $i?>').val(),$('#del_idclient<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
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

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>