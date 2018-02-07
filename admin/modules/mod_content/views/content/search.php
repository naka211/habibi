<div class="panel-body padding-0">
    <div class="padding-left-10 padding-right-10 text-center">
        <div class="example">
            <form class="form-inline" action="<?php echo site_url($this->module_name.'/content/search/');?>" method="post">
                <div class="form-group">
                    <input type="text" name="name" id="" value="<?php echo $name;?>" autocomplete="off" placeholder="<?php echo lang('content.name');?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <select name="category_id" id="category_id" class="form-control">
                        <option value=""><?php echo lang('admin.select')." ".lang('category.title');?></option>
                        <?php if($category){foreach($category as $row){?>
                        <option <?php if($category_id == $row->category_id){echo 'selected="true"';}?> value="<?php echo $row->category_id;?>"><?php echo $row->name;?></option>
                        <?php }}?>
                    </select>  
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
echo form_open($this->module_name.'/content/dels', $more);
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
                <th><?php echo lang('content.name');?></th>
                <th><?php echo lang('content.image');?></th>
                <th><?php echo lang('content.description');?></th>
                <th><?php echo lang('content.category.name');?></th>
                <th><?php echo lang('content.date');?></th>
                <th class="text-center"><?php echo lang('admin.functions');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $row){?>
            <tr class="gradeA">
                <td class="text-center"><input type="checkbox" name="itemid[]" value="<?php echo $row->id;?>"/></td>
                <td><?php echo $row->title;?></td>
                <td>
                    <div class="thumbnail">
                    <?php if($row->image){ ?>
                        <img src="<?php echo base_url_site()."uploads/content/".$row->image;?>" width="150" />
                    <?php }?>
                    </div>
                </td>
                <td><?php echo $row->description;?></td>
                <td><?php echo $row->name;?></td>
                <td><?php echo $row->dt_create;?></td>
                <td class="actions text-center">
                    <?php echo ($this->check->check('edit'))?icon_edit($this->module_name.'/content/edit/'.$row->id.'/'.$currentpage):'';?>
                    <span id="publish<?php echo $row->id;?>">
                    <?php echo ($this->check->check('edit'))?icon_active("'tb_content_content'","'id'",$row->id,$row->bl_active):'';?>
                    </span>
                    <?php if($this->check->check('del')){ ?>
                    <a onclick="confirmDelete('1','<?php echo site_url($this->module_name.'/content/del/'.$row->id.'/'.(int)$currentpage);?>')" href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default"
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
<?php echo form_close();?>