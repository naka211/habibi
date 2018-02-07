<?php
	$attributes = array('class' => 'email', 'id' => 'checknew');
	echo form_open($this->_module_name.'/contact/dels', $attributes);
?>
<input type="hidden" name="current_page" value="<?php echo (int)$current_page?>">
<table class="admindata">
   <thead>
      <tr>
         <th colspan="6"> 
             <input type="submit" onclick="return verify_del();" name="btn_submit" class="submit" value="<?php echo lang('admin.deletes');?>">
             
            <?php echo lang('admin.total');?> <?php echo $num?>  <?php echo lang('admin.records');?><span class="pages"> <?php echo $pagination?> </span> </th>
      </tr>
      <tr>
         <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew');" /></th>
       
         <th><?php echo lang('full_name');?></th>
         <th>Email</th>
         <th><?php echo lang('contact_message');?></th>
         <th><?php echo lang('dtcreate');?></th>
         <th><?php echo lang('functions');?></th>
      </tr>
   </thead>
<?php
	$k=1;
	foreach($list as $rs):
?>
   <tr class="row<?php echo $k?>">
      <td><input type="checkbox" name="ar_id[]" value="<?php echo $rs->contact_id?>"></td>
	   
      <td><?php echo $rs->full_name?></td>
      <td><?php echo $rs->email?></td>
      <td><?php echo $rs->message;?></td>
      <td><?php echo format_date_show($rs->dt_create);?></td>
      
    <td class="center"><?php echo ($this->acl->check('edit'))?icon_edit($this->_module_name.'/contact/edit/'.$rs->contact_id):'';?>
         <span id="publish<?php echo $rs->contact_id?>">
         <?php echo icon_active("'tb_contact'","'contact_id'",$rs->contact_id,$rs->bl_active)?>
         </span>
         <?php echo ($this->acl->check('del'))?icon_del($this->_module_name.'/contact/del/'.$rs->contact_id.'/'.(int)$current_page):'';?>
    </td>
   </tr>
   <?php
            $k=1-$k;
            endforeach;?>
   <tfoot>
    <td colspan="6">
        <input type="submit" class="submit" onclick="return verify_del();" name="btn_submit" value="<?php echo lang('admin.deletes');?>">
          <?php echo lang('admin.total');?> 
          <?php echo $num?>
          <?php echo lang('admin.records');?> 
         <span class="pages">
             <?php echo $pagination?>
          </span>
    </td>
    </tfoot>
</table>
<?php echo form_close()?>