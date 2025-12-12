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
                <h2 class="text-themecolor">Attribution materiels à un prospect</h2>
            </div>

        </div>

        <form  class="form-horizontal p-t-20">
                                     <!-- Debut premiere ligne-->
       <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Prospect</label>
                    

                    <div class="form-group col-sm-9">
                        <input type="text" id="idclient" name="idclient" class="form-control" autocomplete="off"> 
                            <div id="modal"></div>
                    </div>
                </div>
            </div>
              <div class="col-lg-6 col-md-6">
                <div class="row">
                 <label for="exampleInputEmail3" class="col-sm-3 control-label">Materiel : </label>
                    <div class="col-sm-9">

                        <div class="form-group">
                            <select class="form-control"  id="materiel">
                                <option></option>
                                 <?php 
                                foreach ($marketing->selectionMateriel() as $value)
                                {
                                ?>
                                    <option value="<?php echo $value->ID_stock?>">
                                        <?php echo $value->materiels?>
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
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite/nombre : </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="number" class="form-control" id="quantite">
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
            <button  type="button" class="btn btn-btn-rounded" style="background-color:#E67E30;" onclick="Attribuer_Materiels($('#idclient').val(),$('#materiel').val(),$('#quantite').val())">attribuer </button>
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
$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');
?>