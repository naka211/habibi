<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-9">
                <div class="w-item-deal mb0">
                    <h3 class="text-uppercase mt0">Du skal med på date!</h3>
                    <div class="sort">
                        <div class="row">
                            <div class="col-lg-8">
                                <form action="" method="POST" class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label class="control-label col-xs-2" for="">Sorter efter</label>
                                        <div class="col-xs-5">
                                            <select name="" id="input" class="form-control">
                                                <option value="">Alle</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if($list){foreach($list as $row){?>
                        <div class="col-sm-6 item-deal">
                            <div class="deal-img">
                                <?php if($row['company']){ ?>
                                <a href="<?php echo site_url('tilbud/detail/'.$row['proID'].'/'.seoUrl($row['proName']));?>">
                                    <span class="cate-small"><?php echo $row['company'];?></span><?php }?>
                                <span class="vip_invation"><?php echo $row['name'];?></span>
                                <?php if($row['listimage']){?>
                                <div class="sync3 owl-carousel">
                                    <?php foreach($row['listimage'] as $rs){?>
                                    <div class="item">
                                        <a href="javascript:void(0)">
                                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/invita/<?php echo $rs->image;?>&w=425&h=185&q=100" alt="" class="img-responsive"/>
                                        </a>
                                    </div>
                                    <?php }?>
                                </div>
                                <?php }else{ if($row['image']){?>
                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row['image'];?>&w=425&h=185&q=100" alt="" class="img-responsive"/>
                                <?php }else{ ?>
                                <div style="height: 185px; background: #252525;">&nbsp;</div> 
                                <?php }}?>
                            <?php if($row['company']){ ?>
                                </a>
                            <?php }?>
                            </div>
                            <?php if($row['listimage']){?>
                            <div class="sync4 owl-carousel">
                                <?php foreach($row['listimage'] as $rs){?>
                                <div class="item"><a href="javascript:void(0)">
                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/invita/<?php echo $rs->image;?>&w=73&h=47&q=100" alt="" class="img-responsive"/>
                                </a></div>
                                <?php }?>
                            </div>
                            <?php }?>
                            <div class="deal-title">
                                <h3><?php echo $row['title'];?></h3>
                                <div>
                                    <?php echo $row['description'];?>
                                </div>
                                <?php if($row['proID']){?>
                                <a href="<?php echo site_url('tilbud/detail/'.$row['proID'].'/'.seoUrl($row['proName']));?>" class="btn-link">LÆS MERE</a>
                                <?php }?>
                            </div>
                            <div class="info-deal clearfix">
                                <div class="row mb10">
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="time">
                                            <p><?php echo $row['time'];?> timer for hver person</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <?php if($row['accept'] == 1){?>
                                        <span class="pull-right approved"><i class="fa fa-check fa-lg" aria-hidden="true"></i> Accepted</span>
                                        <?php }else if($row['accept'] == 2){?>
                                        <span class="pull-right"><img src="<?php echo base_url();?>templates/img/pub-del.png" /> Afvis</span>
                                        <?php }else{?>
                                        <a href="javascript:void(0)" onclick="acceptDating('<?php echo $row['datinguserID']?>')" class="btn_SeeMore">accept</a>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="profile_avatar">
                                            <a href="<?php echo site_url('user/profile/'.$row['userId'].'/'.seoUrl($row['nameUser']))?>">
                                            <?php echo modules::run('left/left/avatar',(object)$row, 46, 46);?>
                                            </a>
                                            <?php /*if($row['avatar']){if($row['facebook']){?>
                                            <img src="https://graph.facebook.com/<?php echo $row['facebook'];?>/picture?type=large" alt="" class="img-responsive"/>
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row['avatar'];?>&w=48&h=48&q=100" alt="" class="img-responsive"/>
                                            <?php }}else{?>
                                            <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="" width="48" height="48" class="img-responsive"/>
                                            <?php }*/?>
                                            <p><?php echo $row['nameUser'];?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <a href="<?php echo site_url('user/rejectmyinvitationerjoin/'.$row['datinguserID'])?>" class="btn_Delete pull-right">Afvis</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }}else{?>
                        <div class="col-sm-6 item-deal">
                            <p>Endnu ingen data!</p>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>