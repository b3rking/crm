
<div class="table-responsive">
    <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    
                    <!-- /.modal -dialog -->
                </div><table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded footable" data-page-size="10">
        <thead>
            <tr>
                <th class="footable-sortable">Detail<span class="footable-sort-indicator"></span></th>
                <th class="footable-sortable">Contenu<span class="footable-sort-indicator"></span></th>
                
            </tr>
        </thead>

        <tbody id="rep">
             <!-- Example single danger button -->
             

             <button type="button" class="btn btn-primary btn-rounded" onclick="" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-check" ></i>nouvelle action de ticket</button><!--ton type="button" class="btn waves-effect waves-light btn-rounded btn-warning">autre description</button> -->    
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
                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-find-replace"></i></span></div>
                            <select id="endroit" class="form-control"><option value="in door">In door</option>
                                    <option value="Out door">Out door</option>
                                    </select>
                            <input type="text" id="idticket" class="form-control" value="<?php echo $id?>" hidden>
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-lg-6 ">
                <div class="form-group row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Utilisateur</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-human-male-female"></i></span></div>
                            <select id="user" class="form-control"><option value="hamed">hamed</option>
                            <option value="gabi">gabi</option>
                        </select>
                        <input type="text" value="<?php echo date('Y-m-d')?>" class="form-control" id="date_fermeture" hidden>
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
                </div>
            </div>    
        </div>
        <div class="row">
            <label class="btn btn-info active">
                <input type="checkbox" id="dernierAction"> dernière action
            </label> 
        </div>
                                                      
                            </form>
<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Basic Table</h4>
            <h6 class="card-subtitle">Add class <code>.table</code></h6>
            <div class="able-rtesponsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Adresse</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Deshmukh</td>
                            <td>Prohaska</td>
                            <td>@Genelia</td>
                            <td><span class="label label-danger">admin</span> </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Deshmukh</td>
                            <td>Gaylord</td>
                            <td>@Ritesh</td>
                            <td><span class="label label-info">member</span> </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Sanghani</td>
                            <td>Gusikowski</td>
                            <td>@Govinda</td>
                            <td><span class="label label-warning">developer</span> </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Roshan</td>
                            <td>Rogahn</td>
                            <td>@Hritik</td>
                            <td><span class="label label-success">supporter</span> </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Joshi</td>
                            <td>Hickle</td>
                            <td>@Maruti</td>
                            <td><span class="label label-info">member</span> </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Nigam</td>
                            <td>Eichmann</td>
                            <td>@Sonu</td>
                            <td><span class="label label-success">supporter</span> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</di>


