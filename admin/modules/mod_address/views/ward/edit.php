<?php echo form_open_multipart(uri_string())?>    

<script>
    function change_option(id){
        $.ajax({
        type: "POST",
        url: "<?php echo base_url().$this->_module_name;?>/ward/district/",
        data: {'id':id},
        dataType: 'html',
        success: function(html){
            if(html){
                $('#district_id').html(html);
            }else{
                $('#district_id').html('<option value="">Chọn</option>');
            }
            }
        });
    }
</script>
<?php echo form_close()?>