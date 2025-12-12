<?php 
    require_once("../../model/connection.php");
    require_once("../../model/User.class.php");
    require_once("../../model/typeClient.class.php");
    require_once("../../model/contract.class.php");
    require_once("../../model/localisation.class.php");
    
     $localisation = new Localisation();
    $user = new User();
    $type = new TypeClient();
    $contract = new Contract();
    

    $l = false;
    $c = false;
    $m = false;
    $s = false;
    if ($d = $user->verifierPermissionDunePage('client',$session_user)->fetch()) 
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
    $i = 0;
    foreach($client->filtreClient($query) as $value)
    {
        $i++;
        if ($value->type_client == 'paying') $convert_type = 'Payant';
        elseif ($value->type_client == 'free') $convert_type = 'Gratuit';
        elseif ($value->type_client == 'potentiel') $convert_type = 'potentiel';
        elseif ($value->type_client == 'gone') $convert_type = 'parti';
        else $convert_type = 'inconnu';
    ?>
        <tr>

            <td><?php echo $value->billing_number?></td>
            <td><a href="<?= $url;?>-<?= $value->ID_client;?>"><b><?php echo $value->Nom_client;?></b></a></td>
            <td><?php 
            foreach(preg_split("#[/]+#", $value->telephone) as $phone){echo $phone;
            }
            echo "\n".$value->mobile_phone;
            //echo $value->telephone?></td>
            <!--td><php echo $value->adresse?></td>
            <td><php foreach(preg_split("#[,]+#", $value->mail) as $value2){echo $value2;}//;echo $value->mail?></td-->
           <?php
             if($profil_name != 'Technicien' && $profil_name != 'coordination') 
                {
            ?>
                    <td>
                <?php
             $clientPaying = $client->afficherUnClentAvecContract($value->ID_client)->fetch();
            if (!empty($clientPaying))
            {
                $montant_tva = $clientPaying['montant']*$clientPaying['tva']/100;
                $montant_total = $montant_tva+$clientPaying['montant'];
                echo round($montant_total).' '.$clientPaying['monnaieContract'];
            } 
            else echo "";
            ?></td>
            <td>
                <?php
                //$dette = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
                if ($value->solde > 0)
                {
                ?>    
                    <span style="background-color: #ef7f22" class="label label"><?php echo number_format(round($value->solde)).'_BIF'//.$clientPaying['monnaie_facture'];?></span>
                <?php  
                } 
                else
                {
                    echo number_format(round($value->solde)).'_BIF';
                }
                ?>
            </td>
            <?php
            }
            ?>
            <td><?php
            if (!empty($clientPaying)) echo $clientPaying['nomService'];
            else echo "";
            ?></td>
            <td><?php echo $value->etat?></td>
            <!--td><php echo $value->commentaire?></td-->
            <td><?php echo $convert_type?></td>
            <td class="text-nowrap">
                <?php
                if ($m) 
                {?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <?php
                }
                ?>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier Client</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
        <form class="form-horizontal p-t-20">
            <div class="row">
                <input type="text" class="form-control" id="idclient<?= $i?>" value="<?php echo $value->ID_client?>"hidden >
                
    <div class="col-lg-5 col-md-6">
        <label for="exampleInputuname3" class="control-label">Nom complet *</label>
        <div class="form-group">
           <input type="text" class="form-control" id="nom<?=$i?>" value="<?php echo $value->Nom_client?>">
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        <label for="exampleInputuname3" class="control-label">Pers contact</label>
        <div class="form-group">
            <input type="text" class="form-control" id="pers_cont<?=$i?>" value="<?php echo $value->personneDeContact?>" placeholder="Personne à contacter">
        </div>
    </div>
    <div class="col-lg-2 col-md-3">
        <div class="form-group">
            <label for="exampleInputuname3" class="control-label">Tele_fixe</label>
            <div class="input-group">
               <input type="text" class="form-control" id="fixed_phone<?= $i?>" value="<?php echo $value->telephone?>">
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-3">
        <label for="exampleInputuname3" class="control-label">Tele_mobile</label>
        <div class="form-group">
           <input type="text" class="form-control" id="mobile_phone<?= $i?>" value="<?php echo $value->mobile_phone?>">
        </div>
    </div>
</div><!-- END ROW-->

<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-4 control-label">Email*</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" id="mail<?= $i?>" value="<?php echo $value->mail?>">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-4 control-label">Langue</label>
            <div class="col-sm-9">
                <select class="form-control" id="langue<?=$i?>">
                    <option value="francais">Francais</option>
                    <option value="anglais">Anglais</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-4 control-label">Billing</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="billing<?= $i?>" value="<?php echo $value->billing_number?>">
            </div>
        </div>
    </div>
</div><!-- End row-->
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-4 control-label">Adresse</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="adrs<?= $i?>"><?php echo $value->adresse?></textarea>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-4 control-label">Type*</label>
            <div class="col-sm-9">
               <input type="text" value="<?=$value->type_client?>" id="type<?=$i?>" hidden>
                    <select class="form-control" id="newtype<?=$i?>">
                        
                            <?php foreach ($type->recupererTypes() as $value2)
                    {
                        if ($value->type_client == $value2->libelle) 
                        {
                        ?>
                            <option value="<?=$value2->libelle?>" selected><?=$value2->equivalent?></option>
                        <?php
                        }
                        else
                        {
                        ?>
                            <option value="<?=$value2->libelle?>"><?=$value2->equivalent?></option>
                        <?php
                        }
                    }
                    ?>
                    </select>
            </div>
        </div>
    </div>
    
<!-- End row-->
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-4 control-label">Localisation *</label>
            <div class="col-sm-9">
               <select  class="form-control" id="location<?=$i?>">
                <!--option value="<php echo $data->ID_localisation?>"><php echo $data->nom_localisation?></option-->
                <?php 
                foreach ($localisation->selectionLocalisation() as $data)
                {
                    
                    if ($data->ID_localisation == $data->nom_localisation) 
                    {
                    ?>
                        <option value="<?=$data->ID_localisation?>" selected><?=$data->nom_localisation?></option>
                    <?php
                    }
                    else
                    {
                    ?>
                        <option value="<?=$data->ID_localisation?>"><?=$data->nom_localisation?></option>
                    <?php
                    }
                
                }
                ?>
               </select>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-4 control-label">NIF</label>
            <div class="col-sm-9">
                <input type="text" maxlength="59" class="form-control" id="nif<?=$i?>" value="<?=$value->nif?>">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-4 control-label">Assujetti a la tva</label>
            <div class="col-sm-9">
            <?php 
                if($value->assujettiTVA =='oui')
                {?>
                    <label style="background-color: #8b4513" class="btn active font-light text-white"><input type="checkbox" id="tva<?=$i?>" checked> Assujetti a la TVA</label> 
                <?php
                }
                else
                {?>
                <label style="background-color: #8b4513" class="btn active font-light text-white"><input type="checkbox" id="tva<?=$i?>"> Assujetti a la TVA</label> 
                <?php   
                }
                ?>
            </div>
        </div>
</div>
     </div>
        <div class="row">
           <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                <div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-4 control-label">Commentaire</label>

                    <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                       <input class="form-control" id="note<?=$i?>" value="<?php echo $value->commentaire?>"> 
                        <input class="form-control" id="<?=$i?>" value="<?=$i?>"hidden> 
                    </div>
                   </div>
                </div>
           </div> 
       </div>
    </form>
            <div class="modal-footer">
                <button class="btn text-white" style="background-color: #8b4513" onclick="updateClient($('#idclient<?=$i?>').val(),$('#nom<?=$i?>').val(),$('#pers_cont<?=$i?>').val(),$('#fixed_phone<?=$i?>').val(),$('#mobile_phone<?=$i?>').val(),$('#mail<?=$i?>').val(),$('#langue<?=$i?>').val(),$('#billing<?=$i?>').val(),$('#adrs<?=$i?>').val(),$('#type<?=$i?>').val(),$('#newtype<?=$i?>').val(),$('#location<?=$i?>').val(),$('#nif<?=$i?>').val(),$('#<?=$i?>').val(),$('#note<?=$i?>').val(),$('#profil_name<?=$i?>').val())" data-dismiss="modal">Modifier
                </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
if ($s) 
{?>
    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
<?php
}
?>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idclient-<?= $i?>" value="<?php echo $value->ID_client?>" hidden>
                Voulez-vous supprimer ce client?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteClient($('#idclient-<?= $i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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