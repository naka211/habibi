<div class="panel-body padding-0">
    <div class="padding-left-10 padding-right-10 text-center">
        <div class="example">
        </div>
    </div>
</div>
<?php echo form_open($this->module_name.'/banner', array('class' => 'admin', 'id' => 'adminfrm'));?>
<div class="panel-body">
    <div class="row">
        <?php foreach($list as $row){?>
        <div id="gallery-<?php echo $row->id;?>" class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
            <?php if($row->image){ ?>
                <img src="<?php echo base_url_site()."uploads/gallery/".$row->image;?>" width="150" />
                <span id="publish<?php echo $row->id;?>">
                <?php echo ($this->check->check('edit'))?icon_active("'banner_gallery'","'id'",$row->id,$row->bl_active):'';?>
                </span>
                <?php if($this->check->check('del')){ ?>
                <a onclick="deletedata('banner_gallery','<?php echo $row->id;?>','gallery-<?php echo $row->id;?>')" href="javascript:void(0);" class="btn btn-icon btn-xs btn-danger waves-effect waves-light"
                    data-toggle="tooltip" data-original-title="Remove"><i class="icon glyphicon glyphicon-trash" aria-hidden="true"></i></a>
                <?php }?>
            <?php }?>
        </div>
        <?php }?>
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