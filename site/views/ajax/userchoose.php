<div class="col-lg-10">
    <?php if($list){foreach($list as $row){?>
    <a href="javascript:void(0)" class="btn_item" id="user_choosed_<?php echo $row->id;?>">
        <?php echo $row->name;?>
        <i onclick="removeUserChoose('<?php echo $row->id;?>')" class="fa fa-times-circle fa-lg" aria-hidden="true"></i>
        <input name="userID[]" type="hidden" value="<?php echo $row->id;?>" />
    </a>
    <?php }}?>
</div>