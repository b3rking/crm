<?php
ob_start();
?>

<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body printableArea">
            <h3><b>INFORMATION DE L'ENTREPRISE'</b></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#showinfo" role="tab">Affichage et Modification</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#createinfo" role="tab">Creation</a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="showinfo" role="tabpanel">
                                <div class="card-body">
                                    <div id="rep"></div>
                                    <form class="form-horizontal form-material">
                            <?php foreach ($user->getInfoSociete() as $value) 
                            {
                                ?>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Nom</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="shownom" class="form-control form-control-line" value="<?=$value->nom?>">
                                        <input type="text" id="id_societe" value="<?=$value->ID_societe?>" hidden>
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Adresse complete</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="showadresse" class="form-control form-control-line" value="<?=$value->localisation?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 form-group">
                                    <b>Ville</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="ville" class="form-control form-control-line" value="<?=$value->ville?>">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Phone</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="showphone" class="form-control form-control-line" value="<?=$value->phone?>">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Email</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="mail" id="showmail" class="form-control form-control-line" value="<?=$value->email?>">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Boite Postal</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="number" id="showboitepostal" class="form-control form-control-line" value="<?=$value->boitePostal?>">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Nif</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="shownif" class="form-control form-control-line" value="<?=$value->nif?>">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Centre fiscal</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="showcentreFiscal" class="form-control form-control-line" value="<?=$value->centreFiscal?>">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Secteur d'activite</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="showsecteur" class="form-control form-control-line" value="<?=$value->secteurActivite?>">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-lg-2 form-group">
                                    <b>Forme juridique</b> </div>
                                    <div class="col-lg-10 form-group">
                                        <input type="text" id="showformejuridique" class="form-control form-control-line" value="<?=$value->formeJuridique?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="button" style="background-color: #8b4513" class="btn font-light text-white" onclick="updateInfoSociete($('#id_societe').val(),$('#shownom').val(),$('#ville').val(),$('#showadresse').val(),$('#showphone').val(),$('#showmail').val(),$('#shownif').val(),$('#showcentreFiscal').val(),$('#showsecteur').val(),$('#showboitepostal').val(),$('#showformejuridique').val())">Modifier
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }?>
                            </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="createinfo" role="tabpanel">
                                <div class="card-body">
                                    <form class="form-horizontal form-material">
                                    	<div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Nom</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="text" id="nom" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Adresse complete</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="text" id="adresse" class="form-control form-control-line">
		                                    </div>
		                                </div>
                                         <div class="row">
                                            <div class="col-lg-2 form-group">
                                            <b>Ville</b> </div>
                                            <div class="col-lg-10 form-group">
                                                <input type="text" id="ville" class="form-control form-control-line">

                                            </div>
                                        </div>
                                        <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Phone</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="text" id="phone" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Email</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="mail" id="mail" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Boite Postal</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="number" id="boitepostal" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Nif</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="text" id="nif" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Centre fiscal</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="text" id="centreFiscal" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Secteur d'activite</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="text" id="secteur" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
		                                	<div class="col-lg-2 form-group">
		                                    <b>Forme juridique</b> </div>
		                                    <div class="col-lg-10 form-group">
		                                        <input type="text" id="formejuridique" class="form-control form-control-line">
		                                    </div>
		                                </div>
		                                <div class="row">
	                                        <div class="form-group">
	                                            <div class="col-sm-12">
	                                                <button type="button"style="background-color: #8b4513" class="btn font-light text-white" onclick="creerInfoSociete($('#nom').val(),$('#adresse').val(),$('#ville').val(),$('#phone').val(),$('#mail').val(),$('#nif').val(),$('#centreFiscal').val(),$('#secteur').val(),$('#boitepostal').val(),$('#formejuridique').val())">Ajouter
	                                                </button>
	                                            </div>
	                                        </div>
	                                    </div>
                                    </form>
                                </div>
                            </div>
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