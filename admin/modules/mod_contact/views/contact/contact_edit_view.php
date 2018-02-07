<?php echo form_open(uri_string());?>
<table class="form">
   <tr>
      <td class="w150  label"><?php echo lang('full_name');?></td>
      <td><?php echo $rs->full_name;?></td>
   </tr>
   <tr>
      <td class="label">Điện thoại</td>
      <td><?php echo $rs->phone;?></td>
   </tr>
   <tr>
      <td class="label">Email</td>
      <td><?php echo $rs->email;?></td>
   </tr>
    <tr>
      <td class="label"><?php echo lang('message');?></td>
      <td><?php echo $rs->message;?></td>
   </tr>
    <tr>
      <td class="label"><?php echo lang('dtcreate');?></td>
      <td><?php echo format_date_show($rs->dt_create)?></td>
   </tr>
</table>
<?php echo form_close();?>