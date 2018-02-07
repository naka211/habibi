<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?php echo $title;?></h4>
        </div>
        <div class="modal-body">
            <div class="frm_search">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6 col-md-8">
                            <p>Indtast profilnavn eller profilnr. på VIP brugeren</p>
                            <input type="text" name="namesearch" id="namesearch" class="form-control"/>
                        </div>
                        <div class="col-xs-3 col-md-2">
                            <p>&nbsp;</p>
                            <input type="hidden" name="type" id="type" value="<?php echo $type;?>" />
                            <button onclick="findUser()" type="button" class="btn btnSearch">Søg</button>
                        </div>
                        <div class="col-xs-3 col-md-2">
                            <p>&nbsp;</p>
                            <button type="button" onclick="sendUser()" class="btn btnSearch">Tilføj</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p><a class="btn_link_custom" href="javascript:void(0)" onclick="selectAll()">Vælg alle</a> <a class="btn_link_custom" href="javascript:void(0)" onclick="deleteAll()">Slette alle</a></p>
                </div>
            </div>
            <?php echo form_open_multipart(site_url('invitationer/chooseUser'), array('name'=>'frm_chooseUser','id'=>'frm_chooseUser'))?>
            <div class="list_search" id="list-search-user">
                <div class="row">
                    <?php if($list){foreach($list as $row){?>
                    <div class="col-md-3 col-xs-6">
                        <div class="box_info_people">
                            <div class="img_vatatar">
                                <a href="javascript:void(0)" onclick="shooseClick('<?php echo $row['id'];?>')" id="btn_choose_<?php echo $row['id'];?>" class="btn_choose"></a>
                                <input style="display: none;" type="checkbox" class="listUser" name="listUser[]" id="chooseUser_<?php echo $row['id'];?>" value="<?php echo $row['id'];?>" />
                                <a href="<?php echo site_url('user/profile/'.$row['id'].'/'.seoUrl($row['name']))?>">
                                    <?php echo modules::run('left/left/avatar',(object)$row, 150, 150);?>
                                    <?php /*if($row['avatar']){if($row['facebook']){?>
                                    <img src="https://graph.facebook.com/<?php echo $row['facebook'];?>/picture?type=large" alt="" class="img-responsive"/>
                                    <?php }else{ ?>
                                    <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row['avatar'];?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
                                    <?php }}else{?>
                                    <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="" class="img-responsive"/>
                                    <?php }*/?>
                                </a>
                            </div>
                            <div class="info_detail">
                                <p class="name"><?php echo $row['name'];?></p>
                                <!--<p class="profile_number">Profilenr. <?php /*echo $row['id'];*/?></p>-->
                                <?php if($row['birthday']){$yearold = date('Y',time()) - explode('/',$row['birthday'])[2];}else{$yearold = "";}?>
                                <p>Age: <?php echo $yearold;?></p>
                                <p>Postnr.: <?php echo $row['code'];?></p>
                            </div>
                            <!--p class="text-center"><a href="javascript:void(0)" class="btn btnAdd">Tilføj</a></p-->
                        </div>
                    </div>
                    <?php }}?>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>