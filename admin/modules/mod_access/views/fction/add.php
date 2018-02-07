<?php echo form_open(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.module.code.function');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="function_code"
                placeholder="<?php echo lang('access.module.code.function');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.module.name.function');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="function_name"
                placeholder="<?php echo lang('access.module.name.function');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.module.description');?>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="function_comment"
                placeholder="<?php echo lang('access.module.description');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.module.name.module');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select id="module_id" name="module_id" class="form-control">
                    <option value=""><?php echo lang('admin.select');?></option>
                    <?php foreach($modules as $module){?>
                    <option <?php echo ($module_id == $module->module_id)?'selected=true':'';?> value="<?php echo $module->module_id;?>"><?php echo $module->module_name;?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row margin-bottom-10">
        <div class="col-sm-12">
            <div class="form-group form-material text-center">
                <button type="submit" class="btn btn-primary"><?php echo lang('admin.add');?></button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>