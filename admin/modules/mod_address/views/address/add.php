<?php echo form_open_multipart(uri_string())?>    
<div class="contents" id="content-info">
    <table class="form">
        <tr>
            <td class="required label" style="width: 150px;">Tỉnh/Thành</td>
            <td>
            <select name="city_id" id="city_id" class="w250" onchange="change_option(this.value);">
                <option value="">Chọn</option>
                <?php if($category){foreach($category as $row){?>
                <option value="<?php echo $row->city_id;?>"><?php echo $row->name;?></option>
                <?php }}?>
            </select>
            </td>
        </tr>
        <tr>
            <td class="required label" style="width: 150px;">Quận/Huyện</td>
            <td>
            <select name="district_id" id="district_id" class="w250" onchange="change_district(this.value);">
                <option value="">Chọn</option>
            </select>
            </td>
        </tr>
        <tr>
            <td class="required label" style="width: 150px;">Phường/Xã</td>
            <td>
            <select name="ward_id" id="ward_id" class="w250">
                <option value="">Chọn</option>
            </select>
            </td>
        </tr>
        <tr>
            <td class="required label" style="width: 150px;">Địa chỉ</td>
            <td>
                <input type="text" name="address" id="address" class="w250" value="" onblur="geocodeAddress(this.value);"/>
                <span>EX: 1 Hậu Giang, Phường 5, Quận 6, Hồ Chí Minh</span>
            </td>
        </tr>
        <tr>
            <td class="required label" style="width: 150px;">Điện thoại</td>
            <td>
                <input type="text" name="phone" id="phone" class="w250" value=""/>
            </td>
        </tr>
        <tr>
            <td class="required label" style="width: 150px;">Giờ mở cửa</td>
            <td>
                <input type="text" name="timeopen" id="timeopen" class="w250" value=""/>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo lang('active_deactive');?></td>
            <td><input type="checkbox" name="bl_active" id="bl_active"  value="1" checked="true" /></td>
        </tr>
    </table>
    <table class="form">
        <tr>
            <td class="center">
                <input type="submit" name="bt_submit" value="bt_submit" class="themmoi"/>
            </td>
        </tr> 
    </table>
</div>
<input type="hidden" name="lat" id="lat" value="" />
<input type="hidden" name="lng" id="lng" value="" />
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script>
    function change_option(id){
        $.ajax({
        type: "POST",
        url: "<?php echo base_url().$this->_module_name;?>/address/district/",
        data: {'id':id},
        dataType: 'html',
        success: function(html){
            if(html){
                $('#district_id').html(html);
            }else{
                $('#district_id').html('<option value="">Chọn loại</option>');
            }
            }
        });
    }
    function change_district(id){
        $.ajax({
        type: "POST",
        url: "<?php echo base_url().$this->_module_name;?>/address/ward/",
        data: {'id':id},
        dataType: 'html',
        success: function(html){
            if(html){
                $('#ward_id').html(html);
            }else{
                $('#ward_id').html('<option value="">Chọn</option>');
            }
            }
        });
    }
    function geocodeAddress(address) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
                $('#lat').val(lat);
                $('#lng').val(lng);
            } else {
                //alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
</script>
<?php echo form_close()?>