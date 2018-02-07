<option value="">Chọn</option>
<?php if($district){foreach($district as $row){?>
<option value="<?php echo $row->district_id;?>"><?php echo $row->name;?></option>
<?php }}?>