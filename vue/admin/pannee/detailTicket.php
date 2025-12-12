<?php
ob_start();
$donne = $ticket->VerifierTicketfermer($id)->fetch();
$ticketFermer = $donne['status'];
$data = $ticket->recupereTicket($id)->fetch();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('ticket',$_SESSION['ID_user'])->fetch()) 
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

<div id="rep">
    <input type="text" id="userName" name="userName" value="<?=$_SESSION['userName']?>"hidden>
<div class="card">
    <input type="text" name="profil_name" id="profil_name" value="<?=$_SESSION['profil_name']?>" hidden>
        <div class="card-body">
           <a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span>
        <!--div style="background-color: #8b4513" class="card-header text-white">
            <div class="m-b-0 text-white align-items-center">
                <h4 style="text-align: center;">Detail</h4>
                
            </div>
           
        </div-->
    <div class="table-responsive">
        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded footable" data-page-size="10">
            <thead>
                <tr>
                    <th class="footable-sortable">DETAIL<span class="footable-sort-indicator"></span></th>
                    <th class="footable-sortable">CONTENU<span class="footable-sort-indicator"></span></th>
                </tr>
            </thead>
            <tbody>
                 
                 <?php
                 if ($ticketFermer == 'ouvert') 
                 {
                ?>

                        <div class="col-md-12 align-self-right">
                            <div class="d-flex justify-content-end align-items-center">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>

                                    </ol>
                                   
                                        <button type="button" style="background-color: #8b4513" class="btn text-white" onclick="" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-check" ></i>nouvelle action de ticket</button>
                                       
                                    
                                <span id="msg"></span>
                            </div>
                        </div>

                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Nouvelle action</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>

                            <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row" >
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Endroit</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <select id="endroit" class="form-control">
                                                        <option value="in_door">In door</option>
                                                        <option value="Out_door">Out door</option>
                                                    </select>
                                    <input type="text" id="idticket" class="form-control" value="<?php echo $id?>" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   <div class="col-lg-6 ">
                                        <div class="form-group row">
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" id="user" value="<?=$_SESSION['ID_user']?>" hidden>
                                                <input type="text" value="<?php $d = new DateTime();echo $d->format('Y-m-d H:i:s');?>" class="form-control" id="date_fermeture" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                            <textarea rows="5" cols="2" maxlength="180"  class="form-control " id="observation" placeholder="Description           ici..."></textarea>
                                            <input type="text" id="type_ticket" value="<?= $data['ticket_type']?>" hidden>
                                            <input type="text" id="id_client" value="<?=$data['ID_client']?>" hidden>
                                        </div>
                                    </div>    
                                </div>
                                   
                                   <?php
                                    if ($m) 
                                    {
                                       ?>
                                        <div class="row">
                                            <label style="background-color: #8b4513" class="btn text-white">
                                                <input type="checkbox" id="dernierAction"> dernière action
                                            </label> 
                                        </div> 
                                        <?php
                                    }
                                    ?>






                                </form>
                            </div>
                            <div class="modal-footer">
                                <button style="background-color: #8b4513" class="btn text-white" onclick="fermerTicket($('#idticket').val(),$('#user').val(),$('#observation').val(),$('#endroit').val(),$('#type_ticket').val(),$('#id_client').val())" data-dismiss="modal">Enregistrer
                                </button>
                                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>        
                <!--ici on appel la fonction ticket selection du ticket a partir de l'ID_ticket et on fait la jointure pour trouver le nom du client-->
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Client</td>
                    <td><?php echo 'ID-'.$data['billing_number'].'-'.$data['Nom_client']?></td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Probleme</td>               
                    
                    <td>
                       <?php echo $data ['problem'] ?>
                    </td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Type ticket</td>                               
                    <td>
                    <?php echo $data ['ticket_type']?> 
                    </td>
                </tr>       
            </tbody>  
        </table>
    </div>
</div>
</div>
    <div class="card">
        <div class="card-body">
        <div class="card-header bg-danger">
            <h4 class="m-b-0 text-white">Description</h4>
        </div>
        <!--<h6 class="card-subtitle">Add class <code>.color-table .success-table</code></h6>-->
        <div class="table-responsive m-t-0">
             <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Observation</th>
                        <th>Date Creation</th>
                        <th>Endroit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody >

                    <?php $i=0; foreach($ticket->recupererLesDescription($id) as $value)
                    { $i++;
                    ?>
                       <tr>
                            <td><?=$value->nom_user?></td>
                            <td><?php echo $value->comment?></td>
                            <td><?php echo $value->created_at?></td>  
                            <td><?php echo $value->means?></td>
                            <td>
                                 <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-md1<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                     <?php
                    if ($s) 
                    {
                        ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="supprimer"> <i class="ti-trash text-inverse m-r-10"></i></a>
                    <?php
                        }
                    ?> <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                       <div class="modal-dialog modal-sm<?=$i?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette description</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body"> 
                                    <input type="text" class="form-control" id="ref<?=$i?>" value="<?php echo $value->id?>" hidden>
                                    Voulez-vous supprimer cette description?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn btn-dark" onclick="supprimeDescription($('#ref<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
                                </div>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                    

                                    <!-- sample modal content -->
             <div class="modal fade bs-example-modal-md1<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog bs-example-modal-md1<?=$i?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">MODIFIER LA DESCRIPTION </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                           <form class="form-horizontal p-t-20">
                                 <!-- Debut premiere ligne-->
                   <div class="row">
                    
                    <!--div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-6 control-label">Client</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        
                                            !--input type="text" class="form-control" value="<?php echo $data['Nom_client']?>" disabled--
                                                
                                    </div>
                                </div>
                            </div>
                        </div-->
                          <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <input type="text" id="ref<?=$i?>" value="<?php echo $value->id?>"class="form-control" hidden>
                                <label for="exampleInputEmail3" class="col-md-6 control-label">Utilisateur</label>
                                <div class="form-group col-sm-9">
                                   
                                    <select class="form-control" id="informaticien<?=$i?>">
                                          <option value="<?=$value->ID_user?>"><?=$value->nom_user?></option>
                                         <?php
                                            foreach ($user->get_utulisateur() as $value2) 
                                            {
                                            ?>
                                                <option value="<?=$value2->ID_user?>"><?=$value2->nom_user?></option>
                                            <?php
                                            }
                                          ?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                  <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-6 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        
                                            <input type="text" value="<?php echo $value->created_at?>" class="form-control" id="date_description<?=$i?>" >
                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-md-6 control-label">Endroit</label>
                                <div class="form-group col-sm-9">
                                    <select id="endroit<?=$i?>" class="form-control">
                                            <option value="<?php echo $value->means?>"><?php echo $value->means?></option>
                                            <option value="in_door">In door</option>
                                            <option value="Out_door">Out door</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 form-group">
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                        
                                        <textarea class="form-control" id="description<?= $i?>"> <?php echo $value->comment?></textarea>
                                </div>
                            </div>
                        </div> 
                    </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                                      
                                        <button type="button" style="background-color: #8b4513" class="btn text-white waves-effect text-left" onclick="modifier_details_client($('#ref<?=$i?>').val(),$('#informaticien<?=$i?>').val(),$('#date_description<?=$i?>').val(),$('#endroit<?=$i?>').val(),$('#description<?=$i?>').val())">Modifier description
                                        </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
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
            <?php
                 } 
            // Verifier si le tiquet est ferme
            if($ticketFermer == 'fermer')
            {
                ?>        
                <!--ici on appel la fonction ticket selection du ticket a partir de l'ID_ticket et on fait la jointure pour trouver le nom du client-->
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Client</td>
                    <td><?php echo 'ID-'.$data['ID_client'].'-'.$data['Nom_client']?></td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Probleme</td>
                    <td>
                       <?php echo $data ['problem'] ?>
                    </td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Type ticket</td>                               
                    <td>
                    <?php echo $data ['ticket_type']?>
                    </td>
                </tr>       
            </tbody>  
        </table>
    </div>
    <div class="card"> 
        <div class="card-body">
        <div class="card-header bg-success">
            <h4 class="m-b-0 text-white">Description</h4>
        </div>
        <!--<h6 class="card-subtitle">Add class <code>.color-table .success-table</code></h6>-->
        <div class="table-responsive m-t-0">
             <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Observation</th>
                        <th>Date Creation</th>
                        <th>Endroit</th>
                         <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0; foreach($ticket->recupererLesDescription($id) as $value)
                    { $i++;
                    ?>
                       <tr>
                            <td><?=$value->nom_user?></td>
                            <td><?php echo $value->comment;//$des = nl2br(wordwrap($value->comment,50,"\n",true))?></td>
                            <td><?php echo $value->created_at?></td> 
                            <td><?php echo $value->means?></td>
                            <td>
                                 <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-md<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                     <?php
                    if ($s) 
                    {
                        ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                    <?php
                        }
                    ?> <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                       <div class="modal-dialog modal-sm<?=$i?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette description</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body"> 
                                    <input type="text" class="form-control" id="ref<?=$i?>" value="<?php echo $value->id?>" hidden>
                                    Voulez-vous supprimer cette description?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn btn-dark" onclick="supprimeDescription($('#ref<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
                                </div>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                    

                                    <!-- sample modal content -->
             <div class="modal fade bs-example-modal-md<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-md<?=$i?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">MODIFIER TICKET </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                              <form class="form-horizontal p-t-20">
                                 <!-- Debut premiere ligne-->
                   <div class="row">
                    
                    <!--div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-6 control-label">Client</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        
                                            --input type="text" class="form-control" value="<php echo $data['Nom_client']?>" disabled--
                                                
                                    </div>
                                </div>
                            </div>
                        </div-->
                          <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <input type="text" id="ref<?=$i?>" value="<?php echo $value->id?>"class="form-control" hidden>
                                <label for="exampleInputEmail3" class="col-md-6 control-label">Utilisateur</label>
                                <div class="form-group col-sm-9">
                                   
                                    <select class="form-control" id="informaticien<?=$i?>">
                                          <option value="<?=$value->ID_user?>"><?=$value->nom_user?></option>
                                         <?php
                                            foreach ($user->get_utulisateur() as $value2) 
                                            {
                                            ?>
                                                <option value="<?=$value2->ID_user?>"><?=$value2->nom_user?></option>
                                            <?php
                                            }
                                          ?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                  <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-6 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        
                                            <input type="text" value="<?php echo $value->created_at?>" class="form-control" id="date_description<?=$i?>" >
                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-md-6 control-label">Endroit</label>
                                <div class="form-group col-sm-9">
                                    <select id="endroit<?=$i?>" class="form-control">
                                            <option value="<?php echo $value->means?>"><?php echo $value->means?></option>
                                            <option value="in_door">In door</option>
                                            <option value="Out_door">Out door</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 form-group">
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                        
                                        <textarea class="form-control" id="description<?= $i?>"> <?php echo $value->comment?></textarea>
                                </div>
                            </div>
                        </div> 
                    </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                           
                                        <button type="button" style="background-color: #8b4513" class="btn text-white waves-effect text-left" onclick="modifier_details_client($('#ref<?=$i?>').val(),$('#informaticien<?=$i?>').val(),$('#date_description<?=$i?>').val(),$('#endroit<?=$i?>').val(),$('#description<?=$i?>').val())">Modifier description
                                        </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
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
        <?php 
        }
        ?>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>