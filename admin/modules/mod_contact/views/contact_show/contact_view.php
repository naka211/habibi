<?
	$attributes = array('class' => 'email', 'id' => 'checknew');
	echo form_open($this->_module_name.'/contact_show/dels', $attributes);
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
       
         <th><?php echo lang('ct_show.from');?></th>
         <th><?php echo lang('ct_show.to');?></th>
         <th><?php echo lang('ct_show.type_request');?></th>
         <th><?php echo lang('ct_show.date_create');?></th>
         <th width='120'><?php echo lang('functions');?></th>
      </tr>
   </thead>
<?
	$k=1;
	foreach($list as $rs):
?>
   <tr class="row<?php echo $k?>">
      <td><input type="checkbox" name="ar_id[]" value="<?php echo $rs->show_letter_id?>"></td>
	   
      <td><?php echo $rs->from?></td>
      <td><?php echo $rs->to?></td>
      <td>
          <?
            if($rs->type_letter==1){
              echo lang('ct_show.song');
            }elseif($rs->type_letter==2){
              echo lang('ct_show.play_list');
            }elseif($rs->type_letter==3){
              echo lang('ct_show.message');
            }
          ?>
      </td>
      <td><?php echo format_date_show($rs->dt_create);?></td>
      
    <td align="center"><?php echo ($this->acl->check('edit'))?icon_edit($this->_module_name.'/contact_show/edit/'.$rs->show_letter_id):'';?>
         <span id="publish<?php echo $rs->show_letter_id?>">
         <?//=icon_active("'fm_contact'","'show_letter_id'",$rs->show_letter_id,$rs->bl_active)?>
         </span>
         <?php echo ($this->acl->check('del'))?icon_del($this->_module_name.'/contact_show/del/'.$rs->show_letter_id.'/'.(int)$current_page):'';?>
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
