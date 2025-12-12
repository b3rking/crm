<?php
ob_start();
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
?>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="col-lg-12">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <!--li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li-->
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
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
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Intitule dette</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"></div>
                                    <input type="text" id="dette" class="form-control">
                                </div>
                           </div>
                        </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="number" class="form-control" id="montant">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Monnaie</label>
                                <div class="col-sm-9">
                                    <select class="form-control"  id="monnaie">
                                      <?php
                                      for ($l=0; $l < count($tbMonnaie); $l++) 
                                      {
                                      ?> 
                                          <option value="<?=$tbMonnaie[$l]?>">
                                              <?=$tbMonnaie[$l]?>
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
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Motif </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="motif">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row" >
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
                <button type="button"style="background-color: #8b4513" class="btn font-light text-white" data-dismiss="modal" onclick="creer_dette($('#dette').val(),$('#montant').val(),$('#motif').val(),$('#datecreation').val(),$('#monnaie').val())"> <i class="fa fa-check"></i>Creer dette</button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
                <button type="button" style="background-color: #8b4513" class="btn  d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Ajouter une dette</button>
            </ol>
        </div>
    </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-6">
                <!--div class="d-flex justify-content-end align-items-center">   
                </div--
        <input type="radio" value="femme" name="choix" id="choix"> Femme<br>
        <input type="radio" value="homme" name="choix" id="choix1"> Homme<br>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="alert($('#choix').val(),$('#choix1').val())"> <i class="fa fa-check"></i>test</button-->
        
              <div class="table-responsive">
                    <table class="table color-table "style="background-color: #ef7f22">
                        <thead class="font-light text-white">
                            <tr>
                                <th>Intitulé dette</th>
                                <th>Montant</th>
                                <th>Motif</th>
                                <th>Date</th>
                                <th>Action</th>
                                <th>Choix</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot class="font-light text-white">
                            <tr>
                                <th>Intitulé dette</th>
                                <th>Montant</th>
                                <th>Motif</th>
                                <th>Date</th>
                                <th>Action</th>
                                <th>Choix</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep" style="background-color: white">
                            <?php  
                            $i =0;
                            $somme =0;
                            foreach ($comptabilite->affiche_dette() as $value) 
                                { $i++;
                                    ?>
                            <tr> 
                                <td><?= $value->nom_dette ?></td>
                                <td><?= $value->montant .' '.$value->monnaie?></td>
                                <td><?= $value->motif?></td>
                                <td><?= $value->datecreation?></td>
                                <td><a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
          <div class="modal fade bs-example-modal-lgs<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Modification de la dette</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                   <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Intitule dette</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"></div>
                                    <input type="text" id="id_dette<?=$i?>" value="<?php echo $value->ID_dette?>" class="form-control"hidden>
                                    <input type="text" id="dette<?=$i?>" value="<?php echo $value->nom_dette?>" class="form-control">
                                </div>
                           </div>
                        </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="number" class="form-control" id="uptmontant<?=$i?>" value="<?php echo $value->montant?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Monnaie</label>
                                <div class="col-sm-9">
                                    <select class="form-control"  id="monnaie<?=$i?>">
                                    <?php
                                    for ($l=0; $l < count($tbMonnaie); $l++) 
                                    {
                                        if ($value->monnaie == $tbMonnaie[$l]) 
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
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Motif </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" id="motif<?=$i?>" value="<?php echo $value->motif?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row" >
                                <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Date creation</label>
                                <div class="col-sm-9 col-lg-7">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control" value="<?php echo $value->datecreation?>" id="datecreation<?=$i?>">
                                       <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="update_dette($('#id_dette<?=$i?>').val(),$('#dette<?=$i?>').val(),$('#uptmontant<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#motif<?=$i?>').val(),$('#datecreation<?=$i?>').val())"> <i class="fa fa-check"></i>Modifier cette dette</button>

                  <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                </div>
              </div>
            </div>
          </div>

          <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm2<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm2<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette dette </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="id_dette<?= $i?>" value="<?php echo $value->ID_dette?>" hidden>
                            
                            Voulez-vous supprimer cette dette ?  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimer_dette($('#id_dette<?=$i?>').val(),$('#userName').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal --></td>
        <td> 
            <input type="text" id="intitule_dette<?=$i?>" value="<?php echo $value->nom_dette?>"hidden>

         <input type='radio' value="<?=$i?>" name="choix_dette" id="choix_dette<?=$i?>" onclick="showHideInputDette(this,'<?=$i?>')"/><br/>

         <input type="text" value="<?= $value->montant?>" id="dette_initiale<?=$i?>"hidden>
         <input type="text" id="refdette<?=$i?>" value="<?php echo $value->ID_dette?>"hidden>
         <input type="text" id="monnaiedette<?=$i?>" value="<?php echo $value->monnaie?>"hidden>
        </td>
        <td>
            <div id="champtext<?=$i?>" style="display: none;">
                <input type="number" min="1" id="montant<?=$i?>" class="form-control form-control-sm" value="<?php echo $value->montant?>">
            </div>
        </td>
    </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                 </div>
                                  </div>
                                     <div class="col-lg-5 col-md-6">
                                        <div class="row">
                                            <div class="table-responsive">
                    <table class="table color-table nowrap"style="background-color: #ef7f22" >
                        <thead class="font-light text-white"> 
                            <tr>
                                <th>Libelle </th>
                                <th>Montant</th>
                                <th>Choix</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="font-bold" style="background-color:white">
                            <?php
                            $resultat_USD =0;
                            $resultat_monnaie_locale = 0;
                            $j=0;
                            foreach ($comptabilite->getBanqqueActive() as $value) 
                            {
                                $j++;
                                if ($value->monnaie == 'USD')
                                    $resultat_USD += $value->montantVersser;
                                else $resultat_monnaie_locale += $value->montantVersser;
                                
                            ?>
                            <tr>
                                <td><?=$value->nom?></td>
                                <td><?php echo number_format($value->montantVersser).' '.$value->monnaie?></td>
                                <td><input type='checkbox' id="choix_banque<?=$j?>" value="banque" onclick="showHideInputBanque(this,'<?=$j?>')"/><br/>
                                </td>
                                <td>
                                    <div id="banque<?=$j?>" style="display: none;">
                                        <input type="text" id="refbanque<?=$j?>" value="<?php echo $value->ID_banque?>"hidden>
                                        <input type="number" min="1" id="montant_banque<?=$j?>" class="form-control form-control-sm" >
                                        <input type="text" id="nomBanque<?=$j?>" value="<?=$value->nom?>" hidden>
                                    </div>
                                    <span id="msgError<?=$j?>"></span>
                                    <input type="text" value="<?= $value->montantVersser?>" id="initiale_mount_banque<?=$j?>"hidden>
                                    <input type="text" value="<?= $value->monnaie?>" id="monnaie_banque<?=$j?>"hidden>
                                </td>
                            </tr>
                            <?php
                            }
                            foreach ($comptabilite->getGrandeCaisses() as $value) 
                            {
                                $j++;
                                if ($value->devise == 'USD')
                                    $resultat_USD += $value->montantCaisse;
                                else $resultat_monnaie_locale += $value->montantCaisse;
                            ?>
                        <tr> 
                            <td><?=$value->nomCaisse?></td>
                            <td><?=number_format($value->montantCaisse).' '.$value->devise?></td>
                            <td><input type='checkbox' id="choix_banque<?=$j?>" value="caisse" onclick="showHideInputCaisse(this,'<?=$j?>')"/><br />
                            </td>
                           <td>
                            <div id="champ_caisse<?=$j?>" style="display: none;">
                            <input type="number" id="montant_caisse<?=$j?>" min="1" class="form-control form-control-sm"> 
                            <input type="text" id="refcaisse<?=$j?>" value="<?php echo $value->ID_caisse?>"hidden>
                            <input type="text" value="<?=$value->montantCaisse?>" id="caisse_initiale<?=$j?>"hidden>
                            <input type="text" id="nomCaisse<?=$j?>" value="<?=$value->nomCaisse?>">
                            <input type="text" id="monnaieCaisse<?=$j?>" value="<?=$value->devise?>">
                          </div>
                        </td>
                        </tr>
                    <?php
                    }
                    ?>
                <tr>
                    <td>Total General</td>
                    <td>
                    <?php echo number_format($resultat_USD).' '.$tbMonnaie[0].' '.number_format($resultat_monnaie_locale).' '.$tbMonnaie[1];?> 
                    </td>
                    <td></td>
                    <td></td>
                </tr> 
            </tbody>
        </table> 
    </div>
</div>
</div>

</div><!-- End row-->

</div>

    <div class="row">
        <div class="col-lg-2 offset-5">
            <button type="button" style="background-color: #8b4513" class="btn  d-none d-lg-block m-l-15 font-light text-white" onclick="payer_dette('<?=$i?>','<?=$j?>')"><i class="fa fa-check-circle"></i>Payer</button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Historique de payement </h4>
                        <div class="table-responsive">
                            <table  class="table color-table nowrap table text-white">
                                <thead style="background-color: #ef7f22">
                                    <tr>
                                        <th>Libelle dette </th>
                                        <th>Montant</th>
                                        <th>Date du paiement</th>
                                        <th>Provenance de payement</th>
                                        <th>Effectuer par</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=0;
                                    foreach ($comptabilite->getHistoriquepaie() as $value) 
                                    {
                                        $i++;
                                    ?>  
                                        <tr> 
                                            <td><?=$value->nom?></td>
                                            <td><?=$value->montant_paie .' '.$value->monnaie?></td>
                                            <td><?=$value->date_histo?></td>
                                            <td><?=$value->provenancePayement?></td>
                                            <td><?=$value->userName?></td>
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
    </div>
</div>

                   
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>