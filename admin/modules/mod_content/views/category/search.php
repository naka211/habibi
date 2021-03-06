<div class="panel-body padding-0">
    <div class="padding-left-10 padding-right-10 text-center">
        <div class="example">
            <form class="form-inline" action="<?php echo site_url($this->module_name.'/category/search/');?>" method="post">
                <div class="form-group">
                    <input type="text" name="name" value="<?php echo $name;?>" id="" autocomplete="off" placeholder="<?php echo lang('category.name');?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo lang('admin.search');?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$more = array('class' => 'admin', 'id' => 'adminfrm');
echo form_open($this->module_name.'/category/dels', $more);
?>
<input type="hidden" name="page" value="<?php echo (int)$currentpage;?>"/>
<div class="panel-body">
    <div class="row">
        <div class="col-sm-5">
            <div class="margin-bottom-15">
                <?php if($this->check->check('dels')){ ?> 
                <a onclick="confirmDelete('2','adminfrm');" href="javascript:void(0)" class="btn btn-primary"><?php echo lang('admin.deletes');?></a>
                <?php }?>
                <?php echo lang('admin.total');?>
                <?php echo $num;?>
                <?php echo lang('admin.records');?>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="margin-bottom-15">
                <div class="dataTables_paginate paging_simple_numbers">
                    <?php echo $pagination;?>
                </div>
            </div>
        </div>
    </div>
    <div class="example table-responsive">
        <table class="table table-bordered table-hover table-striped" id="exampleAddRow">
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" name="checkall" id="checkall" onclick="checkAll('checkall', 'itemid[]', 'adminfrm')" /></th>
                <th><?php echo lang('category.id');?></th>
                <th><?php echo lang('category.name');?></th>
                <th><?php echo lang('category.image');?></th>
                <th><?php echo lang('category.description');?></th>
                <th><?php echo lang('category.date');?></th>
                <th class="text-center"><?php echo lang('admin.functions');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $row){?>
            <tr class="gradeA">
                <td class="text-center"><input type="checkbox" name="itemid[]" value="<?php echo $row->category_id;?>"/></td>
                <td><?php echo $row->category_id;?></td>
                <td><?php echo $row->name;?></td>
                <td>
                    <div class="thumbnail">
                    <?php if($row->image){ ?>
                        <img src="<?php echo base_url_site()."uploads/content/".$row->image;?>" width="150" />
                    <?php }?>
                    </div>
                </td>
                <td><?php echo $row->content;?></td>
                <td><?php echo $row->dt_create;?></td>
                <td class="actions text-center">
                    <?php echo ($this->check->check('edit'))?icon_edit($this->module_name.'/category/edit/'.$row->category_id.'/'.$currentpage):'';?>
                    <span id="publish<?php echo $row->category_id;?>">
                    <?php echo ($this->check->check('edit'))?icon_active("'tb_content_category'","'category_id'",$row->category_id,$row->bl_active):'';?>
                    </span>
                    <?php if($this->check->check('del')){ ?>
                    <a onclick="confirmDelete('1','<?php echo site_url($this->module_name.'/category/del/'.$row->category_id.'/'.(int)$currentpage);?>')" href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default"
                    data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                    <?php }?>
                </td>
            </tr>
            <?php }?>
        </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="margin-bottom-15">
                &nbsp;
            </div>
        </div>
        <div class="col-sm-7">
            <div class="margin-bottom-15">
                <div class="dataTables_paginate paging_simple_numbers">
                    <?php echo $pagination;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close()?>