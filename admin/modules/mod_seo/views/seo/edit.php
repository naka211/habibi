<?php echo form_open_multipart(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('seo.code');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="code"
                placeholder="<?php echo lang('seo.code.example');?>" autocomplete="off" value="<?php echo $item->code;?>" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('seo.name');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="name"
                placeholder="<?php echo lang('seo.name');?>" autocomplete="off" value="<?php echo htmlspecialchars($item->name);?>" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('seo.title');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <textarea class="form-control" name="meta_title" placeholder="<?php echo lang('seo.title');?>"><?php echo $item->meta_title;?></textarea>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('seo.keywords');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <textarea class="form-control" rows="5" name="meta_keywords" placeholder="<?php echo lang('seo.keywords');?>"><?php echo $item->meta_keywords;?></textarea>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('seo.description');?> <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <textarea class="form-control" rows="5" name="meta_description" placeholder="<?php echo lang('seo.description');?>"><?php echo $item->meta_description;?></textarea>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for=""><?php echo lang('seo.image');?>: (470x276)</label>
            </div>
        </div>
        <div class="col-sm-9">
            <input style="padding:0;border:none;" type="file" class="form-control" id="" name="image"/>
            <div id="image-show">
                <?php if($item->image){ ?>
                    <img src="<?php echo base_url_site()."uploads/seo/".$item->image;?>" width="150" />
                    <span id="image-view">
                        <a onclick="deleteimage('tb_seo','id','<?php echo $item->id;?>','image','image-show')" href="javascript:void(0);" class="btn btn-icon btn-xs btn-danger waves-effect waves-light"
                           data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                    </span>
                <?php }?>
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