
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
        <!--<h4 class="text-themecolor">Stock carburant</h4>-->
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">gestion carburant</a></li>
                <li class="breadcrumb-item active">technique</li>
            </ol>
           
            <button type="button" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i>Distribution</button>
 <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Distribution</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                                 <!-- Debut premiere ligne-->
                    <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Nature </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                <select class="form-control" id="nature">
                                    <option>Choisir</option>
                                    <option value="essence">Essence</option>
                                    <option value="mazout">Mazout</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Recepteur </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                <select class="form-control" id="recepteur"onchange="choisirgazoil($(this).val())">
                                    <option value=""></option>
                                    <option value="vehicule_essence">Vehicule Essence</option>
                                    <option value="vehicule_mazout">Vehicule Mazout</option>
                                    <option value="backup">Backup</option>
                                    <option value="autre">Autres</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
                
              
            </div><!-- End row-->
                         <div class="row">
                 <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"></div>
                                <input type="number" class="form-control" id="nblitres"><span class="input-group-text">litres</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                                <div class="col-sm-9">   
                                    <div class="form-group">
                                        <input type="date" class="form-control custom-select" id="datedistribution" value="<?=date('Y-m-d')?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" id="distributeur"  value="<?php echo $_SESSION['ID_user']?>"hidden>
                        <div class="col-lg-6" id="zonede_destination"></div>
                    </div><!-- Endajout_User row-->
                </form>
                       
    <div class="modal-footer">
        <button type="button" style="background-color: #8b4513" onclick="distribuer_carburant($('#nature').val(),$('#recepteur').val(),$('#nblitres').val(),$('#datedistribution').val(),$('#distributeur').val())" class="btn text-white waves-effect text-left">Distribuer
                    </button>
        <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
    </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
        <!--<button type="button" class="btn btn-primary d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle"></i>Sommaire</button>-->
                
    <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lgs">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Generer rapport</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal p-t-20" id="printRapport_mensuel" method="post" action="<?=WEBROOT;?>printRapport_mensuel">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Année </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" data-mask="9999" class="form-control" name="annee" id="annee" value="<?php echo date('Y')?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <select class="form-control" name="mois" id="mois">
                                            <option value="1">Janvier</option>
                                            <option value="2">Fevrier</option>
                                            <option value="3">Mars</option>
                                            <option value="4">Avril</option>
                                            <option value="5">Mai</option>
                                            <option value="6">Juin</option>
                                            <option value="7">Juillet</option>
                                            <option value="8">Aout</option>
                                            <option value="9">Septembre</option>
                                            <option value="10">Octobre</option>
                                            <option value="11">Novembre</option>
                                            <option value="12">Decembre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            <div class="modal-footer">
                <button type="button"  onclick="genererrapport_mensuel_paiment($('#nombanque_versement').val(),$('#annee').val(),$('#mois').val())" style="background-color: #8b4513" class="btn text-white waves-effect text-left">Generer rapport carburant
                </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>
		        <div class="table-responsive m-t-0">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                    	<th>Nature </th>
                                <th>Consommateur</th>
                                <th>Quantite en litre</th>
                                <th>Date</th>
		                    </tr>
		                </thead>
	                    <tfoot>
				            <tr>
                                <th>Nature </th>
                                <th>Consommateur</th>
                                <th>Quantite en litre</th>
                                <th>Date</th>
				            </tr>
				        </tfoot>
	                    <tbody id="reponse"> 
                            <?php $i =0; 
                            foreach ($equipement->afficheEtat_distribution() as$value) 
                            { $i++; 
                                ?>
                                <tr>
                                    <td><?php echo $value->carburant?></td>
                                    <td><?php echo $value->consommateur?></td>
                                    <td><?php echo $value->quantite?></td>
                                    <td><?php echo $value->datedistribution?></td>    
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