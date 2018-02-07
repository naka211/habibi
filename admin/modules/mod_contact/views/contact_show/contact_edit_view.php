<?php echo form_open(uri_string());?>
<table class="form">
   <tr>
      <td class="label"><?php echo lang('ct_show.time');?></td>
      <td><?php echo $rs->time;?></td>
   </tr>
    <tr>
      <td class="label"><?php echo lang('ct_show.message');?></td>
      <td><textarea style="height: 325px;margin: 10px 0;width: 680px;"><?php echo $rs->content;?></textarea></td>
   </tr>
    <tr>
      <td class="label"><?php echo lang('ct_show.right');?></td>
      <td><?
            if($rs->bl_right==1){
              echo "1clickFM có quyền sử dụng nội dung này để thực hiện chương trình.";
            }else{
              echo "1clickFM không có quyền sử dụng nội dung này để thực hiện chương trình.";
            }
            ?>
      </td>
   </tr>
</table>
<?php echo form_close();?>