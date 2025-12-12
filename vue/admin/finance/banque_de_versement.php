<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('paiement',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['L'] == 1) 
    {
        $l = true;
    }
    if ($d['C'] == 1) 
    {
        $c = true;
    }
    if ($d['M'] == 1) 
    {
        $m = true;
    }
    if ($d['S'] == 1) 
    {
        $s = true;
    }
}
?>

<div class="row page-titles">
    <input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
    <input type="text" id="l" value="<?=$l?>" hidden>
    <input type="text" id="c" value="<?=$c?>" hidden>
    <input type="text" id="m" value="<?=$m?>" hidden>
    <input type="text" id="s" value="<?=$s?>" hidden>
    <input type="text" id="iduser"  value="<?=$_SESSION['ID_user']?>" name="iduser_verser" hidden>
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
            </ol>
            <!--<a href="<= WEBROOT;?>versementouvert" class="btn btn-primary d-none d-lg-block m-l-15"><i class="fa fa-file"></i> Verssement non cloture</a>-->
            <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer versement</button>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau versement</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form class="form-horizontal p-t-0" id="saveVersementForm" action="<?=WEBROOT?>saveVersement" method="post">
                            <div class="modal-body">
                                <!--<div class="row">
                                    <div class="col-lg-10 col-md-10">
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
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div class="col-lg-10 col-md-10">
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
                                    <div class="col-lg-10 col-md-10" id="conteneur_destination"></div>
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
                                <div class="col-lg-10 col-md-10">
                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Reference*</label>
                                        <div class="col-sm-9">
                                         <input type="text" class="form-control"  id="reference" name="reference">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-md-10">
                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Date versement</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" value="<?=date('Y-m-d')?>" name="dateversement" id="dateversement">
                                            <input type="text" id="userName" name="userName" value="<?=$_SESSION['userName']?>" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn"> Paiement </label>
                                    <div class="col-sm-9" id="checkbox-parent">
                                        <?php 
                                        $i = 0;
                                        foreach($comptabilite->afficherPaiementNonVerser() as $value)
                                        {
                                            $i++;
                                        ?>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="<?=$value->ID_paiement.'_'.$value->montant.'_'.$value->devise?>" name="paiement[<?=$i?>]" id="paiement<?=$i?>">
                                            <label class="custom-control-label" for="paiement<?=$i?>"><?= $value->datepaiement.'_'.$value->Nom_client.'_'.$value->montant.'_'.$value->devise?></label>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <input type="text" name="montant_total" id="montant_total" hidden="">
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                            <button type="button" class="btn btn-success" onclick="versementArgent($('#banque').val(),$('#reference').val(),$('#dateversement').val(),$('#iduser_verser').val())"> <i class="fa fa-check"></i>Ajouter</button>
                            <!--<button type="submit" style="background-color: #7c4a2f" class="btn text-white"> <i class="fa fa-check"></i>Ajouter</button>-->
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!--/.modal-dialog -->
            </div>
            <!--/.modal-->
            
            <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg-ajpout-payement"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Ajouter payement au versement</button>

            <div class="modal fade bs-example-modal-lg-ajpout-payement" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lgs">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Ajout de payement à un versement</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form class="form-horizontal p-t-0" id="addPayementToVerssementForm" action="<?=WEBROOT?>addPayementToVerssement" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">ID versement</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="add_verssement_id" id="add_verssement_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            
                                            <div class="col-sm-9 col-md-11 col-lg-11" id="checkbox-parent">
                                                <?php 
                                                $i = 0;
                                                foreach($comptabilite->afficherPaiementNonVerser() as $value)
                                                {
                                                    $i++;
                                                ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" value="<?=$value->ID_paiement.'_'.$value->montant.'_'.$value->devise?>" name="paiement[<?=$i?>]" id="paiement_ajout<?=$i?>" onclick="getSelectedPayementToAddOnVerssement(this)">
                                                    <label class="custom-control-label" for="paiement_ajout<?=$i?>"><?= $value->datepaiement.'_'.$value->Nom_client.'_'.$value->montant.'_'.$value->devise?></label>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <span id="afficheMontant"></span>
                                <button type="button" style="background-color: #7c4a2f" onclick="addPayementToVerssement($('#add_verssement_id').val())"  class="btn text-white waves-effect text-left">
                                    <i class="fa fa-lock"></i> Ajouter
                                </button>
                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                            </div>
                    </form>
                    </div>
                </div>
            </div>

        <!--<button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-lock"></i> Cloturer</button>-->
                
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
                <?php
                if (isset($_SESSION['message']) && !empty($_SESSION['message'])) 
                {
                ?>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                        <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Warning</h3>
                        <?=$_SESSION['message']?> 
                    </div>
                <?php
                }
                ?>
                
                <!-- FILTRE -->
                <form action="<?=WEBROOT?>filtreVerssement" method="get" id="filtreVerssement">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <select class="form-control form-control-sm input-filter" id="banque_filtre" name="banque">
                                    <option value="">banque</option>
                                    <?php 
                                    foreach ($comptabilite->getBanqqueActive() as $data)
                                    {?>
                                        <option value="<?=$data->ID_banque?>"><?php echo $data->nom . " - " . $data->monnaie?>
                                        </option>
                                    <?php
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                            <input type="date" name="date1" id="date1" class="form-control form-control-sm input-filter">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                            <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                            <input type="text" name="reference" id="reference" placeholder="Reference" class="form-control form-control-sm input-filter">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <!--<button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreVerssement($('#banque_filtre').val(),$('#date1').val(),$('#date2').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
                            <button type="submit" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreVerssement()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Annuler</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive m-t-0">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID verssement</th>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Banque</th>
                                <th>Montant</th>
                                <th>Paiement lié</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID verssement</th>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Banque</th>
                                <th>Montant</th>
                                <th>Paiement lié</th>
                                <th>Action</th>
                                
                            </tr>
                        </tfoot> 
                        <tbody id="rep">
                            <?php
                            $resultat = array();
                            $i =0;
                            $j = 0;
                            foreach ($result as $value) 
                            {
                                $i++; 
                            ?>
                                <tr>
                                    <td><?=$value->id?></td>
                                <td><?php echo $value->date_operation?></td>
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
                                <td><?php echo number_format($value->debit).' '.$value->monnaie?></td>
                                <td>
                                    <?php 
                                    $res = $comptabilite->getNombre_paiement_par_versement($value->id)->fetch();
                                    echo $res['nbPaiement'].' paiements';
                                    ?> 
                                </td>
                    <td class="text-nowrap">
                    <a href="<?=WEBROOT;?>printVersement-<?=$value->id?>" data-toggle="tooltip" data-original-title="Voir"><i class="mdi mdi-printer"></i></a>

                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                    </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lgs<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lgs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modification de versement</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form class="form-horizontal p-t-20" method="post" action="<?=WEBROOT?>updateVerssement" id="updateVerssementForm<?=$i?>">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <input type="text" id="idversement<?=$i?>" name="idverssement" value="<?= $value->id?>" hidden>
                                            <input type="text" id="monnaieVerssement<?=$i?>" name="monnaieVerssement" value="<?=$value->monnaie?>" hidden>
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="iddestination<?=$i?>" name="banque">
                                                    <?php 
                                            foreach ($comptabilite->getBanqqueActive() as $data)
                                            {
                                                if ($data->ID_banque == $value->ID_banque) 
                                                {
                                            ?>
                                                    <option value="<?= $data->ID_banque."_".$data->montant."_".$data->monnaie."_".$data->nom?>" selected><?php echo $data->nom . "_" . $data->monnaie?>
                                                    </option>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                    <option value="<?php echo $data->ID_banque."_".$data->montant."_".$data->monnaie."_".$data->nom?>"><?php echo $data->nom . "_" . $data->monnaie?>
                                                    </option>
                                            <?php
                                                }
                                            }?>
                                                </select>
                                                <!--<input type="text" name="iddestination<=$i?>" id="iddestination<=$i?>" value="<=$comptabilite->getBanqueDunVersement($value->ID_versement)->fetch()['ID_banque']?>" hidden>
                                                <input type="text" class="form-control" value="<=$comptabilite->getBanqueDunVersement($value->ID_versement)->fetch()['nom']?>">-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                          <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Reference</label>
                                            <div class="col-sm-9">
                                              <input type="text" class="form-control"  id="reference<?=$i?>" name="reference" value="<?=$value->reference?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date versement</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" value="<?=$value->date_operation?>" id="dateversement<?=$i?>" name="dateversement">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-sm-9 col-md-11 col-lg-11" id="checkbox-parent">
                                                <?php
                                                foreach($comptabilite->getPaiements_attacher_a_un_versement($value->id) as $value2)
                                                {
                                                    $j++;
                                                ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input <?=$value->id?>" value="<?=$value2->ID_paiement.'_'.$value2->montant.'_'.$value2->devise?>" id="update_pymt<?=$j?>" name="payement[<?=$j?>]" checked onclick="verifierSiPayementDecocher(this.id)">
                                                    <label class="custom-control-label" for="update_pymt<?=$j?>"><?php echo $value2->datepaiement.$value2->nom_client.'_'.$value2->montant.'_'.$value2->devise?></label>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <input type="text" name="deletePayement" id="deletePayement<?=$i?>" hidden>
                                                <input type="text" id="ancien_montant<?=$i?>" name="ancien_montant" value="<?=$value->debit?>" hidden>
                                                <input type="text" id="etat<?=$i?>" name="etat" value="<?=$value->etat?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                            <div class="modal-footer">
                                <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal"onclick="modifierVersement($('#idversement<?=$i?>').val(),$('#monnaieVerssement<?=$i?>').val(),$('#reference<?=$i?>').val(),$('#dateversement<?=$i?>').val(),$('#iddestination<?=$i?>').val(),$('#etat<?=$i?>').val(),'<?=$i?>')"> <i class="fa fa-check"></i>modifier ce versement</button>
                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                            </div>
                        </form>
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
                            <input type="text" class="form-control" id="idversement_del<?=$i?>" value="<?=$value->id?>" hidden>
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
$_SESSION['message'] = "";
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>