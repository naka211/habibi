<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-8">
                <div class="main_right">
                    <div class="invitationer_box">
                        <h3 class="text-uppercase">Modtaget kys</h3>
                        <div class="row">
                            <?php if($list){foreach($list as $row){?>
                            <div class="col-md-3 col-xs-4 item_people">
                                <div class="img-people">
                                    <a class="box_img_people active" href="<?php echo site_url('user/profile/'.$row['id'].'/'.seoUrl($row['name']))?>">
                                        <?php if($row['avatar']){if($row['facebook']){?>
                                        <img src="https://graph.facebook.com/<?php echo $row['facebook'];?>/picture?type=large" alt="" class="img-responsive"/>
                                        <?php }else{ ?>
                                        <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row['avatar'];?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
                                        <?php }}else{?>
                                        <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="" class="img-responsive"/>
                                        <?php }?>
                                        <span class="i_heart"></span>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col-xs-9">
                                        <p class="name">
                                            <a href="<?php echo site_url('user/profile/'.$row['id'].'/'.seoUrl($row['name']))?>">
                                                <?php echo $row['name'];?>
                                            </a>
                                        </p>
                                        <p class="profile_number"><span class="dates"><?php echo date('d.m.Y', $row['send_at'])?></span> <span class="times">Kl.<?php echo date('H:i', $row['send_at'])?></span></p>
                                        <?php if($row['birthday']){$yearold = date('Y',time()) - explode('/',$row['birthday'])[2];}else{$yearold = "";}?>
                                        <p class="age">Age: <?php echo $yearold;?></p>
                                        <p class="postcode">Postnr. : <?php echo $row['code'];?></p>
                                    </div>
                                    <div class="col-xs-3">
                                        <p class="pull-right mt10"><span class="status-online"></span></p>
                                    </div>
                                </div>
                            </div>
                            <?php }}else{?>
                            <div class="col-md-3 col-xs-4 item_people">
                                <p>Der er ingen data!</p>
                            </div>
                            <?php }?>
                        </div>
                        <div class="row text-center">
                          <ul class="pagination">
                            <?php echo $pagination;?>
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#menu_favorit').addClass('active');
});
</script>