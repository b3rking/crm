<?php
ob_start(); 
$l = false; 
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
}
$etat_array = ['actif','coupure','pause','terminer','N/A'];
if(isset($_POST["export"])) 
{
    
    $fileName = "liste-des-clients-".date('Y').".xls";

    //Set header information to export data in excel format
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$fileName);

    //Add the MySQL table data to excel file
    if(!empty($result)) 
    {
        $total_usd = 0;
        $total_bif = 0;
        echo implode("\t", ["ID","NOM","ETAT","TYPE","MENSUALITE","MONNAIE","JUIN","JUILLET","AOUT","SEPTEMBRE","OCTOBRE","NOVEMBRE","DECEMBRE"]) . "\n";
      
        foreach($result as $item) 
        {
            //$prixTva = $item->montant*18/100;
            $total_bif += $item->monnaie == 'BIF' ? $item->montant:$item->montant*2000;
            //$total_usd += $item->monnaie == 'USD' ? $item->montant*2000:0;
            $montant = $item->monnaie == 'BIF' ? $item->montant:$item->montant*2000;
            
            echo implode("\t", [$item->billing_number,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $item->Nom_client),$item->etat,$item->type_client,$item->montant,$item->monnaie,"","","","","","",""]) . "\n";
        }
        echo implode("\t", ["TOTAL BIF","",round($total_bif),"","","","","","","","","","",""]) . "\n";
        echo implode("\t", ["TOTAL USD","",round($total_usd),"","","","","","","","","","",""]) . "\n";
    }
    exit();
}

