<?php

if ($_GET['action'] == 'couper') 
{
?>
	<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="form-group row">
                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Motif </label>
                <div class="col-sm-9">
                    <div class="input-group">
                    	<select class="form-control" id="motif<?=$_GET['i']?>" onchange="getFacturesDunClient($(this).val(),'<?=$_GET['idclient']?>','<?=$_GET['i']?>')">
                            <option value="partie">
                                Partie
                            </option>
                    		<option value="dette">Dette</option>
                    	</select>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
else
{
?>
	<input type="text" id="motif<?=$_GET['i']?>" value="derogation" hidden>
<?php
}
?>