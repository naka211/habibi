<option value="">Chọn</option>
<?php if($category){foreach($category as $row){?>
<option value="<?php echo $row->district_id;?>"><?php echo $row->name;?></option>
<?php }}?>