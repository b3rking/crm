<?php
ob_start();
//$donne = $marketing->VerifierEtatsponsor($id)->fetch();

//$prospectattente = $donne['etatduProspect'];
/*$data = $marketing->recupereDetail_un_prospect($id)->fetch();*/
$value = $marketing->getProspect($id)->fetch();
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>
                <!--<li class="breadcrumb-item active">Client</li>-->
            </ol>
            <?php
                if($value['etatduProspect'] == 'annuler') 
                {?>
                    <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-sm-activer-prospection">Activer la prospection
                    </button>
                    <!-- sample modal content -->
                    <div class="modal fade bs-example-modal-sm-activer-prospection" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Activation de la prospection</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    Voulez-vous activer cette prospection?<br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-chocolate waves-effect waves-light text-white" onclick="activerProspect('<?=$id?>')" data-dismiss="modal">Activer</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                <?php   
                }
                elseif ($value['etatduProspect'] == 'attente') 
                {
                ?>
                    <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-lg">Valider le prospect
                    </button>

                    <button type="button" class="btn d-none d-lg-block m-l-15 btn-dark" data-toggle="modal" data-target=".bs-example-modal-sm">Annuler</button>
                        <!-- sample modal content -->
                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Annulation de la prospection</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    Voulez-vous annuler la prospection?<br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="desactiveprospect('<?=$id?>')" data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"> Visiter prospect</button>
                            
                    <!--Debut du modal-->
                    <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">visite du prospect</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal p-t-20">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Proposition du marketeur</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" id="propositionmarketeur" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Proposition du prospect</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="comment" class="form-control" id="propositionprospect" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="row">
                                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Prochaine rendez-vous : </label>
                                                    <div class="col-sm-9">
                                                        <div class="form-group">
                                                            <input type="date" class="form-control" id="daterdv">
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="row" >
                                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date du visite : </label>
                                                    <div class="col-sm-9" >
                                                        <div class="form-group">
                                                            <input type="text" id="datedujour" value="<?php $d = new DateTime();echo $d->format('Y-m-d H:i:s');?>" class="form-control" >
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div><!-- END ROW-->
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button  type="button" class="btn btn-chocolate font-light text-white"  onclick="visiteClient('<?=$id?>',$('#propositionmarketeur').val(),$('#propositionprospect').val(),$('#daterdv').val(),$('#datedujour').val())" data-dismiss="modal">Enregistrer </button>
                                    <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!--/.modal-dialog -->
                    </div>
                <?php
                }
                ?>
        </div>
    </div>
</div>

<div class="row">
<div class="col-12">
	<div class="card border-dark">
        <div class="card-header" style="background-color:#ef7f22; ">
            <h6 class="m-b-0 text-white">Detail sur prospect</h6></div>
        <div class="card-body">
            <div class="table-responsive">
                <table width="100%" class="display wrap table table-hover table-striped table-bordered dataTable" id="example23" role="grid" aria-describedby="example23_info" style="width: 100%;" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>Entreprise</td>
                            <td style="font-size: 12px;"><?= $value['entreprise']?></td>
                        </tr>
                        <tr>
                            <td>Nom</td>
                            <td><?= $value['nom']?></td>
                        </tr>
                        <tr>
                            <td>Telephone</td>
                            <td style="font-size: 12px;"><?= $value['telephone']?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td style="font-size: 12px;"><?= $value['mail']?></td>
                        </tr>
                        <tr>
                            <td>Adresse</td>
                            <td style="font-size: 12px;"><?= $value['adresseProspect']?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <?php
                                if($value['etatduProspect'] == 'annuler') 
                                {?>
                                    <span class="label label-danger"> <?= $value['etatduProspect']?></span>
                                <?php   
                                }
                                elseif ($value['etatduProspect'] == 'valider') 
                                {
                                    ?>
                                    <span class="label label-success"> <?= $value['etatduProspect']?></span>
                                <?php
                                }
                                elseif ($value['etatduProspect'] == 'attente') 
                                {
                                    ?>
                                    <span style="background-color:#ef7f22; "class="label " > <?= $value['etatduProspect']?></span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>                     
</div>
</div>

<div class="row">
    <div class="col-12">
    	<div class="card border-dark">
            <div class="card-header" style="background-color:#ef7f22; ">
                <h6 class="m-b-0 text-white">Detail de la visite du prospect</h6></div>
            <div class="card-body">
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Proposition du marketeur</th>
                                <th>Reponse du prospect</th>
                                <th>Rendez vous donné par le client</th>
                                <th>Date du visite</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Proposition du marketeur</th>
                                <th>Reponse du prospect</th>
                                <th>Rendez vous donné par le client</th>
                                <th>Date du visite</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        	<?php
                            $i =0;
                            foreach ($marketing->recupereDetail_client_visite($id) as $data)
                            {
                                $i++;
                                ?>
                                <tr style="font-size: 20px;">
                                    
                                <!--<td><php echo $value->ID_prospect?></td>-->
                                    <td><?php echo $data->propositionmarketeur?></td>
                                    <td ><?php echo $data->propositionprospect?></td>
                                    <td><?php echo $data->rendezvous?></td>
                                    <td><?php echo $data->datedujour?></td>
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

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="myLargeModalLabel">validation du prospect</h6>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
             <form  class="form-horizontal p-t-20">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Localisation*</label>
                            <div class="col-sm-9">
                                <select  class="form-control" id="location">
                                <?php 
                                    foreach ($marketing->selectionLocalisationProspect() as $value2)
                                    {?>
                                    <option value="<?= $value2->ID_localisation?>"><?= $value2->nom_localisation?></option>
                                <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">NIF</label>
                            <div class="col-sm-9">
                                <input type="number" id="nif" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue*</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="langue">
                                    <option value="francais">Francais</option>
                                    <option value="anglais">Anglais</option>
                                </select>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label style="background-color: #8b4513" class="btn text-white ">
                                            <input type="checkbox" id="assujettitva"> Assujetti a la TVA
                                        </label> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-chocolate text-white" onclick="valideprospect('<?=$id?>',$('#location').val(),$('#nif').val(),$('#langue').val(),'potentiel')" data-dismiss="modal"><i class="fa fa-check"></i>valider
            </button>
            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
	            
<?php

$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>