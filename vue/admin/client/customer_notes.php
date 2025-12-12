<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header" style="background-color: #ef7f22;height: 1.5rem;padding-top: 0.1rem">
                <h6 class="text-white">NOTES</h6>
                <span id="msg"></span>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-lgs-note"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i> Ajouter une note  </button><br>
                <!-- Modal -->
                <div class="modal fade bs-example-modal-lgs-note" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lgs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Creation de la note</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <input type="text" id="refclient" value="<?=$id?>" class="form-control"hidden>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" id="note_description" placeholder="Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- END ROW-->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <span id="msg"></span>
                                <button type="button" style="background-color: #8b4513"class="btn text-white" onclick="createCustomerNote('<?=$id?>',$('#note_description').val(),$('#iduser').val())"> <i class="fa fa-check"></i> Attribuer</button>
                                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!--/.modal-dialog -->
                </div>
                <div class="table-responsive m-t-0">
                    <table id="customer_note_table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Creer par </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Creer par</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep_note">
                        <?php
                        foreach ($customerNote->getCustomerNoteByClient($id) as $value) 
                        {
                        ?>
                            <tr>
                                <td><?=$value->created_at?></td>
                                <td><?=$value->description?></td>
                                <td><?=$value->nom_user?></td>
                                <td>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    
                                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
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
    </div>
</div><!-- /.row-->