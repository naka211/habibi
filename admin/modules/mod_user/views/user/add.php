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
                <input type="text" class="form-control" id="" name="name"
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
                <input type="text" class="form-control" id="" name="email"
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
                <input type="text" class="form-control" id="birthday" name="birthday"
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
                    <option value="1">Female</option>
                    <option value="2">Male</option>
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
                    <option value="1">Silver</option>
                    <option value="2">Gold</option>
                </select>
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
                <input type="text" class="form-control" id="code" name="code"
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
                <input type="text" class="form-control" id="city" name="city"
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
                <textarea class="form-control" id="description" name="description"></textarea>
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