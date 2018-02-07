<?php echo form_open_multipart(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                &nbsp;
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#show-content-vn" aria-controls="show-content-vn" role="tab" data-toggle="tab">Tiếng việt</a></li>
                    <li role="presentation"><a href="#show-content-en" aria-controls="show-content-en" role="tab" data-toggle="tab">Tiếng anh</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="show-content-vn">
            <div class="row margin-bottom-10">
                <div class="col-sm-3">
                    <div class="form-material">
                        <label class="control-label margin-top-10" for=""><?php echo lang('category.parent');?>:</label>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-material">
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value=""><?php echo lang('admin.select');?></option>
                            <?php if($category){foreach($category as $row){?>
                            <option value="<?php echo $row->category_id;?>"><?php echo $row->name;?></option>
                            <?php }}?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row margin-bottom-10">
                <div class="col-sm-3">
                    <div class="form-material">
                        <label class="control-label margin-top-10" for=""><?php echo lang('category.code');?> <span class="text-danger">*</span>:</label>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-material">
                        <input type="text" class="form-control" id="" name="code"
                        placeholder="<?php echo lang('category.code.example');?>" autocomplete="off" />
                    </div>
                </div>
            </div>
            <div class="row margin-bottom-10">
                <div class="col-sm-3">
                    <div class="form-material">
                        <label class="control-label margin-top-10" for=""><?php echo lang('category.name');?> <span class="text-danger">*</span>:</label>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-material">
                        <input type="text" class="form-control" id="" name="name"
                        placeholder="<?php echo lang('category.name');?>" autocomplete="off" />
                    </div>
                </div>
            </div>
            <div class="row margin-bottom-10">
                <div class="col-sm-3">
                    <div class="form-material">
                        <label class="control-label margin-top-10" for=""><?php echo lang('category.image');?>:</label>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="">
                        <input style="padding:0;border:none;" type="file" class="form-control" id="" name="image"/>
                    </div>
                </div>
            </div>
            <div class="row margin-bottom-10">
                <div class="col-sm-3">
                    <div class="form-material">
                        <label class="control-label margin-top-10" for=""><?php echo lang('category.description');?>:</label>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-material">
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>
                </div>
            </div>
            <div class="row margin-bottom-10">
                <div class="col-sm-3">
                    <div class="form-material">
                        <label class="control-label margin-top-10" for=""><?php echo lang('category.ordering');?>:</label>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-material">
                        <input type="text" class="form-control" id="ordering" name="ordering" value="0"/>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="show-content-en">
            &nbsp;
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