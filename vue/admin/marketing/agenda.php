<?php
ob_start();
?> 
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card-body">
                            <h4 class="card-title m-t-10">Glisser l'événement et déposer</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="calendar-events" class="">
                                        <div class="calendar-events" data-class="bg-primary" ><i class="fa fa-circle text-info"></i> Mon premier evenement</div>
                                        <div class="calendar-events" data-class="bg-success"><i class="fa fa-circle text-success"></i> Mon deuxieme evenement</div>
                                        <div class="calendar-events" data-class="bg-danger"><i class="fa fa-circle text-danger"></i> My Event Three</div>
                                        <div class="calendar-events" data-class="bg-warning"><i class="fa fa-circle text-warning"></i> My Event Four</div>
                                    </div>
                                    <!-- checkbox -->
                                    <div class="checkbox m-t-20">
                                        <input id="drop-remove" type="checkbox">
                                        <label for="drop-remove">
                                            Enlever après avoir glisser
                                        </label>
                                    </div>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-10 btn-info btn-block waves-effect waves-light">
                                            <i class="ti-plus"></i> Ajouter sur les evenements
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-body b-l calender-sidebar">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN MODAL -->
<div class="modal none-border" id="my-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Nouvel evenement</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary save-event waves-effect waves-light" >Creer evenement</button>
                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Supprimer</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Category -->
<div class="modal fade none-border" id="add-new-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Ajouter</strong> a la liste de categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Nom categorie</label>
                            <input class="form-control form-white" placeholder="Entrer le nom de la categorie" type="text" name="category-name" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Choisir la couleur de la categorie</label>
                            <select class="form-control form-white" data-placeholder="Choisir la couleur..." name="category-color">
                                <option value="success">Success</option>
                                <option value="danger">Danger</option>
                                <option value="info">Info</option>
                                <option value="primary">Primary</option>
                                <option value="warning">Avertissement</option>
                                <option value="inverse">Inverse</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect waves-light save-category" data-dismiss="modal" >Enregistrer</button>
                <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
<?php
/*$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');*/
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>