<?php
require_once("../../model/localisation.class.php");
$localisation = new Localisation();
if ($_GET['type'] == 'client_contracte') 
{
?>
		<div class="row">
			<div class="col-lg-10 col-md-10">
				<div class="row">
					<label for="exampleInputEmail3" class="col-sm-3 control-label">Client*</label>
					<div class="form-group col-sm-9">
						<input type="text" id="idclient_facture_proformat" class="form-control" autocomplete="off" onkeyup="autocomplete_facture_proformat($(this).val())">
						<div id="modal"></div>
					</div>
				</div>
			</div>
		</div><!-- END ROW-->

<?php
}
else
{
?>
		<div class="row">
	<div class="col-lg-3 col-md-10">
		<div class="row">
            <label for="exampleInputEmail3" class="col-sm-5 control-label">Nom *</label>
            <div class="form-group col-sm-10">
            <input type="text" id="newclient" class="form-control"  placeholder="nom complet">
                    
            </div>
        </div>
	</div>
	<div class="col-lg-3 col-md-10">
		<div class="row">
            <label for="exampleInputEmail3" class="col-sm-5 control-label"> phone</label>
            <div class="form-group col-sm-10">
            <input type="text" id="phone" class="form-control"  placeholder="Telephone">
                    
            </div>
        </div>
	</div>
	<div class="col-lg-3 col-md-10">
		<div class="row">
            <label for="exampleInputEmail3" class="col-sm-5 control-label">mail*</label>
            <div class="form-group col-sm-10">
            <input type="text" id="mailclient" class="form-control"  placeholder="e-mail">
            </div>
        </div>
	</div>
	<div class="col-lg-3 col-md-10">
		<div class="row">
            <label for="exampleInputEmail3" class="col-sm-5 control-label">Adresse</label>
            <div class="form-group col-sm-10">
            <input type="text" id="adresse_client" class="form-control"  placeholder="Enter name">
            </div>
        </div>
	</div>
</div>
<div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Localisation*</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker"></i></span></div>
                      
                       <select  class="form-control" id="localisation">
                        <?php 
                        foreach ($localisation->selectionLocalisation() as $value)
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
    </div>
<?php
}
?>
