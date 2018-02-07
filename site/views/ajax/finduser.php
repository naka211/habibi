<div class="row">
    <?php if($list){foreach($list as $row){?>
    <div class="col-md-3 col-xs-6">
        <div class="box_info_people">
            <div class="img_vatatar">
                <a href="javascript:void(0)" onclick="shooseClick('<?php echo $row['id'];?>')" id="btn_choose_<?php echo $row['id'];?>" class="btn_choose"></a>
                <input style="display: none;" type="checkbox" class="listUser" name="listUser[]" id="chooseUser_<?php echo $row['id'];?>" value="<?php echo $row['id'];?>" />
                <a href="<?php echo site_url('user/profile/'.$row['id'].'/'.seoUrl($row['name']))?>">
                    <?php if($row['avatar']){if($row['facebook']){?>
                    <img src="https://graph.facebook.com/<?php echo $row['facebook'];?>/picture?type=large" alt="" class="img-responsive"/>
                    <?php }else{ ?>
                    <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row['avatar'];?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
                    <?php }}else{?>
                    <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="" class="img-responsive"/>
                    <?php }?>
                </a>
            </div>
            <div class="info_detail">
                <p class="name"><?php echo $row['name'];?></p>
                <p class="profile_number">Profilenr. <?php echo $row['id'];?></p>
                <?php if($row['birthday']){$yearold = date('Y',time()) - explode('/',$row['birthday'])[2];}else{$yearold = "";}?>
                <p>Age: <?php echo $yearold;?></p>
                <p>Viborg</p>
            </div>
            <!--p class="text-center"><a href="javascript:void(0)" class="btn btnAdd">Tilføj</a></p-->
        </div>
    </div>
    <?php }}else{?>
    <p style="padding: 10px;">Der er ingen data, der matcher søgekriterierne.</p>
    <?php }?>
</div>