<?php echo form_open_multipart(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">City <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select name="city_id" id="city_id" class="form-control">
                    <option value=""><?php echo lang('admin.select');?></option>
                    <?php if($city){foreach($city as $row){?>
                    <option <?php if($item->city_id == $row->city_id){echo 'selected="true"';}?> value="<?php echo $row->city_id;?>"><?php echo $row->name;?></option>
                    <?php }}?>
                </select>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Type <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select name="type_district" id="type_district" class="form-control">
                    <option value=""><?php echo lang('admin.select');?></option>
                    <option <?php if($item->type_district == 'Thành Phố'){echo 'selected="true"';}?> value="Thành Phố">Thành Phố</option>
                    <option <?php if($item->type_district == 'Thị Xã'){echo 'selected="true"';}?> value="Thị Xã">Thị Xã</option>
                    <option <?php if($item->type_district == 'Quận'){echo 'selected="true"';}?> value="Quận">Quận</option>
                    <option <?php if($item->type_district == 'Huyện'){echo 'selected="true"';}?> value="Huyện">Huyện</option>
                </select>
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
                <input type="text" class="form-control" id="" name="name" value="<?php echo $item->name;?>"
                placeholder="Name" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Ordering:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="ordering" name="ordering" value="<?php echo $item->ordering;?>"/>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Status:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="checkbox" name="bl_active" id="bl_active" value="1" <?php if($item->bl_active){echo 'checked="true"';}?>/>
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