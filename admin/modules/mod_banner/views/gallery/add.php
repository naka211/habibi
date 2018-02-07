<?php echo form_open_multipart(uri_string(),array('id'=>'adminfrm'));?>
<div class="panel-body">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <div class="form-material">
                <label class="control-label margin-top-10" for="">Image:</label>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="">
                <input style="padding:0;border:none;" type="file" class="form-control" multiple="true" accept="image/*" id="image" name="image[]"/>
            </div>
        </div>
    </div>
    <div class="row margin-bottom-10">
        <div class="row">
            &nbsp;
        </div>
        <div class="row" id="listUploaded">
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
<script>
    $('#image').on('change',function(){
        var form = $('#adminfrm')[0];
    	var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: '<?php echo site_url($this->module_name.'/gallery/add');?>',
            data: formData,
            dataType: 'html',
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(html){
                if(html){
                    $('#image').val('');
                    $('#listUploaded').html(html);
                }else{
                    $('#messageContent').html('Error! Please action again!');
                    $('#messageModal').modal('show');
                }
            }
        });
        return false;
    });
</script>