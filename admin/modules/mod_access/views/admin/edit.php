<?php echo form_open(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.username');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="username" value="<?php echo $item->username;?>"
                placeholder="<?php echo lang('access.username');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="inputBasicEmail"><?php echo lang('access.email');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="email" class="form-control" id="inputBasicEmail" name="email" value="<?php echo $item->email;?>"
                placeholder="<?php echo lang('access.email');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.password');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="password" class="form-control" id="" name="password"
                placeholder="<?php echo lang('access.password');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.password.confirm');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="password" class="form-control" id="" name="repassword"
                placeholder="<?php echo lang('access.password.confirm');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.group');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select name="group_id" class="form-control">
                    <option value=""><?php echo lang('admin.select')." ".lang('access.group');?></option>
                    <?php foreach($list_group as $group){?>
                    <option <?php echo ($item->group_id==$group->group_id)?'selected="true"':'';?> value="<?php echo $group->group_id;?>"><?php echo $group->group_name;?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row margin-bottom-10">
        <div class="col-sm-12">
            <div class="form-group form-material text-center">
                <input type="hidden" name="id" value="<?php echo $item->id;?>"/>
                <button type="submit" class="btn btn-primary"><?php echo lang('admin.edit');?></button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>