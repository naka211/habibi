<?php echo form_open(uri_string())?>
<table class="form">
    <tr>
        <td class="label">Từ ngày</td>
        <td>
            <input type="text" id="tungay" name="tungay" class="w200">
        </td>
    </tr>
    <tr>
        <td class="label">Đến ngày</td>
        <td>
            <input type="text" id="denngay" name="denngay" class="w200">
        </td>
    </tr>
	<tr>
        <td class="label">Nhập số lượng cần xuất </td>
        <td>
            <input type="text" id="soluong" name="soluong" class="w200">
        </td>
    </tr>  
    <tr>
        <td colspan="2" style="padding-left:170px;"><input type="submit" name="bt_submit" value="Thống kê"></td>
    </tr>    
</table>
<?php echo form_close();?>
<script>
    $(function() {
        var dates = $( "#tungay, #denngay" ).datepicker({

            changeMonth: true,
            dateFormat: 'yy-mm-dd', 
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {
                var option = this.id == "tungay" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" );
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
</script>