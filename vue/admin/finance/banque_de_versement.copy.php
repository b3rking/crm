<?php
ob_start();
?>

<input type="text" id="iduser_verser"  value="<?php echo $_SESSION['ID_user']?>" name="iduser_verser" hidden>
<input type="text" id="userName" name="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
            </ol>
            <!--<a href="<= WEBROOT;?>versementouvert" class="btn btn-primary d-none d-lg-block m-l-15"><i class="fa fa-file"></i> Verssement non cloture</a>-->
            <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target="#myModal-add-versement"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Ajouter un versement</button>
            <!-- sample modal content -->
<div id="myModal-add-versement" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Verssement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal p-t-0" action="<?=WEBROOT?>saveVersement" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 control-label">Caisse*</label>
                          <div class="col-sm-9">
                            <select class="form-control" id="caisse" name="banque">
                                <?php 
                                foreach ($comptabilite->getGrandeCaisses() as $data)
                                {?>
                                    <option value="<?php echo $data->ID_caisse."-".$data->montantCaisse."-".$data->devise?>"><?php echo $data->nomCaisse . "_" . $data->devise?>
                                    </option>
                                <?php
                                }?>
                            </select>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <!--<div class="col-lg-10 col-md-10">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Destination</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <select class="form-control" id="destination" name="destination" onchange="recevoir_destination($(this).val())">
                                      <option></option>
                                      <option value="caisse">Caisse</option>
                                      <option value="banque">Banque</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Montant*</label>
                            <div class="col-sm-9">
                             <input type="text" class="form-control"  id="montant" name="reference">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12" id="conteneur_destination"></div>
                </div>
                <!--<div class="row">
                    <div class="col-lg-10 col-md-10">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
                            <div class="col-sm-9">
                                    <select class="form-control" id="idbanque">
                                <php
                                foreach ($comptabilite->affichageBanque() as $data)
                                {?>
                                <option value="<php echo $data->ID_banque.'-'.$data->monnaie?>"><php echo $data->nom . '      -     ' . $data->monnaie?></option>
                                <php
                                }
                                ?> 
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 control-label">Banque*</label>
                          <div class="col-sm-9">
                            <select class="form-control" id="banque" name="banque">
                                <?php 
                                foreach ($comptabilite->getBanqqueActive() as $data)
                                {?>
                                    <option value="<?php echo $data->ID_banque."-".$data->montant."-".$data->monnaie."-".$data->nom?>"><?php echo $data->nom . "_" . $data->monnaie?>
                                    </option>
                                <?php
                                }?>
                            </select>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Reference*</label>
                            <div class="col-sm-9">
                             <input type="text" class="form-control" id="reference" name="reference">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date versement*</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" value="<?=date('Y-m-d')?>" name="dateversement" id="dateversement">
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn"> Paiement </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span ></span></div>
                                    <php 
                                    $i = 0;
                                    foreach($comptabilite->afficherPaiementNonVerser() as $value)
                                    {
                                        $i++;
                                    ?>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<=$value->ID_paiement.'_'.$value->montant.'_'.$value->devise?>" name="paiement[<?=$i?>]" id="paiement<?=$i?>">
                                        <label class="custom-control-label" for="paiement<?=$i?>"><php echo $value->datepaiement.'_'.$value->Nom_client.'_'.$value->montant.'_'.$value->devise?></label>
                                    </div>
                                    <php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal" onclick="setVerssement($('#caisse').val(),$('#montant').val(),$('#banque').val(),$('#reference').val(),$('#dateversement').val())"> <i class="fa fa-check"></i>cree caisse</button>

                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

        <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-lock"></i> Cloturer</button>
                
        <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lgs">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Cloture du versement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        En cloturant les verssement, aucune action ne pourant etre effectuee apres!
                    </div>
                    <div class="modal-footer">
                        <span id="afficheMontant"></span>
                        <button type="button" style="background-color: #7c4a2f" onclick="cloturerVersement()"  class="btn text-white waves-effect text-left">
                            <i class="fa fa-lock"></i> Cloturer
                        </button>
                        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div id="retour"></div>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Banque</th>
                                <th>Montant</th>
                                 <th>Etat</th>
                                <!--<th>Paiement lié</th>-->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Banque</th>
                                <th>Montant</th>
                                <th>Etat</th>
                                <!--<th>Paiement lié</th>-->
                                <th>Action</th>
                                
                            </tr>
                        </tfoot> 
                        <tbody id="rep">
                            <?php
                            $resultat = array();
                            $i =0;
                            $j = 0;
                            foreach ($comptabilite->getVersements() as $value) 
                            {
                                $i++; 
                            ?>
                                <tr>
                                <td><?php echo $value->dateversement?></td>
                                <td><?php echo $value->reference?></td>
                                <td><?php
                                echo $value->nom;
                                /*if($value->destination == 'banque')
                                {
                                    echo $comptabilite->getBanqueDunVersement($value->ID_versement)->fetch()['nom'];
                                }
                                else
                                {
                                    echo $comptabilite->getCaisseDunVersement($value->ID_versement)->fetch()['nomCaisse'];
                                }*/
                                ?></td>
                                <td><?php echo number_format($value->montant).' '.$value->monnaie_verser?></td>
                                <td><?php
                                if ($value->etat == 1) 
                                {
                                    echo 'Fermer';
                                }
                                else echo "En attente";
                                ?></td>
                                <!--<td>
                                <php 
                                $res = $comptabilite->getNombre_paiement_par_versement($value->ID_versement)->fetch();
                                echo $res['nbPaiement'].' paiements';
                                ?> 
                                </td>-->
                    <td class="text-nowrap">
                    <!--<a href="<=WEBROOT;?>printVersement-<?=$value->ID_versement?>" data-toggle="tooltip" data-original-title="Voir"><i class="mdi mdi-printer"></i></a>-->

                    <!--<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                    </a>-->
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lgs<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lgs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modification de versement</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                              <label for="exampleInputuname3" class="col-sm-3 control-label">Banque*</label>
                                              <div class="col-sm-9">
                                                <input type="text" id="idversement<?=$i?>" value="<?php echo $value->ID_versement.'-'.$value->monnaie_verser?>" hidden>
                                                <input type="text" id="etat<?=$i?>" value="<?=$value->etat?>">

                                                <select class="form-control" id="banque" name="banque">
                                    <?php 
                                    foreach ($comptabilite->getBanqqueActive() as $data)
                                    {
                                        if ($value->ID_banque == $data->ID_banque) 
                                        {
                                    ?>
                                            <option value="<?php echo $data->ID_banque."-".$data->montant."-".$data->monnaie."-".$data->nom?>" selected><?php echo $data->nom . "_" . $data->monnaie?>
                                        </option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?php echo $data->ID_banque."-".$data->montant."-".$data->monnaie."-".$data->nom?>"><?php echo $data->nom . "_" . $data->monnaie?>
                                        </option>
                                    <?php
                                        }
                                    }?>
                                                </select>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                          <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Reference</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control"  id="reference<?=$i?>" value="<?=$value->reference?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date versement</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" value="<?=$value->dateversement?>" id="dateversement<?=$i?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal"onclick="modifierVersement($('#idversement<?=$i?>').val(),$('#reference<?=$i?>').val(),$('#dateversement<?=$i?>').val(),$('#ancien_montant<?=$i?>').val(),$('#destination<?=$i?>').val(),$('#iddestination<?=$i?>').val())"> <i class="fa fa-check"></i>modifier</button>
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce versement</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="idversement_del<?=$i?>" value="<?=$value->ID_versement?>" hidden>
                            Voulez-vous supprimer ce versement?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteVerssement($('#idversement_del<?=$i?>').val(),$('#etat<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
                        }?>
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