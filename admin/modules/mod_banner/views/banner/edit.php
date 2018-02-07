<?php echo form_open_multipart(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Category <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select name="category_id" id="category_id" class="form-control">
                    <option value=""><?php echo lang('admin.select');?></option>
                    <?php if($category){foreach($category as $row){?>
                    <option <?php if($item->category_id == $row->category_id){echo 'selected="true"';}?> value="<?php echo $row->category_id;?>"><?php if($row->nameParent){ echo $row->nameParent.' --> '.$row->name;}else{ echo $row->name;}?></option>
                    <?php }}?>
                </select>
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
                <input type="text" class="form-control" id="" name="name" value="<?php echo $item->name;?>"
                placeholder="Name" autocomplete="off" />
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
                <input style="padding:0;border:none;" type="file" class="form-control" id="" name="image"/>
                <div id="image-show">
                    <?php if($item->image){ ?>
       					<img src="<?php echo base_url_site()."uploads/banner/".$item->image;?>" width="150" />
                        <span id="image-view">
                            <a onclick="deleteimage('tb_banner_banner','id','<?php echo $item->id;?>','image','image-show')" href="javascript:void(0);" class="btn btn-icon btn-xs btn-danger waves-effect waves-light"
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
                <label class="control-label margin-top-10" for="">Link:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="link" value="<?php echo $item->link;?>"
                placeholder="https://google.com" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Description:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <textarea class="form-control tinyeditor" id="description" name="description"><?php echo $item->description;?></textarea>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Content:</label>
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