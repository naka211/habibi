<?php echo form_open_multipart(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Code <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="code"
                placeholder="Code is key to display content at frontend. (EX: newscontact)" autocomplete="off" value="<?php echo $item->code;?>" />
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
                <input type="text" class="form-control" id="" name="title"
                placeholder="Name" autocomplete="off" value="<?php echo $item->title;?>" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Image:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="">
                <input style="padding:0;border:none;" type="file" class="form-control" id="" name="img_news"/>
                <div id="image-show">
                    <?php if($item->image){ ?>
       					<img src="<?php echo base_url_site()."uploads/news/".$item->image;?>" width="150" />
                        <span id="image-view">
                            <a onclick="deleteimage('tb_news_static','id','<?php echo $item->id;?>','image','image-show')" href="javascript:void(0);" class="btn btn-icon btn-xs btn-danger waves-effect waves-light"
                            data-toggle="tooltip" data-original-title="Remove"><i class="icon glyphicon glyphicon-trash" aria-hidden="true"></i></a>
                        </span>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Content <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <textarea class="form-control" id="content" name="content"><?php echo $item->content;?></textarea>
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