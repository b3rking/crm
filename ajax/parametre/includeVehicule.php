 
<?php
require_once("../../model/connection.php");
require_once("../../model/vehicule.class.php");

$vehicule = new Vehicule();
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div id="rep"></div>
    	<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">vehicule</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">gestion vehicule</a></li>
                <li class="breadcrumb-item active">vehicule</li>
            </ol>
           
            <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i>Ajouter vehicule</button>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Nouveau vehicule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                <label for="exampleInputEmail3" class="col-sm-3 control-label">vehicule</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="icon-feed"></i></span></div><input type="text" class="form-control" id="plaque" >
                               
                 </div>
            </div>
        </div>
            </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">modeles</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                        <input type="text" class="form-control" id="modele" >
                    </div>
                </div>
            </div>
                        </div>
                        
                       <div class="col-lg-6 col-md-6">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Marque</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                        <input type="text" class="form-control" id="marque" >
                    </div>
                </div>
            </div>
                        </div>
                    </div><!-- END ROW-->

                   

    <div class="form-group row m-b-0">
        <div class="offset-sm-2 col-sm-6 col-lg-6 col-md-6">


        </div>
    </div>

                </form>
            </div>
            <div class="modal-footer">

<button class="btn btn-success waves-effect text-left" onclick="NouveauVehicule($('#plaque').val(),$('#modele').val(),$('#marque').val())" data-dismiss="modal"><i class="fa fa-check"></i>Ajouter vehicule
</button>
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
		        <!--<h4 class="card-title">Data Export</h4>
		        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
                               
		                    	
		                   
		                        <th>Plaque d'immatriculation</th>
                                <th>Modele</th>
                                <th>Marque</th>
		                        <th></th>
                                <th></th>
		                    </tr>
		                </thead>
		                  <tfoot>
					            <tr>

					           <th>Plaque d'immatriculation</th>
                                <th>Modele</th>
                                <th>Marque</th>
                                <th></th>
                                <th></th>
					            </tr>
					        </tfoot>
		                    <tbody id="reponse">
                            <?php 
                            $i =0;
                            foreach ($vehicule->afficheVehicule() as  $value)
                             {?>
                               <?php
                               $i++; ?>
                               <tr>
          
                <td><?php echo $value->immatriculation?></td>
                <td><?php echo $value->modele?></td>
                <td><?php echo $value->marque?></td>
                    
        
                    <td><button type="button" class="btn waves-effect waves-light btn-xs btn-success" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>">Edit</button>

          <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">modifier vehicule</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">plaque</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="newplaque<?=$i?>" value="<?php echo $value->immatriculation?>">
                                    <input type="text" class="form-control" id="plaque<?=$i?>" value="<?php echo $value->immatriculation?>"hidden>
                                </div>
                            </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Modele</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="modele<?=$i?>" value="<?php echo $value->modele?>">
                                </div>
                            </div>
                                    </div>
                                </div><!-- END ROW-->
                                
                              
                                <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Marque</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="marque<?=$i?>" value="<?php echo $value->marque?>">
                                </div>
                            </div>
                        </div>
                                
                                </div><!-- End row-->
            
                            </form>
                        </div>
                <div class="modal-footer">
<button class="btn btn-success waves-effect text-left" onclick="UpdateVehicule($('#plaque<?=$i?>').val(),$('#newplaque<?=$i?>').val(),$('#modele<?=$i?>').val(),$('#marque<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier vehicule
</button>
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </td>
<td>
            <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>">Del</button>
                <!-- sample modal content -->
                <!-- sample modal content -->
<div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="mySmallModalLabel">Supprimer vehicule</h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body"> 
<input type="text" class="form-control" id="idservice<?= $i?>" value="<?php echo $value->ID_service?>" hidden>
Voulez-vous supprimer ce vehicule?<br>
</div>
<div class="modal-footer">
<button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteVehicule($('#plaque<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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

