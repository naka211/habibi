<?php echo form_open_multipart(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
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
                <label class="control-label margin-top-10" for="">Email <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="email" value="<?php echo $item->email;?>"
                placeholder="email@gmail.com" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Password:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="password" class="form-control" id="" name="password"
                placeholder="Password" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Password confirm:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="password" class="form-control" id="" name="passwordconfirm"
                placeholder="Password confirm" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Birthday <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="birthday" name="birthday" value="<?php echo $item->birthday;?>"
                placeholder="01/01/1985" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Gender <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select name="gender" id="gender" class="form-control">
                    <option value=""><?php echo lang('admin.select');?></option>
                    <option <?php if($item->gender == 1){echo 'selected="true"';}?> value="1">Female</option>
                    <option <?php if($item->gender == 2){echo 'selected="true"';}?> value="2">Male</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Membership:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select name="type" id="type" class="form-control">
                    <option value=""><?php echo lang('admin.select');?></option>
                    <option <?php if($item->type == 1){echo 'selected="true"';}?> value="1">Silver</option>
                    <option <?php if($item->type == 2){echo 'selected="true"';}?> value="2">Gold</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Account type:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="code" name="code" value="<?php if($item->groups == 3){ echo "Google";}else if($item->groups == 2){echo "Facebook";}else{echo "Register";}?>"
                placeholder="9999" readonly="true" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Zip code:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="code" name="code" value="<?php echo $item->code;?>"
                placeholder="9999" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">City:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="city" name="city" value="<?php echo $item->city;?>"
                placeholder="City" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Avatar:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="">
                <input style="padding:0;border:none;" type="file" class="form-control" id="" name="avatar"/>
                <div id="image-show">
                    <?php if($item->avatar){ if($item->facebook){ ?>
       					<img src="<?php echo $item->avatar;?>" width="150" />
                        <?php }else{?>
                        <img src="<?php echo base_url_site()."uploads/user/".$item->avatar;?>" width="150" />
                        <?php }?>
                        <span id="image-view">
                            <a onclick="deleteimage('tb_user','id','<?php echo $item->id;?>','avatar','image-show')" href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default"
                            data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                        </span>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>

    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Slogan:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <textarea class="form-control" id="description" name="description"><?php echo $item->description;?></textarea>
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
<script>
    <?php 
        $language = $this->lang->lang();
        if($language == 'vn'){
            $language = 'vi';
        }
    ?>
    var max = '<?php echo date('Y/m/d',time());?>';
    var language = '<?php echo $language;?>';
    if(language){
        $.datetimepicker.setLocale(language);
    }
    $('#birthday').datetimepicker({
        //dayOfWeekStart : 1,
        lang:language,
        timepicker:false,
    	format:'d/m/Y',
    	formatDate:'Y/m/d',
        //minDate:'-1970/01/2',
        maxDate:max,
    });
</script>