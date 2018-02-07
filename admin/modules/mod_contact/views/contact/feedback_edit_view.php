<?php echo form_open(uri_string());?>
<table class="form">
   <tr>
      <td class="w150  label"><?php echo lang('full_name');?></td>
      <td><?php echo $rs->feedback_full_name;?></td>
   </tr>
   <tr>
      <td valign="top" class=" label"><?php echo lang('subject');?></td>
      <td><?php echo $rs->feedback_subject;?></td>
   </tr>
   <tr>
      <td class="label"><?php echo lang('phone');?></td>
      <td><?php echo $rs->feedback_phone;?></td>
   </tr>
   <tr>
      <td class="label"><?php echo lang('email');?></td>
      <td><?php echo $rs->feedback_email;?></td>
   </tr>
    <tr>
      <td class="label"><?php echo lang('message');?></td>
      <td><?php echo $rs->feedback_message;?></td>
   </tr>
    <tr>
      <td class="label"><?php echo lang('dtcreate');?></td>
      <td><?php echo format_date_show($rs->feedback_dt_create)?></td>
   </tr>
</table>
<?php echo form_close();?>