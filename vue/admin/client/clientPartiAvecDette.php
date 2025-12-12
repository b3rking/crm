<?php
ob_start();
/*$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('client',$_SESSION['ID_user'])->fetch()) 
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
}*/
?>
<input type="text" id="url" value="<?=WEBROOT?>detailClient" hidden>
<input type="text" id="session_user" value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	
                <!-- FILTRE -->
                <div class="row">
		            <div class="col-lg-2 col-md-2">
		                <div class="form-group">
		                    <input type="text" id="idclientFiltre" class="form-control" autocomplete="off" placeholder="ID et Nom client">
		                        <div id="modal"></div>
		                </div>
		            </div>
		            <div class="col-lg-2 col-md-2">
		                <div class="form-group">
		                    <select class="form-control custom-select" id="secteurfiltre">
		                    	<option value="">Secteur</option>
                                <?php
                                foreach ($equipement->selection_Secteur() as $data)
                                {?>
                                    <option value="<?=$data->ID_secteur?>"><?php echo $data->nom_secteur?></option>
                                <?php
                                }
                                ?>                       
                            </select>
		                </div>
		            </div>
		            <div class="col-lg-4 col-md-4 col-sm-6">
		                <div class="row">
		                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Creation</label>
		                    <div class="col-sm-9">
		                        <div class="form-group">
		                            <input type="date" class="form-control" name="date1" id="date1">
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-lg-2 col-md-2 col-sm-6">
		                <div class="form-group">
		                    <input type="date" class="form-control" name="date2" id="date2">
		                </div>
		            </div>
		            <div class="col-lg-1 col-md-1">
		                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success" onclick="filtreClient($('#idclientFiltre').val(),$('#secteurfiltre').val(),$('#date1').val(),$('#date2').val())"><i class="ti ti-filter"></i> Filtrer</button>
		            </div>
		            <div class="col-lg-1 col-md-1">
		                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger" onclick="resetFiltreClient()"><i class="mdi mdi-refresh"></i> Reset</button>
		            </div>
		        </div>
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>ID</th>
		                        <th>Nom</th>
		                        <th>Telephone</th>
		                        <th>Adresse</th>
		                        <th>Mail</th>
		                        <th>Mensualite</th>
		                        <th>Dette_totale</th>
		                        <th>Service</th>
		                        <th>Etat financier</th>
		                        <th>Commentaire</th>
		                        <th>Type</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>ID</th>
		                        <th>Nom</th>
		                        <th>Telephone</th>
		                        <th>Adresse</th>
		                        <th>Mail</th>
		                        <th>Mensualite</th>
		                        <th>Dette_totale </th>
		                        <th>Service</th>
		                        <th>Etat financier</th>
		                        <th>Commentaire</th>
		                        <th>Type</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php 
		                	$convert_type = '';
		                	foreach($client->recupererClientParType('gone') as $value)
		                	{
		                		$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
						        if ($solde > 0) 
						        {
									if ($value->type_client == 'paying') $convert_type = 'Payant';
									elseif ($value->type_client == 'free') $convert_type = 'Gratuit';
									else $convert_type = 'parti';
		                	?>
		                    <tr>
		                        <td><?php echo $value->ID_client?></td>
		                        <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->Nom_client;?></b></a></td>
		                        <td><?php foreach(preg_split("#[/]+#", $value->telephone) as $phone){echo $phone;}//echo $value->telephone?></td>
		                        <td><?php echo $value->adresse?></td>
		                        <td><?php foreach(preg_split("#[,]+#", $value->mail) as $value2){echo $value2;}//;echo $value->mail?></td>
		                       
		                        <td><?php
		                        $clientPaying = $client->afficherUnClentAvecContract($value->ID_client)->fetch();
		                        if (!empty($clientPaying)) echo $clientPaying['montant'].' '.$clientPaying['monnaieContract'];
		                        else echo "";
		                        ?></td>

								<td>
							<?php
								$dette = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
								if ($dette>0)
								{
							?>
							      <span class="label label-danger"><?php echo $dette.' USD';?></span>
					        <?php  
						        } 
								else
								{
									echo $dette.' USD';
								}
							?>
				
								</td>
								<td><?php
								if (!empty($clientPaying)) echo $clientPaying['nomService'];
		                        else echo "";
								?></td>
		                        <td><?php echo $value->etat?></td>
		                        <td><?php echo $value->commentaire?></td>
		                        <td><?php echo $convert_type?></td>
		                    </tr>

		                    <?php
	                    		}
	               			}
		               		?><!-- END FOREACH-->
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