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
                <h2 class="text-themecolor">Validation du prospect</h2>
            </div>

        </div>

        <form  class="form-horizontal p-t-20">
                                     <!-- Debut premiere ligne-->
       <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">nom prospect</label>
                    

                    <div class="form-group col-sm-9">
                        <input type="text" id="idprospect" class="form-control" autocomplete="off"> 
                            <div id="modal"></div>
                    </div>
                </div>
            </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Localisation</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                    <select  class="form-control" id="location">
                                    <?php 
                                        foreach ($marketing->selectionLocalisationProspect() as $value)
                                        {?>
                                        <option value="<?php echo $value->ID_localisation?>"><?php echo $value->nom_localisation?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">NIF</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <input type="number" id="nif" class="form-control">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                            <select class="form-control" id="langue">
                                                    <option value="francais">Francais</option>
                                                    <option value="anglais">Anglais</option>
                                            </select>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label"></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="btn btn-purple active">
                                                <input type="checkbox" id="assujettitva"> Assujetti a la TVA
                                        </label> 
                                        </div>
                                      
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Type</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                            <select class="form-control" id="type">
                                                <option></option>
                                            <?php foreach ($marketing->recupererTypes() as $value) : ?>
                                                 <option value="<?=$value->ID_type?>"><?=$value->libelle?></option>
                                            <?php
                                            endforeach
                                                        ?>
                                            </select>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

        </div>
        <div class="container">

<div class="row">
              <div class="col">
           </div>
        <div class="col">
            <button  type="button" class="btn text-white" onclick="valideprospect($('#idprospect').val(),$('#location').val(),$('#nif').val(),$('#langue').val(),$('#type').val())">Valider ce prospect </button>
        </div>
          
        </div>
         
     
        </div>
 
      
       
        </form>
    </div>
        </div>
    </div>
    
</div>
<?php
$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');
?>