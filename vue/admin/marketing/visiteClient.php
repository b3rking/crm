<?php
ob_start();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
    <div class="card-body">
        <div id="rep"></div>

        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                <h2 class="text-themecolor">Visite du prospect</h2>
            </div>

        </div>

        <form  class="form-horizontal p-t-20">
                                     <!-- Debut premiere ligne-->
       <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Prospect</label>
                    

                    <div class="form-group col-sm-9">
                        <input type="text" id="idprospect" name="idprospect" class="form-control" autocomplete="off"> 
                            <div id="modal"></div>
                    </div>
                </div>
            </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Proposition du marketeur</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <textarea class="form-control" id="propositionmarketeur" ></textarea>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             <div class="row">

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Proposition du prospect</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <textarea name="comment" class="form-control" id="propositionprospect" ></textarea>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
           <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date rendez-vous : </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="date" class="form-control" id="daterdv">
                        </div>
                    </div> 
                </div>
            </div>
         
            
         
        </div>
        
         <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    
                    <div class="form-group col-sm-9">
                        
                    </div>
                </div>
            </div>
           <div class="col-lg-6 col-md-6">
                <div class="row" hidden>
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date du jour : </label>
                    <div class="col-sm-9" >
                        <div class="form-group">
                            <!--<input type="date" class="form-control" id="datedujour">-->
                        <input type="text" value="<?php $d = new DateTime();echo $d->format('Y-m-d H:i:s');?>" class="form-control" id="datedujour">
                        </div>
                    </div> 
                </div>
            </div>
         
        </div>
        <div class="row">
          
           
        </div>

        <div class="container">
            <div class="row">
              <div class="col">
           </div>
        <div class="col">
            <button  type="button" class="btn text-white"style="background-color: #8b4513" onclick="visiteClient($('#idprospect').val(),$('#propositionmarketeur').val(),$('#propositionprospect').val(),$('#daterdv').val(),$('#datedujour').val())">Enregistrer </button>
        </div>
                            <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Proposition marketeur</th>
                                <th>Proposition prospect</th>
                                <th>Rendez-vous</th>
                                <th>Date du viste</th>
                                <!--<th></th>-->
                                
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numero</th>
                                <th>Proposition marketeur</th>
                                <th>Proposition prospect</th>
                                <th>Rendez-vous</th>
                                <th>Date du visite</th>
                                <!--<th></th>-->
                               
                            </tr>
                        </tfoot>
                        <tbody id="reponse">
                            <?php
                            $i =0;
                            foreach ($marketing->affichevisiteProspect () as $value)
                            {
                                $i++;
                                ?>
                                <tr>
                                    
                                <td><?php echo $value->ID_prospect?></td>
                                <td><?php echo $value->propositionmarketeur?></td>
                                <td><?php echo $value->propositionprospect?></td>
                                <td><?php echo $value->rendezvous?></td>
                                <td><?php echo $value->datedujour?></td>
                                
                               


                                

                                
                               <!-- <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!- sample modal content -
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier ce prospect</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                       <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Prospect</label>
                    

                    <div class="form-group col-sm-9">
                        <input type="text" id="idprospect" name="idprospect" class="form-control" autocomplete="off"> 
                            <div id="modal"></div>
                    </div>
                </div>
            </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Proposition du marketeur</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <textarea class="form-control" id="propositionmarketeur" ></textarea>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             <div class="row">

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Proposition du prospect</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <textarea name="comment" class="form-control" id="propositionprospect" ></textarea>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
           <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date rendez-vous : </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="date" class="form-control" id="daterdv">
                        </div>
                    </div> 
                </div>
            </div>
         
            
         
        </div>
        
         <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    
                    <div class="form-group col-sm-9">
                        
                    </div>
                </div>
            </div>
           <div class="col-lg-6 col-md-6">
                <div class="row" hidden>
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date du jour : </label>
                    <div class="col-sm-9" >
                        <div class="form-group">
                            <!-<input type="date" class="form-control" id="datedujour">--
                        <input type="text" value="<php $d = new DateTime();echo $d->format('Y-m-d H:i:s');?>" class="form-control" id="datedujour">
                        </div>
                    </div> 
                </div>
            </div>
         
        </div>
                    </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" onclick="updateProspect($('#numprospect<?=$i?>').val(),$('#nomprospect<?=$i?>').val(),$('#adresprospect<?=$i?>').val(),$('#phoneprospect<?=$i?>').val(),$('#mailprospect<?=$i?>').val(),$('#entreprise<?=$i?>').val(),$('#rdv<?=$i?>').val(),$('#dateprospection<?=$i?>').val(),$('#commentaire<?=$i?>').val())" data-dismiss="modal">Modifier
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!- /.modal-content --
                </div>
                <!- /.modal-dialog -
                </div>
                <!- /.modal --


                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

                <!- sample modal content --
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce prospect</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="numprospect<?= $i?>" value="<php echo $data->ID_prospect?>" hidden>
                            Voulez-vous supprimer ce prospect?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerProspect($('#numprospect<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                            </div>
                        </div>
                        <!-/.modal-content --
                    </div>
                    <!- /.modal-dialog --
                </div>
                <!- /.modal --
        </td>-->
    </tr>
                       <?php
                            }

                            ?>
                              
                            
                          
                        </tbody>
                    </table>
                </div>
        </div>
         
     
        </div>
 
      
       
        </form>
    </div>
        </div>
    </div>

</div>
<?php
$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');
?>