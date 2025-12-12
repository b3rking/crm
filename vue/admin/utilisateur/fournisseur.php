<?php
ob_start();
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center"> 
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
        	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li>
                <li class="breadcrumb-item active">fournisseur</li>
            </ol>

            <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Ajouter un fournisseur</button>
                                                       <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Nouveau fournisseur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"></div>
                                    <input type="text" id="nom" class="form-control">
                                </div>
                           </div>
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Prenom</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="prenom">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Adresse</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="adres">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">telephone</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                         <input type="number" class="form-control" id="phone">
                                          
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">E-mail</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="email" class="form-control" id="mail">
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Fonction</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"></div>
                                <input type="text" class="form-control" id="fonction">
                            </div>
                        </div>
                    </div>
                </div>
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row" hi>
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="datecreation">
                                         <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
                                       
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="creer_fournisseur($('#nom').val(),$('#prenom').val(),$('#adres').val(),$('#phone').val(),$('#mail').val(),$('#fonction').val(),$('#datecreation').val(),$('#userName').val())"> <i class="fa fa-check"></i>Ajouter fournisseur</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
<!--button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgm"><i class="fa fa-plus-circle"></i> Ajouter une dette</button-->
<div class="modal fade bs-example-modal-lgm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lgm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Nouvelle dette</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Produit </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" id="nom" class="form-control">
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="prenom">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="adres">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date echeance</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                         <input type="number" class="form-control" id="phone">
                                          
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">E-mail</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="email" class="form-control" id="mail">
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Fonction</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"></div>
                                <input type="text" class="form-control" id="fonction">
                            </div>
                        </div>
                    </div>
                </div>
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row" hi>
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="datecreation">
                                         <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
                                       
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="creer_fournisseur($('#nom').val(),$('#prenom').val(),$('#adres').val(),$('#phone').val(),$('#mail').val(),$('#fonction').val(),$('#datecreation').val(),$('#userName').val())"> <i class="fa fa-check"></i>Ajouter fournisseur</button>
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
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">

		        <!--h4 class="card-title">Data Export</h4-->
		        <!--h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6-->
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Nom</th>
		                        <th>Prenom</th>
		                        <th>Adresse</th>
		                        <th>Phone</th>
		                        <th>Mail</th>
		                        <th>Fonction</th>
                                <th>Date creation</th>
                                <th>Action</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Nom</th>
                                <th>Prenom</th>
                                <th>Adresse</th>
                                <th>Phone</th>
                                <th>Mail</th>
                                <th>Fonction</th>
                                <th>Date creation</th>
                                <th>Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="reponse">
		                    
                            <?php 
                            $i =0;
                            $i++;
                            foreach ($user->getfourniseur() as $value) 
                            {
                                ?>
                               <tr>
                                <td><?php echo $value->nom?></td>
                                <td><?php echo $value->prenom?></td>
                                <td><?php echo $value->adres?></td>
                                <td><?php echo $value->phone?></td>
                                <td><?php echo $value->mail?></td>
                                <td><?php echo $value->fonction?></td> 
                                <td><?php echo $value->datecreation?></td> 
                                <td class="text-nowrap">
                                    
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                     
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier ce fournisseur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                               <form class="form-horizontal p-t-20">

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"></div>
                                    <input type="text" id="idfournisseur<?=$i?>" value="<?php echo $value->ID_fournisseur?>" >
                                    <input type="text" id="nom<?= $i?>" value="<?php echo $value->nom?>" class="form-control">
                                </div>
                           </div>
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Prenom</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="prenom<?= $i?>" value="<?php echo $value->prenom?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Adresse</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="adres<?=$i?>" value="<?php echo $value->adres?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">telephone</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                         <input type="number" class="form-control" id="phone<?= $i?>" value="<?php echo $value->phone?>">
                                          
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">E-mail</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="email" class="form-control" id="mail<?= $i?>" value="<?php echo $value->mail?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Fonction</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"></div>
                                <input type="text" class="form-control" id="fonction<?= $i?>" value="<?php echo $value->fonction?>">
                            </div>
                        </div>
                    </div>
                </div>
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row" hi>
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="date" class="form-control" value="<?php echo $value->datecreation?>" id="datecreation<?= $i?>">
                                         <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
                                       
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success waves-effect text-left" onclick="Updatefournisseur($('#idfournisseur<?=$i?>').val(),$('#nom<?=$i?>').val(),$('#prenom<?=$i?>').val(),$('#adres<?=$i?>').val(),$('#phone<?=$i?>').val(),$('#mail<?=$i?>').val(),$('#fonction<?=$i?>').val(),$('#datecreation<?=$i?>').val(),$('#userName').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier ce fournisseur
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
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce fournisseur</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="idfournisseur<?= $i?>" value="<?php echo $data->ID_localisation?>" hidden>
                            Voulez-vous supprimer ce fournisseur?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletelocalisation($('#idlocalisation<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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