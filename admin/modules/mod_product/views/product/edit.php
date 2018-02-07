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
                    <option <?php if($item->category_id == $row->category_id){echo 'selected="true"';}?> value="<?php echo $row->category_id;?>"><?php echo $row->name;?></option>
                    <?php }}?>
                </select>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Company <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <select name="company_id" id="company_id" class="form-control">
                    <option value=""><?php echo lang('admin.select');?></option>
                    <?php if($company){foreach($company as $row){?>
                    <option <?php if($item->company_id == $row->id){echo 'selected="true"';}?> value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
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
                <label class="control-label margin-top-10" for="">Price old:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="price_old" value="<?php echo $item->price_old;?>"
                placeholder="100000" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Price <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="price" value="<?php echo $item->price;?>"
                placeholder="50000" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Quantity <span class="text-danger">*</span>:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="" name="quantity" value="<?php echo $item->quantity;?>"
                placeholder="100" autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">End time:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="hour" name="hour" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="minute" name="minute" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="dt_end" name="dt_end" value="<?php echo date('d/m/Y',$item->dt_end);?>"
                    placeholder="01/01/2020" autocomplete="off" />
                </div>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Address:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $item->address;?>"
                placeholder="Address" autocomplete="off" />
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
       					<img src="<?php echo base_url_site()."uploads/product/".$item->image;?>" width="150" />
                        <span id="image-view">
                            <a onclick="deleteimage('tb_product_product','id','<?php echo $item->id;?>','image','image-show')" href="javascript:void(0);" class="btn btn-icon btn-xs btn-danger waves-effect waves-light"
                            data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                        </span>
                    <?php }?>
                </div>
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
                <textarea class="form-control" id="description" name="description"><?php echo $item->description;?></textarea>
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
                <label class="control-label margin-top-10" for="">Map:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-material">
                <textarea class="form-control" id="map_code" name="map_code"><?php echo $item->map_code;?></textarea>
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
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Image detail:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div id="loading" style="display: none;"><img src="<?php echo base_url();?>templates/images/loading.gif" /></div>
            <div class="">
                <input style="padding:0;border:none;" type="file" class="form-control" name="productimage[]" id="productimage" multiple="true" accept="image/*"/>
                <div class="row" id="list-image">
                    <?php if($image){$i=0; foreach($image as $row){?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" id="show_images_db_<?php echo $i;?>">
                            <img src="<?php echo base_url_site().'uploads/product/'.$row->image;?>" width="95" height="95" class="img-responsive center-block"/>
                            <a onclick="deletedata('product_image','<?php echo $row->id;?>','show_images_db_<?php echo $i;?>')" href="javascript:void(0);" class="btn btn-icon btn-xs btn-danger waves-effect waves-light"
                                data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                        </div>
                    <?php $i++;}}?>
                </div>
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
<script>
    <?php 
        $language = $this->lang->lang();
        if($language == 'vn'){
            $language = 'vi';
        }
    ?>
    var language = '<?php echo $language;?>';
    if(language){
        $.datetimepicker.setLocale(language);
    }
    $('#dt_end').datetimepicker({
        //dayOfWeekStart : 1,
        lang:language,
        timepicker:false,
    	format:'d/m/Y',
    	formatDate:'Y/m/d',
    });
    $(document).ready(function(){
        $('#productimage').on('change',function(){
            var form = $('#adminfrm')[0];
        	var formData = new FormData(form);
            $('#loading').show();
            $.ajax({
                type: "POST",
                url: BASE_URI+"mod_product/product/upload",
                data: formData,
                dataType: 'html',
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(html){
                    $('#loading').hide();
                    $('#productimage').val('');
                    $('#list-image').append(html);
                }
            });
            return false;
        });
    });
</script>