<div class="row">
    <div class="col-lg-4 col-md-4">
        <label class="control-label">Date debut</label>
        <div class="form-group col-sm-9">
            <input type="date" class="form-control form-control-sm" name="startDate" id="startDate<?=$_GET['i']?>" value="<?=date('Y-m-d')?>">
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <label class="control-label">Date fin</label>
        <div class="form-group col-sm-9">
            <input type="date" class="form-control form-control-sm" name="endDate" id="endDate<?=$_GET['i']?>">
        </div>
    </div>
</div>