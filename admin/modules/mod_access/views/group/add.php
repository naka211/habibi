<?php echo form_open(uri_string(),array('id'=>'adminfrm'));?>
<script>
    var totalNum = 0;
    var arr_pm_code = <?php echo json_encode($arr_pm_code);?>;
</script>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.group.name');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="group_name"
                placeholder="<?php echo lang('access.group.name');?>" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('access.group.description');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="group_comment"
                placeholder="<?php echo lang('access.group.description');?>" autocomplete="off" />
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
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <input type="checkbox" name="checkall" id="checkall" onclick="checkAllRight('checkall', totalNum, 'adminfrm')" />
                <strong><?php echo lang('admin.choose_all');?></strong>
            </div>
        </div>
        <div class="col-sm-9">&nbsp;</div>
    </div>
    <div class="row margin-bottom-10">
        <?php 
            $i=0; foreach($modules as $module){
            $functions = $this->group->getAllFunction($module->module_id);
        ?>
        <div class="col-sm-12">
            <hr />
            <div class="form-material">
                <h4><?php echo $module->module_name;?></h4>
                <h4><?php echo ($module->module_comment!='')?('['.$module->module_comment.']'):"";?></h4>
            </div>
        </div>
        <?php foreach($functions as $func){?>
            <input type="hidden" name="arr_right[<?php echo $i;?>][group_id]" value=""/>
            <input type="hidden" name="arr_right[<?php echo $i;?>][module_id]" value="<?php echo $module->module_id;?>"/>
            <input type="hidden" name="arr_right[<?php echo $i;?>][function_id]" value="<?php echo $func->function_id;?>"/>
            <input type="hidden" name="arr_right[<?php echo $i;?>][right_id]" value=""/>
            <div class="col-sm-12">
                <input type="checkbox" name="fAll_<?php echo $i;?>" id="fAll_<?php echo $i;?>" onclick ="checkAllFunction('fAll_<?php echo $i;?>','<?php echo $i;?>','adminfrm')"/>
                <strong><?php echo $func->function_name; ?></strong>
            </div>
            <?php foreach($permission as $pm){ ?>
            <div class="col-sm-2 form-group form-material">
                <input type="checkbox" name="arr_permission[<?php echo $i;?>][<?php echo $pm->permission_code?>]" value="1"/> <?php echo $pm->permission_name;?>
            </div>
            <?php }?>
            <div class="clearfix"></div>
        <?php $i++;}?>
        <script>
            totalNum = '<?php echo $i; ?>';
        </script>
        <?php }?>
    </div>
</div>
<?php echo form_close();?>