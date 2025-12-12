<?php
ob_start();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
    <div class="card-body">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h2 class="text-themecolor">Fiche de demenagement</h2>
            </div>

        </div>

        <form action="/crm.buja/fichedemenagement" method="post" class="form-horizontal p-t-20">
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
         
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Nouvelle adresse : </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control" name="new_adress" id="new_adress">
                        </div>
                    </div>
                </div>
            </div>
     
          
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date demenagement : </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="date" class="form-control" name="dates" id="dates">
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    <table width="100%"><tr><td width="30%"><td>
            <td width="50%"><button  type="submit" class="btn btn-dribbble waves-effect btn-rounded waves-light" >Generer Ticket </button></td>
            <td width="30%"></td>
        </tr>
    </table>
           
       
        </form>
    </div>
        </div>
    </div>
</div>
<?php
    /*if ($_SESSION['role'] == 'commercial') 
    {
        $home_commercial_content = ob_get_clean();
        require_once('vue/admin/home.commercial.php');
    }
    elseif ($_SESSION['role'] == 'admin') 
    {
        $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
    }*/
    $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
?>