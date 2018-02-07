<?php echo form_open($this->module_name.'/language', array('class' => 'admin', 'id' => 'adminfrm'));?>
<div class="panel-body">
    <div class="row">
        <div class="col-sm-12">
            <div id="toolbar">
                <?php if($this->check->check('dels')){?>
                <a class="btn btn-danger" onclick="deleteAllItem('<?php echo site_url($this->module_name."/language/dels/");?>');" >
                    <?php echo lang('admin.deletes');?>
                </a>
                <?php }?>
            </div>
            <table id="list_table"
                data-toggle="table"
                data-url="<?php echo site_url($this->module_name.'/language/getContent');?>"
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
                        <th data-field="id">ID</th>
                        <th data-field="code">Code</th>
                        <th data-field="name">Name</th>
                        <th data-field="flag">Flag</th>
                        <th data-field="dt_create">Date</th>
                        <th data-field="sort">Sort <a onclick="sortFunctionAjax('adminfrm','<?php echo site_url('ajax/sortOrderAjax');?>')" href="javascript:void(0);" class="btn btn-icon btn-xs btn-success waves-effect waves-light"
                            rel="tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save"><i class="icon glyphicon glyphicon-floppy-save" aria-hidden="true"></i></a>
                        </th>
                        <th class="text-center action" data-field="action"><?php echo lang('admin.functions');?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<input type="hidden" name="table" value="language" />
<input type="hidden" name="where" value="id" />
<?php echo form_close()?>