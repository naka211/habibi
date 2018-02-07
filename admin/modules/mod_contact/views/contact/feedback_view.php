<?
	$attributes = array('class' => 'email', 'id' => 'checknew');
	echo form_open($this->_module_name.'/feedback/dels', $attributes);
?>
<input type="hidden" name="current_page" value="<?php echo (int)$current_page?>">
<table class="admindata">
   <thead>
      <tr>
         <th colspan="6"> <input type="submit" onclick="return verify_del();" name="btn_submit" class="submit" value="<?php echo lang('admin.deletes');?>">
            <?php echo lang('admin.total');?> <?php echo $num?>  <?php echo lang('admin.records');?><span class="pages"> <?php echo $pagination?> </span> </th>
      </tr>
      <tr>
         <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'checknew');" /></th>
       
         <th><?php echo lang('full_name');?></th>
         <th><?php echo lang('subject');?></th>
         <th><?php echo lang('message');?></th>
         <th><?php echo lang('dtcreate');?></th>
         <th width='120'><?php echo lang('functions');?></th>
      </tr>
   </thead>
<?
	$k=1;
	foreach($list as $rs):
?>
   <tr class="row<?php echo $k?>">
      <td><input type="checkbox" name="ar_id[]" value="<?php echo $rs->feedback_id?>"></td>
	   
      <td><?php echo $rs->feedback_full_name?></td>
      <td><?php echo $rs->feedback_subject?></td>
      <td><?php echo $rs->feedback_message;?></td>
      <td><?php echo format_date_show($rs->feedback_dt_create)?></td>
      
    <td align="center">
        <?php echo ($this->acl->check('edit'))?icon_edit($this->_module_name.'/feedback/edit/'.$rs->feedback_id):'';?>
         <span id="publish<?php echo $rs->feedback_id?>">
         <?//=icon_active("'fm_feedback'","'feedback_id'",$rs->feedback_id,$rs->bl_active)?>
         </span>
         <?php echo ($this->acl->check('del'))?icon_del($this->_module_name.'/feedback/del/'.$rs->feedback_id.'/'.(int)$current_page):'';?>
    </td>
   </tr>
   <?
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