?>
<input type="text" id="url" value="<?=WEBROOT?>detailClient" hidden>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="profil_name" value="<?=$_SESSION['profil_name'];?>"hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
    	<a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
            if ($c) 
        	{?>
        		<ol class="breadcrumb">
	                <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>
	                <!--<li class="breadcrumb-item active">Client</li>-->
	            </ol>
            	<button type="button" style="background-color: #7c4a2f" class="btn d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Ajouter client</button>
        	<?php
            }
            ?>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau Client</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body modal-bg-color">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                            	<div class="row">
				                		<div class="col-lg-6 col-md-6">
	                                        <div class="form-group row">
	                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Genre client</label>
	                                            <div class="col-sm-9">
	                                                <div class="input-group">
                                            <select class="form-control" id="genre" onchange="differencier_client($(this).val())">
                                              <option></option>
                                              <option value="personnel">Particulier</option>
                                              <option value="societe">Societé</option>
                                            </select>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
				                	</div>
				                	<div class="row" id="affiche_genre_client">
	                                    <!--div class="col-lg-6 col-md-6" id="affiche_genre_client"></div-->
	                                </div>
                            	<!--div class="row">
                            		<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Nom complet*</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" maxlength="100" class="form-control" id="nom" placeholder="Nom complet">
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
		                                            <input type="text" class="form-control" id="pers_cont" placeholder="Personne de contact">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
                            	</div-->
                            	
	                            <div class="row">
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="control-label">Telephone mobile</label>
                                            <input type="text" class="form-control" id="phone_mobile" placeholder="Telephone mobile">
		                                </div>
	                            	</div>
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="control-label">Telephone fixe</label>
                                            <input type="text" class="form-control" id="phone_fixe" placeholder="Telephone fixe">
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="control-label">Email</label>
                                            <input type="text" class="form-control" id="email" placeholder="adresse email">
		                                </div>
	                            	</div>
	                            	<!--<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">    
		                                    <div class="col-sm-3">
		                                    	<input type="text" id="nbemail" hidden="hidden">
		                                    	<button type="button" style="background-color: #7c4a2f" class="btn font-light text-white" onclick="addMailAdress()">
		                                    		<i class="ti-email"></i>
		                                            <i class="ti-plus text"></i>
		                                        </button>
		                                    </div>
		                                </div>
		                                <div id="divAddMail"></div>
	                            	</div>-->
	                            </div><!-- End row-->

	                            <div class="row">
	                            	<div class="col-lg-4 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="control-label">Adresse*</label>
	                                        <input type="text" maxlength="59" class="form-control" id="adrs" placeholder="adresse">
		                                </div>
	                            	</div>
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="control-label">Type*</label>
                                <select class="form-control" id="type">
                                	<?php foreach ($type->recupererTypes() as $value) : ?>
                                		
                                		<option value="<?=$value->libelle?>"><?=$value->equivalent?></option>
                                	<?php
                                	 endforeach
                                	?>
                                </select>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="control-label">Localisation*</label>
	                                        <select  class="form-control" id="location">
                                           	<?php 
                                           	foreach ($localisation->selectionLocalisation() as $val2)
                                            {?>
                                           		<option value="<?php echo $val2->ID_localisation?>"><?php echo $val2->nom_localisation?></option>
                                       		<?php
                                           	}
                                           	?>
                                            </select>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-2 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="control-label">Langue</label>
		                                    <select class="form-control" id="langue">
                                            	<option value="francais">Francais</option>
                                            	<option value="anglais">Anglais</option>
	                                        </select>
		                                </div>
	                            	</div>
	                            </div><!-- End row -->
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">NIF</label>
		                                    <div class="col-sm-9">
	                                            <input type="text" maxlength="59" class="form-control" id="nif" placeholder="NIF">
		                                    </div>
		                                </div>
	                            	</div>
	                            	<!--<div class="col-lg-6 col-md-6">
							    		<div class="form-group row">
											<div class="col-sm-9">
												<label style="background-color: #7c4a2f" class="btn active font-light text-white">
												<input type="checkbox" id="tva" > Assujetti a la TVA</label>
											</div>
										</div>
									</div>-->
								</div>
	                            <div class="row">
	                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xlg-12">
	                            		<div class="form-group row">
		                                    
		                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
		                                            <textarea maxlength="245" class="form-control" placeholder="Commentaire" id="note"></textarea>
		                                            <input type="text" id="etat" value="N/A"hidden>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                        	<span id="msg"></span>
                            <!--button style="background-color: #8b4513" class="btn d-lg-block m-l-15 font-light text-white" onclick="saveClient($('#nom').val(),$('#pers_cont').val(),$('#nbphone').val(),$('#nbemail').val(),$('#adrs').val(),$('#type').val(),$('#location').val(),$('#langue').val(),$('#nif').val(),$('#note').val(),$('#etat').val())"><i class="fa fa-check"></i>Enregistrer
     						</button-->
     						<button style="background-color: #7c4a2f" class="btn d-lg-block m-l-15 font-light text-white" onclick="saveClient($('#genre').val(),$('#adrs').val(),$('#type').val(),$('#location').val(),$('#langue').val(),$('#nif').val(),$('#note').val(),$('#etat').val())"><i class="fa fa-check"></i>Enregistrer
     						</button>
                 			<button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline" ></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <button type="button" style="background-color: #7c4a2f" class="btn d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="mdi mdi-gmail"></i> Informer client</button>

            <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
			  <div class="modal-dialog modal-lgs">
			    <div class="modal-content">
			        <div class="modal-header">
				        <h4 class="modal-title" id="myLargeModalLabel">Informer les clients</h4>
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			        </div>
			        <div class="modal-body">
			        	<form class="form-horizontal p-t-20" id="sendMailToClientForm" enctype="multipart/form-data" method="post" action="<?=WEBROOT?>sendMailToClient">
			        	<div class="row">
				            <div class="col-lg-12 col-md-12">
				              <div class="form-group row">
				                <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode </label>
				                <div class="col-sm-9">
				                	<select class="form-control" id="sendmode" name="sendmode">
				                		<option value=""></option>
				                		<option value="mail">email</option>
				                		<option value="sms">sms</option>
				                	</select>
				                </div>
				              </div>
				            </div>
			          	</div>
			          	<div class="row">
				            <div class="col-lg-12 col-md-12">
				              <div class="form-group row">
				                <label for="exampleInputEmail3" class="col-sm-3 control-label">Sujet </label>
				                <div class="col-sm-9">
			                    	<input type="text" class="form-control" name="sujet" id="sujet" name="sujet">
				                </div>
				              </div>
				            </div>
			          	</div>
			          	<div class="row">
				            <div class="col-lg-12 col-md-12">
				              <div class="form-group row">
				                <label for="exampleInputEmail3" class="col-sm-3 control-label">Message</label>
				                <div class="col-sm-9">
				                    <textarea class="form-control" name="message" id="message" cols="50" rows="5"></textarea>
				                </div>
				              </div>
				            </div>
			          	</div>
			          	<div class="row">
				            <div class="col-lg-12 col-md-12">
				              <div class="form-group row">
				                <label for="exampleInputEmail3" class="col-sm-3 control-label">Attachement</label>
				                <div class="col-sm-9">
				                    <input type="file" name="attachFile" class="form-control">
				                </div>
				              </div>
				            </div>
			          	</div>
			          	<div class="row">
				            <div class="col-lg-6 col-md-6">
				              <div class="form-group row">
				                <label for="exampleInputEmail3" class="col-sm-3 control-label">Secteur </label>
				                <div class="col-sm-9">
			                    	<select class="form-control" id="sendsecteur" name="sendsecteur">
			                    		<option value=""></option>
			                    		<?php
                                        foreach ($equipement->selection_Secteur() as $data)
                                        {?>
                                            <option value="<?php echo $data->ID_secteur?>"><?php echo $data->ID_secteur.'-'.$data->nom_secteur?></option>
                                        <?php
                                        }
                                        ?>
			                    	</select>
				                </div>
				              </div>
				            </div>
				            <div class="col-lg-6 col-md-6">
				            	<label class="btn">
                                    <input type="checkbox" id="sendForAll" name="sendForAll"> Tous les clients
                                </label>
				            </div>
			          	</div>
			        </form>
			        </div>
			        <div class="modal-footer">
			        	<span id="sendmail-response"></span>
			            <button type="button" style="background-color: #8b4513" class="btn waves-effect text-left font-light text-white" onclick="sendMailToClient($('#sujet').val(),$('#message').val(),$('#sendmode').val(),$('#sendsecteur').val())">Envoyer
			            </button>
			            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
			        </div>

			    </div>
			  </div>
			</div><!--./modal-->
			 <button type="button" style="background-color: #7c4a2f" class="btn d-lg-block m-l-15 font-light text-white" onclick="printFiltreClient()"><i class="fa fa-file"></i> Générer pdf</button>
			<form class="form-horizontal p-t-0" action="<?=WEBROOT?>printFiltreClient" method="post" id="form-filtreClient">
            	<input type="text" id="cond" name="cond" hidden="">
            </form>
            <a href="<?=WEBROOT?>tousClient" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15">Tous les clients </a>
             <!-- <form method='post' action="<?=WEBROOT?>printCsv"> -->
             	<form action="#" method="post">
               <button type="submit" style="background-color: #7c4a2f" class="btn btn- text-white d-none d-lg-block m-l-15" name="export"><i class="mdi mdi-printer"></i> Exporter vers excel</button> 
            </form>
			<!--button type="button"  style="background-color: #7c4a2f" class="btn d-lg-block m-l-15 font-light text-white" onclick="printFiltreClient()"><i class="fa fa-file"></i> Générer pdf</button-->
            
        <!--button type="button"  style="background-color: #7c4a2f" class="btn d-lg-block m-l-15 font-light text-white" onclick="exportFiltreClientAsExcel()"><i class="fa fa-file"></i> Générer Excel</button>
            
			<form class="form-horizontal p-t-0" action="<?=WEBROOT?>printFiltreClient" method="post" id="form-filtreClient">
            	<input type="text" id="cond" name="cond" hidden="">
            </form>
            
              <form method='post' action="<?=WEBROOT?>printCsv"> 
             	<form action="#" method="post"> 
               <button type="submit" style="background-color: #8b4513" class="btn btn- text-white d-none d-lg-block m-l-15" name="export"><i class="mdi mdi-printer"></i> Exporter vers excels</button-->  
            </form>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<?php
		    	if ($l) 
	    		{?>
		    	<div class="row m-t-0">
		    		<!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><?php
                                $nbclient = 0;
                                if ($data = $client->nombre_total_Client()->fetch()) 
                                {
                                	$nbclient = $data['nbclient'];
                                ?>
                                    <!--<button type="button" class="btn btn-sm btn-rounded btn-info" onclick="recupererClients()">Tous <= $data['nbclient']?></button>-->
                                    <button type="button" class="btn btn-sm btn-rounded btn-info">Tous <?= $data['nbclient']?></button>
                                <?php
                                }
                                ?></h1>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-3 col-lg-2 col-xlg-3">
                        <div class="card">
                            <div style="background-color: #00a29b" class="box text-center">
                                <h1 class="font-light text-white"><?php
                                $nbclient = 0;
                                if ($data = $type->nombreClientParType('free')->fetch()) 
                                {
                                	$nbclient = $data['nbclient'];
                                ?>
                                    <!--<button type="button" style="background-color: #00a29b" class="btn btn-sm btn-rounded text-white" onclick="recupererClientParType('free')">Gratuit<= $data['nbclient']?></button>-->
                                    <button type="button" style="background-color: #00a29b" class="btn btn-sm btn-rounded text-white">Gratuit<?= $data['nbclient']?></button>
                                <?php
                                }
                                ?></h1>
                            </div>
                        </div>
                    </div> 
                    <!--<div class="col-md-3 col-lg-1 col-xlg-2">
                        <div class="card">
                            <div style="background-color: #00a22b" class="box text-center">

                                <h1 class="font-light text-white"><php
                                $nbclient = 0;
                                if ($data = $type->nombreClient_gratuit_termineted()->fetch()) 
                                {
                                	$nbclient = $data['nbclient'];
                                ?>
                                <form action="<=WEBROOT?>printCustomer" method="get" id="printCustomer">

                                </form>
                                    <button type="button" style="background-color: #00a22b" class="btn btn-sm btn-rounded text-white" onclick="nombreClient_gratuit_termineted()">G /Ted <= $data['nbclient']?></button>
                                <php
                                }
                                ?></h1>
                            </div>
                        </div>
                    </div>-->
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card">
                            <div style="background-color: #EF7F22" class="box text-center">
                                <h1 class="font-light text-white"><?php
                                $nbclient = 0;
                                if ($data = $type->nombreClientParType('paying')->fetch()) 
                                {
                                	$nbclient = $data['nbclient'];
                                ?>
                                    <!--<button type="button" style="background-color: #EF7F22" class="btn btn-sm btn-rounded text-white" onclick="recupererClientParType('paying')">Payant <= $data['nbclient']?></button>-->
                                    <button type="button" style="background-color: #EF7F22" class="btn btn-sm btn-rounded text-white">Payant <?= $data['nbclient']?></button>
                                <?php
                                }
                                ?></h1>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card">
                            <div style="background-color: #7c4a2f" class="box bg- text-center">
                                <h1 class="font-light text-white"><?php
                                $nbclient = 0;
                                if ($data = $type->nombreClientParType('potentiel')->fetch()) 
                                {
                                	$nbclient = $data['nbclient'];
                                ?>
                                    <!--<button type="button" style="background-color: #7c4a2f" class="btn btn-sm btn-rounded text-white" onclick="recupererClientParType('potentiel')">Potentiel <= $data['nbclient']?></button>-->
                                    <button type="button" style="background-color: #7c4a2f" class="btn btn-sm btn-rounded text-white">Potentiel <?= $data['nbclient']?></button>
                                <?php
                                }
                                ?></h1>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card">
                            <div class="box bg-dark text-center">
                                <h1 class="font-light text-white"><?php
                                $nbclient = 0;
                                if ($data = $type->nombreClientParType('staff')->fetch()) 
                                {
                                	$nbclient = $data['nbclient'];
                                ?>
                                    <!--<button type="button" class="btn btn-sm btn-rounded btn-dark" onclick="recupererClientParType('staff')">Staff <= $data['nbclient']?></button>-->
                                    <button type="button" class="btn btn-sm btn-rounded btn-dark">Staff <?= $data['nbclient']?></button>
                                <?php
                                }
                                ?></h1>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card">
                            <div class="box bg-danger text-center">
                                <h1 class="font-light text-white"><?php
                                $nbclient = 0;
                                if ($data = $type->nombreClientParType('gone')->fetch()) 
                                {
                                	$nbclient = $data['nbclient'];
                                ?>
                                    <!--<button type="button" class="btn btn-sm btn-rounded btn-danger" onclick="recupererClientParType('gone')">Clients parti <= $data['nbclient']?></button>-->
                                    <button type="button" class="btn btn-sm btn-rounded btn-danger" onclick="recupererClientParType('gone')">Clients parti <?= $data['nbclient']?></button>
                                <?php
                                }
                                ?></h1>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                     <!-- FILTRE -->
            <form action="<?=WEBROOT?>filtreClient" method="get" id="filtreClient">
                <div class="row m-t-5">
                	<div class="col-lg-1 col-md-2">
		                <div class="form-group">
		                    <input type="text" name="billing_number" id="billingNumberFiltre" class="form-control form-control-sm input-filter" autocomplete="off" placeholder="Billing number" <?php if (!empty($billing_number)) {
		                    	?>
		                    	value="<?=$billing_number?>"
		                    	<?php
		                    }?>>
		                </div>
		            </div>
		            <div class="col-lg-2 col-md-2">
		                <div class="form-group">
		                    <!--<input type="text" id="idclientFiltre" class="form-control form-control-sm input-filter" autocomplete="off" placeholder="Nom client">-->
		                    <input type="text" name="nom_client" id="Nom_client_filtre" class="form-control form-control-sm input-filter" autocomplete="off" placeholder="Nom client" <?php if (!empty($nom_client)) {
		                    	?>
		                    	value="<?=$nom_client?>"
		                    	<?php
		                    }?>>
		                        <!--<div id="modal"></div>-->
		                </div>
		            </div>
		            <div class="col-lg-1 col-md-2">
		                <div class="form-group">
		                    <select class="form-control form-control-sm input-filter" name="secteur" id="secteurfiltre">
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
		            <!--<div class="col-lg-4 col-md-4 col-sm-6">
		                <div class="row p-0">
		                    <label for="exampleInputEmail3" class="col-sm-3 col-lg-3 control-label">Creation</label>
		                    <div class="col-sm-9 col-lg-9">
		                        <div class="form-group">
		                            <input type="date" class="form-control form-control-sm input-filter" name="date1" id="date1">
		                        </div>
		                    </div>
		                </div>
		            </div>-->
		            <div class="col-lg-2 col-md-2 col-sm-6">
		                <div class="form-group">
		                    <input type="date" class="form-control form-control-sm input-filter" name="date1" id="date1" <?php if (!empty($date1)) {
		                    	?>
		                    	value="<?=$date1?>"
		                    	<?php
		                    }?>>
		                </div>
		            </div>
		            <div class="col-lg-2 col-md-2 col-sm-6">
		                <div class="form-group">
		                    <input type="date" class="form-control form-control-sm input-filter" name="date2" id="date2" <?php if (!empty($date2)) {
		                    	?>
		                    	value="<?=$date2?>"
		                    	<?php
		                    }?>>
		                </div>
		            </div>
		            <div class="col-lg-1 col-md-2 col-sm-6">
		                <div class="form-group">
		                    <select class="form-control form-control-sm input-filter" name="filter_type" id="filter_type">
		                    	<option value="">Type</option>
		                    	<?php 
		                    	foreach ($type->recupererTypes() as $value)
		                    	{
		                    		if ($typeClient == $value->libelle) 
		                    		{
                    			?>
		                    			<option value="<?=$value->libelle?>" selected><?=$value->equivalent?></option>
                    			<?php
		                    		}
		                    		else
		                    		{
                    			?>
		                    			<option value="<?=$value->libelle?>"><?=$value->equivalent?></option>
                    			<?php
		                    		}
                            	}
                            	?>
		                    </select>
		                </div>
		            </div>
		            <div class="col-lg-1 col-md-2 col-sm-6">
		                <div class="form-group">
		                    <select class="form-control form-control-sm input-filter" name="status" id="filter_status">
		                    	<option value="">Etat</option>
		                    	<?php
		                    	for ($i=0;$i < count($etat_array);$i++) 
		                    	{
		                    		if ($status == $etat_array[$i]) 
		                    		{
                    			?>
		                    			<option value="<?=$etat_array[$i]?>" selected><?=$etat_array[$i]?></option>
                    			<?php
		                    		}
		                    		else
		                    		{
                    			?>
		                    			<option value="<?=$etat_array[$i]?>"><?=$etat_array[$i]?></option>
                    			<?php
		                    		}
		                    	}
		                    	?>
		                    	<!--<option value="">Etat</option>
		                    	<option value="actif">Actif</option>
		                    	<option value="coupure">Coupure</option>
		                    	<option value="pause">Pause</option>
		                    	<option value="terminer">Terminer</option>
		                    	<option value="N/A">N/A</option>-->
		                    </select>
		                    <input type="text" name="print" id="print" value="0" hidden="">
                            <input type="text" name="asExcel" id="asExcel" value="0" hidden="">
		                </div>
		            </div>
		            <div class="col-lg-1 col-md-1">
		                <!--<button type="button" style="background-color: #7c4a2f" class="btn waves-effect waves-light btn-sm text-white" onclick="filtreClient($('#Nom_client_filtre').val(),$('#secteurfiltre').val(),$('#date1').val(),$('#date2').val(),$('#billingNumberFiltre').val(),$('#profil_name').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
		                <button type="submit" style="background-color: #7c4a2f" class="btn waves-effect waves-light btn-sm text-white"><i class="ti ti-filter"></i> Filtrer</button>
		            </div>
		            <div class="col-lg-1 col-md-1">
		                <button type="button" class="btn waves-effect waves-light  btn-sm btn-dark" onclick="resetFiltreClient()"><i class="mdi mdi-refresh"></i> Reset</button>
		            </div>
		        </div>
		      </form>

		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
		                	
		                    <tr>
		                        <th>ID</th>
		                        <th>Nom</th>
		                        <th>Telephone</th>
		                        <!--th>Adresse</th>
		                        <th>Mail</th-->
		                        <?php
		                       
		                        if($_SESSION['profil_name'] != 'Technicien' && $_SESSION['profil_name'] != 'coordination') 
        							{
        						?>
		                        <th>Mensualite</th>
		                        <th>Solde</th>
		                       <?php
		                   			}
		                  		  ?>
		                        <th>Service</th>
		                        <th>Etat financier</th>
		                        <!--th>Commentaire</th-->
		                        <th>Type</th>
		                        <th></th>
		                    </tr>
		                </thead>
		                <tfoot>
		                     <tr>
		                        <th>ID</th>
		                        <th>Nom</th>
		                        <th>Telephone</th>
		                        <!--th>Adresse</th>
		                        <th>Mail</th-->
		                        <?php
		                         
		                        if($_SESSION['profil_name'] != 'Technicien' && $_SESSION['profil_name'] != 'coordination') 
        							{
        						?>
		                        <th>Mensualite</th>
		                        <th>Solde</th>
		                       <?php
		                   			 }
		                  		  ?>
		                        <th>Service</th>
		                        <th>Etat financier</th>
		                        <!--th>Commentaire</th-->
		                        <th>Type</th>
		                        <th></th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	
		                	<?php 
		                	$i = 0;
		                	$convert_type = '';

		                	foreach($result as $value)
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
		                        <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->Nom_client;?></b></a></td>
		                        <td><?php 
		                        foreach(preg_split("#[/]+#", $value->telephone) as $phone){echo $phone;
		                        }
		                        echo "\n".$value->mobile_phone;
		                        //echo $value->telephone?></td>
		                        <!--td><php echo $value->adresse?></td>
		                        <td><php foreach(preg_split("#[,]+#", $value->mail) as $value2){echo $value2;}//;echo $value->mail?></td-->
		                       <?php
		                         if($_SESSION['profil_name'] != 'Technicien' && $_SESSION['profil_name'] != 'coordination') 
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
        		<div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputuname3" class="col-sm-3 control-label">Genre client</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="genre<?=$i?>" onchange="differencier_client($(this).val())">
                            	<?php
                            	if ($value->genre == 'personnel') 
                            	{
                        		?>
                            	 	<option value="personnel" selected="">Particulier</option>
                            		<option value="societe">Societé</option>
                        	 	<?php
                            	}
                            	else
                            	{
                        		?>
                            		<option value="personnel">Particulier</option>
                            		<option value="societe" selected>Societé</option>
                            	<?php
                            	} 
                            	?>
                            </select>
                        </div>
                    </div>
                </div>
        	</div>
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
	<!--<div class="col-lg-3 col-md-3">
		<div class="form-group row">
		    <label for="exampleInputuname3" class="col-sm-4 control-label">Assujetti a la tva</label>
		    <div class="col-sm-9">
        	<php 
        		if($value->assujettiTVA =='oui')
        		{?>
        			<label style="background-color: #8b4513" class="btn active font-light text-white"><input type="checkbox" id="tva<=$i?>" checked> Assujetti a la TVA</label> 
        		<php
        		}
        		else
        		{?>
        		<label style="background-color: #8b4513" class="btn active font-light text-white"><input type="checkbox" id="tva<=$i?>"> Assujetti a la TVA</label> 
        		<php	
        		}
        		?>
		    </div>
		</div>
    </div>-->
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
            	<button class="btn text-white" style="background-color: #8b4513" onclick="updateClient($('#genre<?=$i?>').val(),$('#idclient<?=$i?>').val(),$('#nom<?=$i?>').val(),$('#pers_cont<?=$i?>').val(),$('#fixed_phone<?=$i?>').val(),$('#mobile_phone<?=$i?>').val(),$('#mail<?=$i?>').val(),$('#langue<?=$i?>').val(),$('#billing<?=$i?>').val(),$('#adrs<?=$i?>').val(),$('#type<?=$i?>').val(),$('#newtype<?=$i?>').val(),$('#location<?=$i?>').val(),$('#nif<?=$i?>').val(),$('#<?=$i?>').val(),$('#note<?=$i?>').val(),$('#profil_name<?=$i?>').val())" data-dismiss="modal">Modifier
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
		                </tbody>
		            </table>
		        </div>
		        <?php
		    	}
		    	?>
		    </div>
		</div>
	</div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>