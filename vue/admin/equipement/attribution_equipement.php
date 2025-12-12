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
                <h2 class="text-themecolor">Attribution equipement a un client</h2>
            </div>

        </div>

        <form  class="form-horizontal p-t-20">
                                     <!-- Debut premiere ligne-->
       <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
                    <div class="form-group col-sm-9">
                        <input type="text" id="idclient" name="idclient" class="form-control" autocomplete="off">
                            <div id="modal"></div>
                    </div>
                </div>
            </div>
              <div class="col-lg-6 col-md-6">
                <div class="row">
                 <label for="exampleInputEmail3" class="col-sm-3 control-label">Antenne : </label>
                    <div class="col-sm-9">

                        <div class="form-group">
                            <input type="text" id="page" value="attribution_equipement" hidden="">
                            <select class="form-control"  id="antenne">
                                <option></option>
                                 <?php
                                foreach ($equipement->recupererAntennes() as $value)
                                {
                                ?>
                            <option value="<?php echo $value->ID_equipement?>">
                                
                                <?php echo $value->model.' / '.$value->mac?>
                                </option>                  
                             <?php
                                }
                                ?>
                            </select>
                        </div>                  
                    </div>
                </div>
            </div>
            
         
        </div>
        
         <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    
                    <div class="form-group col-sm-9">
                        
                    </div>
                </div>
            </div>
           <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Routeur : </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <select class="form-control"  id="routeur">
                                <option></option>
                                 <?php
                                foreach ($equipement->recupererRouteur() as $value)
                                {
                                ?>
                            <option value="<?php echo $value->ID_equipement?>">
                                
                                <?php echo $value->model.' / '.$value->mac?>
                                </option>                  
                             <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
            <div  class="col-lg-6 col-md-6"></div>

             <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Switch: </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                             <select class="form-control"  id="switchSP">
                                <option></option>
                                 <?php
                                foreach ($equipement->recupererSwitch() as $value)
                                {
                                ?>
                            <option value="<?php echo $value->ID_equipement?>">
                                
                                <?php echo $value->model.' / '.$value->mac?>
                                </option>                  
                             <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
            <div  class="col-lg-6 col-md-6"></div>

             <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Radio M5: </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <select class="form-control"  id="radio_M5">
                                <option></option>
                                 <?php
                                foreach ($equipement->recupererRadio_M5() as $value)
                                {
                                ?>
                            <option value="<?php echo $value->ID_equipement?>">
                                
                                <?php echo $value->model.' / '.$value->mac?>
                                </option>                  
                             <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
            <div  class="col-lg-6 col-md-6"></div>

             <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Radio M3: </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <select class="form-control"  id="radio_M3">
                                <option></option>
                                 <?php
                                foreach ($equipement->recupererRadio_M3() as $value)
                                {
                                ?>
                            <option value="<?php echo $value->ID_equipement?>">
                                
                                <?php echo $value->model.' / '.$value->mac?>
                                </option>                  
                             <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
            <div  class="col-lg-6 col-md-6"></div>

             <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Radio M2: </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                          <select class="form-control"  id="radio_M2">
                                <option></option>
                                 <?php
                                foreach ($equipement->recupererRadio_M2() as $value)
                                {
                                ?>
                            <option value="<?php echo $value->ID_equipement?>">
                                
                                <?php echo $value->model.' / '.$value->mac?>
                                </option>                  
                             <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                </div>
            </div>

         
        </div>
        <div class="row">  
        </div>
        <div class="container">
            <div class="row">
              <div class="col">
           </div>
        <div class="col">
            <button  type="button"style="background-color: #8b4513" class="btn waves-effect btn-rounded waves-light text-white" onclick="AttributionEquipement($('#idclient').val(),$('#antenne').val(),$('#routeur').val(),$('#switchSP').val(),$('#radio_M2').val(),$('#radio_M3').val(),$('#radio_M5').val())">attribuer equipement a un client</button>
        </div>
            <div class="col">
                 
            </div>
        </div>
        </div>
        </form>
    </div>
        </div>
    </div>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>