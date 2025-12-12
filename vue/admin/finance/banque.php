<?php
ob_start();
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
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
?>
<input type="text" id="userName" name="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser"  value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="l" value="<?=$l?>" hidden>
<input type="text" id="c" value="<?=$c?>" hidden>
<input type="text" id="m" value="<?=$m?>" hidden>
<input type="text" id="s" value="<?=$s?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li>
                <li class="breadcrumb-item active">banque</li>
            </ol>
             <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer un compte bancaire</button>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Nouvelle banque</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom banque</label>
                            <div class="col-sm-9">
                                <input type="text" id="nombanque" class="form-control">
                           </div>
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Numero de compte</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="numerocompte">
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant initial</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="montantinitial" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Monnaie</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="monnaie">
                                        <?php
                                        for ($i=0; $i < count($tbMonnaie); $i++) 
                                        {
                                        ?> 
                                            <option value="<?=$tbMonnaie[$i]?>">
                                                <?=$tbMonnaie[$i]?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Statut</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="statut">
                                        <option value="active">active</option>
                                        <option value="desactive">desactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-2">
                            <div class="form-group">
                                <label class="btn">
                                    <input type="checkbox" id="show_on_invoice"> Visible sur la facture
                                </label> 
                            </div>
                        </div>
                        <!--<div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">tenue de compte</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" class="form-control" id="tenucompte">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>-->
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row" hidden>
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" value="<?=date('Y-m-d')?>" id="datecreation">
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal" onclick="creer_compteBancaire($('#nombanque').val(),$('#numerocompte').val(),$('#montantinitial').val(),$('#monnaie').val(),$('#statut').val(),$('#affichefacture').val(),$('#datecreation').val())"> <i class="fa fa-check"></i>Creer compte</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>

        </div>
    </div>
</div> 
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                        <input type="text" name="banque_name" id="banque_name" class="form-control form-control-sm input-filter" placeholder="Nom banque">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                        <input type="text" name="banque_number" id="banque_number" class="form-control form-control-sm input-filter" placeholder="Numero">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <select class="form-control form-control-sm input-filter" id="banque_status">
                                <option value="">Etat</option>
                                <option value="active">Activer</option>
                                <option value="desactive">Desactiver</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreBanque($('#banque_name').val(),$('#banque_number').val(),$('#banque_status').val())"><i class="ti ti-filter"></i> Filtrer</button>
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltrepaiement()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Annuler</button>
                    </div>
                </div>
                <div class="table-responsive m-t-0">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                               <th>Nom</th>
                                <th>Numero de compte</th>
                                <th>Solde initial</th>
                                <th>Solde actuel</th>
                                <th>Monnaie</th>
                                <!--<th>Tenu compte</th>-->
                                <th>Etat</th>
                                <th>Visibilite facture</th>
                                <th>Date creation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Numero de compte</th>
                                <th>Solde initial</th>
                                <th>Solde actuel</th>
                                <th>Monnaie</th>
                               <!-- <th>Tenu compte</th>-->
                                <th>Etat</th>
                                <th>Visibilite facture</th>
                                <th>Date creation</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php 
                            $i=0;
                            foreach($comptabilite->affichageBanque() as $value)
                            {
                                $i++;
                                ?>
                            <tr>
                                <!--<td><php echo $value->ID_banque?></td>-->
                                <td><?php echo $value->nom?></td>
                                <td><?php echo $value->numero?></td>
                                <td><?php echo $value->montant_initial?></td>
                                <td><?php echo $value->montant?></td>
                                <td><?php echo $value->monnaie?></td>
                               <!-- <td><php echo $value->tenucompte?></td>-->
                                <td><?php echo $value->statut?></td>
                                <td>
                                    <?php if ($value->affiche_numero =='OUI') 
                                    {
                                     ?>
                                        <span class="label label-success"><?php echo $value->affiche_numero?></span>
                                    <?php

                                    }
                                    elseif ($value->affiche_numero =='NON') 
                                        {?>
                                        <span class="label label-danger"><?php echo $value->affiche_numero?></span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?php echo $value->date_creation?></td>
                                <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    <a href="<?=WEBROOT;?>detailbanque-<?php echo $value->ID_banque?>" data-toggle="tooltip"  data-original-title="Voir"><i class="fa fa-eye text-inverse m-r-10"></i></a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier cette banque</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                             <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <input type="text" id="idbank<?=$i?>" value="<?php echo $value->ID_banque?>" class="form-control" hidden>
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
                                <div class="col-sm-9">
                                    <input type="text" id="nombanque<?=$i?>" value="<?php echo $value->nom?>" class="form-control">
                               </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Numero</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="numerocompte<?=$i?>" value="<?php echo $value->numero?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant initial</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="montantinitial<?=$i?>" value="<?php echo $value->montant_initial?>">
                                    <input type="text" class="form-control" id="oldMontantInitial<?=$i?>" value="<?php echo $value->montant_initial?>" hidden>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Monnaie</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="monnaie<?=$i?>">
                                    <?php
                                    for ($l=0; $l < count($tbMonnaie); $l++) 
                                    {
                                        if ($tbMonnaie[$l] == $value->monnaie) 
                                        {
                                    ?>
                                            <option value="<?=$tbMonnaie[$l]?>" selected>
                                            <?=$tbMonnaie[$l]?>
                                            </option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?=$tbMonnaie[$l]?>">
                                            <?=$tbMonnaie[$l]?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Statut</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="statut<?=$i?>">
                                        <option value="<?php echo $value->statut?>"><?php echo $value->statut?></option>
                                        <option value="active">active</option>
                                        <option value="desactive">desactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($value->affiche_numero == 'OUI') 
                        {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" id="show_on_invoice<?=$i?>" checked> Visible facture
                                    </label> 
                                </div>
                            </div>
                        <?php
                        }
                        else
                        {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" id="show_on_invoice<?=$i?>"> Visible facture
                                    </label> 
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div><!-- END ROW-->
                    </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal" onclick="update_compteBancaire($('#idbank<?=$i?>').val(),$('#nombanque<?=$i?>').val(),$('#numerocompte<?=$i?>').val(),$('#montantinitial<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#oldMontantInitial<?=$i?>').val(),$('#statut<?=$i?>').val(),'<?=$i?>')"> <i class="fa fa-check"></i>modifier compte</button>
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette banque</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body" > 
                            <input type="text" class="form-control" id="clebank<?=$i?>" value="<?php echo $value->ID_banque?> " hidden="">
                            Voulez-vous supprimer cette banque?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimercompteBanque($('#clebank<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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