<?php echo form_open($this->module_name.'/module', array('class' => 'admin', 'id' => 'adminfrm'));?>
<div class="panel-body">
    <div class="row">
        <div class="col-sm-12">
            <div id="toolbar">
                <?php if($this->check->check('dels')){?>
                <a class="btn btn-danger" onclick="deleteAllItem('<?php echo site_url($this->module_name."/module/dels/");?>');" >
                    <?php echo lang('admin.deletes');?>
                </a>
                <?php }?>
            </div>
            <table id="list_table"
                data-toggle="table"
                data-url="<?php echo site_url($this->module_name.'/module/getContent');?>"
                data-toolbar="#toolbar"
                data-side-pagination="server"
                data-pagination="true"
                data-show-refresh="true"
                data-show-toggle="true"
                data-show-columns="true"
                data-show-export="true"
                data-page-list="[5,10,20,50,100,200,ALL]"
                data-mobile-responsive="true">
                <thead>
                    <tr>
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-field="module_id"><?php echo lang('access.module.id');?></th>
                        <th data-field="module_code"><?php echo lang('access.module.code.module');?></th>
                        <th data-field="module_name"><?php echo lang('access.module.name.module');?></th>
                        <th data-field="module_comment"><?php echo lang('access.module.description');?></th>
                        <th class="text-center action" data-field="action"><?php echo lang('admin.functions');?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php echo form_close()?>