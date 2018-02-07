<option value="">Chọn</option>
<?php if($category){foreach($category as $row){?>
<option value="<?php echo $row->ward_id;?>"><?php echo $row->name;?></option>
<?php }}?>