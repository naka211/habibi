<form name="frmsearch" id="frmsearch" action="<?php echo base_url().$this->_module_name;?>/address/search/" method="post">
    <p class="center">
        Tên:&nbsp;<input type="text" id="name" name="name" class="w200"/>&nbsp;
        Tỉnh/Thành:&nbsp;
        <select name="city_id" id="city_id" class="w200" onchange="change_option(this.value);">
            <option value="">Chọn</option>
            <?php if($category){foreach($category as $row){?>
            <option value="<?php echo $row->city_id;?>"><?php echo $row->name;?></option>
            <?php }}?>
        </select>
        Quận/Huyện:&nbsp;
        <select name="district_id" id="district_id" class="w200" onchange="change_district(this.value);">
            <option value="">Chọn</option>
        </select>
        Phường/Xã:&nbsp;
        <select name="ward_id" id="ward_id" class="w200">
            <option value="">Chọn</option>
        </select>
        &nbsp;&nbsp;
        <input type="hidden" name="page" value="<?php echo $current_page;?>"/>
        <input type="submit" class="submit" name="btn_submit" value="Lọc dữ liệu" style="height:36px"/>
    </p>
</form>
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
                $('#district_id').html('<option value="">Chọn</option>');
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
</script>
<?php
	$attributes = array('class' => 'email', 'id' => 'checknew');
	echo form_open($this->_module_name.'/address/dels', $attributes);
?>
<table class="admindata">
   <thead>
      <tr>
         <th colspan="3">
             <?php if($this->acl->check('dels')){ ?>
                <input type="submit" onclick="return verify_del();" name="btn_submit" class="submit" value="<?php echo lang('admin.deletes');?>"/>
             <?php } ?>
            <?php echo lang('admin.total');?>&nbsp;<?php echo $num;?>&nbsp;<?php echo lang('admin.records');?><span class="pages"><?php echo $pagination;?></span>
         </th>
         <th></th>
      </tr>
      <tr>
         <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></th>
         <th>Code</th>
         <th>Tên</th>
         <th class="publish"><?php echo lang('functions');?></th>
      </tr>
   </thead>
   <?php
        $k=1;
        $i=1;
        foreach($list as $rs):
   ?>
    <tr class="row<?php echo $k?>">
        <td><input type="checkbox" name="ar_id[]" value="<?php echo $rs->id;?>"/></td>
        
        <td><?php echo $rs->id;?></td>
        <td><?php echo $rs->address;?></td>
        <td class="center">
            <?php echo ($this->acl->check('edit'))?icon_edit($this->_module_name.'/address/edit/'.$rs->id.'/'.(int)$current_page):'';?>
            <span id="publish<?php echo $rs->id;?>">
            <?php echo ($this->acl->check('edit'))?icon_active("'tb_city_address'","'id'",$rs->id,$rs->bl_active):'';?>
            </span>
            <?php echo ($this->acl->check('del'))?icon_del($this->_module_name.'/address/del/'.$rs->id.'/'.(int)$current_page):'';?>
        </td>
   </tr>
   <?php
        $k=1-$k;
        $i++;
        endforeach;?>
   <tfoot>
   <td colspan="4">
     <?php if($this->acl->check('dels')){ ?>
        <input type="submit" onclick="return verify_del();" name="btn_submit" class="submit" value="<?php echo lang('admin.deletes');?>"/>
     <?php } ?>
    <?php echo lang('admin.total');?>&nbsp;<?php echo $num;?>&nbsp;<?php echo lang('admin.records');?><span class="pages"><?php echo $pagination;?></span>
    </td>
    </tfoot>
</table>
<input type="hidden" name="page" value="<?php echo $current_page;?>"/>
<?php echo form_close()?>