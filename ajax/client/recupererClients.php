<?php
	require_once("../../model/connection.php");
    require_once("../../model/User.class.php");
    require_once("../../model/typeClient.class.php");
    require_once("../../model/client.class.php");
    require_once("../../model/contract.class.php");

    $client = new Client();
    $user = new User();
    $type = new TypeClient();
    $contract = new Contract();
    $url = $_GET['url'];
    $session_user = $_GET['session_user'];
    $nomProfil = $_GET['nomProfil'];
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
	foreach($client->afficheTousClients() as $value)
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
        <td><a href="<?=$url.'-'.$value->ID_client;?>"><b><?php echo $value->Nom_client;?></b></a></td>
        <td><?php foreach(preg_split("#[/]+#", $value->telephone) as $phone){echo $phone;}//echo $value->telephone?></td>
        <!--td><?php echo $value->adresse?></td>
        --td><php foreach(preg_split("#[,]+#", $value->mail) as $value2){echo $value2;}//;echo $value->mail?></td-->
       
         <?php
                                 if( $nomProfil != 'Technicien' && $nomProfil != 'coordination') 
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
                                 <span class="label label-danger"><?php echo number_format(round($value->solde)).'_BIF'//.$clientPaying['monnaie_facture'];?></span>
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
        <!--td><?php echo $value->commentaire?></td-->
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
                                    <input type="text" class="form-control" id="idclient<?= $i?>" value="<?php echo $value->ID_client?>" hidden>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Nom complet*</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <input type="text" class="form-control" id="nom<?= $i?>" value="<?php echo $value->Nom_client?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Personne de contact</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <input type="text" class="form-control" id="pers_cont<?= $i?>" placeholder="Personne à contacter">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Telephone</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                                    <input type="text" class="form-control" id="phone<?= $i?>" value="<?php echo $value->telephone?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Email*</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                                    <input type="email" class="form-control" id="mail<?= $i?>" value="<?php echo $value->mail?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End row-->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Adresse</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <textarea class="form-control" id="adrs<?= $i?>"><?php echo $value->adresse?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Type*</label>
                                            <div class="col-sm-9">
                                                
                                                <select class="form-control" id="type<?=$i?>">
                                                    <?php foreach ($type->recupererTypes() as $value2) : 
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
                                                    endforeach
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-12">
                                        <div class="form-group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                                    <textarea class="form-control" id="note<?= $i?>"> <?php echo $value->commentaire?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
            </div>
            <div class="modal-footer">
                <button class="btn text-white" style="background-color: #8b4513" onclick="updateClient($('#idclient<?=$i?>').val(),$('#nom<?=$i?>').val(),$('#mail<?=$i?>').val(),$('#adrs<?=$i?>').val(),$('#phone<?=$i?>').val(),$('#pers_cont<?=$i?>').val(),$('#note<?=$i?>').val(),$('#type<?=$i?>').val())" data-dismiss="modal">Modifier
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
?><!-- END FOREACH-->