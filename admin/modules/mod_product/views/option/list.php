<form name="frmsearch" id="frmsearch" action="<?php echo base_url().$this->_module_name;?>/member/search/" method="post">
	<input type="hidden" name="page" value="<?php echo (int)$this->uri->segment('3')?>">
	<p style="text-align:center">Họ Tên : <input type="text" id="full_name" name="full_name" class="w200"> &nbsp; &nbsp;  Điện thoại : <input type="text" id="tel" name="tel" class="w200">&nbsp; &nbsp; Từ Ngày : <input type="text" id="tungay" name="tungay" class="w200"> &nbsp;&nbsp;&nbsp;&nbsp;Đến Ngày: <input type="text" id="denngay" name="denngay" class="w200"> &nbsp;&nbsp;&nbsp;<input type="submit" class="submit"  name="btn_submit" value=" Lọc dữ liệu " style="height:36px"></p>
 </form>
<?
	$attributes = array('class' => 'email', 'id' => 'checknew');
	echo form_open($this->_module_name.'/member/dels', $attributes);
?>
<table class="admindata">
   <thead>
      <tr>
         <th colspan="7">
             <div style="float:left; width:200px;">
			 <?php if($this->acl->check('dels')){ ?>
                <input type="submit" onclick="return verify_del();" name="btn_submit" class="submit" value="<?php echo lang('admin.deletes');?>">
             <?php } ?>
            <?php echo lang('admin.total');?> <?php echo $num?>  <?php echo lang('admin.records');?></div><div style="float:left"><span class="pages"> <?php echo $pagination?> </span> </div>
         </th>
      </tr>
      <tr>
         <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew')" /></th>
         <th width="150">Họ tên</th>
         <th width="100">Điện thoại</th>
         <th width="100">Số CMND</th>
         <th width="250">Địa chỉ</th>
         <th width="100">Ngày tham gia</th>
         <th class="publish"><?php echo lang('functions');?></th>
      </tr>
   </thead>
   <?
        $k=1;
        $i=1;
        foreach($list as $rs):
        ?>
   <tr class="row<?php echo $k?>">
        <td><input type="checkbox" name="ar_id[]" value="<?php echo $rs->id?>"></td>
       <td><?php echo $rs->name;?></td>
       <td><?php echo $rs->tel;?></td>
       <td><?php echo $rs->cmnd;?></td>
        <td><?php echo $rs->address;?></td>
        <td><?php echo date_mysql2vn($rs->dt_create);?></td>
        <td align="center">
        <a href="<?php echo base_url()."mod_game/member/game_score/".$rs->id?>" title="Xem các lượt chơi" class="cboxElement">
		<img src="<?php echo base_url()?>templates/images/lage.png" width=""/></a>
		<span id="publish<?php echo $rs->id?>">
		<?php echo ($this->acl->check('edit'))?icon_active("'tb_game_member'","'id'",$rs->id,$rs->bl_active):'';?>
		</span>
		<?php echo ($this->acl->check('del'))?icon_del($this->_module_name.'/member/del/'.$rs->id.'/'.(int)$current_page):'';?>
        </td>
   </tr>
   <?
        $k=1-$k;
        $i++;
        endforeach;?>
   <tfoot>
   <td colspan="7">
      <div style="float:left; width:200px;">
			 <?php if($this->acl->check('dels')){ ?>
                <input type="submit" onclick="return verify_del();" name="btn_submit" class="submit" value="<?php echo lang('admin.deletes');?>">
             <?php } ?>
            <?php echo lang('admin.total');?> <?php echo $num?>  <?php echo lang('admin.records');?></div><div style="float:left"><span class="pages"> <?php echo $pagination?> </span> </div>
		 </td>
         </tfoot>
</table>
<?php echo form_close()?>
<script language="JavaScript">          
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