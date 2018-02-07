<?php echo form_open(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Code <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="code"
                placeholder="Code" autocomplete="off" value="<?php echo $item->code;?>" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Name <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="name"
                placeholder="Name" autocomplete="off" value="<?php echo $item->name;?>" />
            </div>
        </div>
    </div>
    
    <div class="row margin-bottom-10">
        <div class="col-sm-12">
            <div class="form-group form-material text-center">
                <button type="submit" class="btn btn-primary"><?php echo lang('admin.edit');?></button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>