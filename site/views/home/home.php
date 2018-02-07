<?php $user = $this->session->userdata['user'];?>
<section class="banner_custom mt150">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl_bannner_custom owl-carousel">
                    <?php foreach($listImages as $image){?>
                    <div class="item">
                        <img src="<?php echo base_url();?>uploads/banner/<?php echo $image->image;?>" alt="" class="img-responsive">
                    </div>
                    <?php }?>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="dating-location">
    <div class="container">
        <h2 class="title2">Nyeste profiler</h2>
        <div class="row newest-profiles">
            <div class="col-md-12">
                <div id="newest_profiles" class="owl-carousel">
                    <?php 
                    if($listUser){foreach($listUser as $row){
                        if($row['birthday']){
                            $yearold = date('Y',time()) - explode('/',$row['birthday'])[2];
                        }else{
                            $yearold = "";
                        }
                    ?>
                    <div class="item">
                        <div class="item-img">
                            <a href="<?php echo site_url('user/profile/'.$row['id'].'/'.seoUrl($row['name']));?>">
                                <?php echo modules::run('left/left/avatar',(object)$row, 180, 180);?>
                                <?php /*if($row['avatar']){if($row['facebook']){?>
                                <img src="https://graph.facebook.com/<?php echo $row['facebook'];?>/picture?type=square&w‌​idth=180&height=180" alt="" class="img-responsive"/>
                                <?php }else{ ?>
                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row['avatar'];?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
                                <?php }}else{?>
                                <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="" class="img-responsive"/>
                                <?php }*/?>
                            </a>
                        </div>
                        <div class="info">
                            <h3><?php echo $row['name'];?></h3>
                            <p>Age: <?php echo $yearold;?></p>
                            <p>Postnr.: <?php echo $row['code'];?></p>
                        </div>
                    </div>
                    <?php }}?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="border-customer"></div>
            </div>
        </div>
        <div class="row">
            <div class="latest_profiles">
                <div class="col-lg-6">
                    <h2 class="title2">Nyeste profiler</h2>
                    <div id="owl_latest_profiles" class="owl-carousel owl-theme">
                        <?php
                        if($listUser){foreach($listUser as $row){
                        if($row['birthday']){
                            $yearold = date('Y',time()) - explode('/',$row['birthday'])[2];
                        }else{
                            $yearold = "";
                        }
                        ?>
                        <div class="item">
                            <div class="item-img">
                                <a href="<?php echo site_url('user/profile/'.$row['id'].'/'.seoUrl($row['name']));?>">
                                    <?php echo modules::run('left/left/avatar',(object)$row, 268, 268);?>
                                    <?php /*if($row['avatar']){if($row['facebook']){?>
                                        <img src="https://graph.facebook.com/<?php echo $row['facebook'];?>/picture?type=large" alt="" class="img-responsive"/>
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row['avatar'];?>&w=268&h=268&q=100" alt="" class="img-responsive"/>
                                    <?php }}else{?>
                                        <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="" class="img-responsive"/>
                                    <?php }*/?>
                                </a>
                            </div>
                            <div class="info">
                                <h3><?php echo $row['name'];?></h3>
                                <p>Age: <?php echo $yearold;?></p>
                                <p>Postnr.: <?php echo $row['code'];?></p>
                            </div>
                        </div>
                        <?php }}?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="owl_latest_profiles_text">
                        <h4><?php echo $article->title;?></h4>
                        <?php echo $article->content;?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="border-customer"></div>
            </div>
        </div>
        <div class="row latest-offers">
            <div class="col-lg-12">
                <h2 class="title2">Nyeste tilbud</h2>
                <div id="owl_latest_offers" class="owl-carousel">
                    <?php if($listPro){foreach($listPro as $row){?>
                    <div class="item">
                        <div class="item-img">
                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row->image;?>&w=570&h=250&q=100" alt="" class="img-responsive"/>
                            <span class="cate"><?php echo $row->company;?></span>
                            <div class="item-content clearfix">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h3><?php echo $row->name; ?></h3>
                                        <p><?php echo $row->description; ?></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="price">Pris:<?php echo priceFormat($row->price); ?></div>
                                        <a href="<?php echo site_url('tilbud/detail/' . $row->id . '/' . seoUrl($row->name)); ?>" class="btn btnOderNow">Bestil nu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }}?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="border-customer"></div>
            </div>
        </div>
        <div class="row latest-offers">
            <div class="col-lg-6">
                <h2 class="title2">Nyeste events</h2>
                <?php if($newEvents){?>
                <div id="owl_latest_events" class="owl-carousel">
                    <?php foreach($newEvents as $event){
                        if($event->birthday){
                            $yearold = date('Y',time()) - explode('/',$event->birthday)[2];
                        }else{
                            $yearold = "";
                        }
                        ?>
                    <div class="item">
                        <div class="item-img">
                            <img src="<?php echo site_url()?>uploads/invita/<?php echo $event->image;?>" alt="" class="img-responsive">
                            <!--<span class="cate">Restaurant</span>-->
                            <div class="item-content">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <h3><?php echo $event->title;?></h3>
                                        <p><?php echo $event->content;?></p>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="avatar_bottom">
                                            <a class="has-tooltip west" href="#">
                                                <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="" class="img-responsive img_clear">
                                                <span class="tooltip">
                                                        <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" alt="">
                                                        <h3><?php echo $event->name;?></h3>
                                                        <span>Alder: <?php echo $yearold;?> år
                                                            <br> Postnr. <?php echo $event->code;?></span>
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <?php }?>
            </div>
            <div class="col-lg-6">
                <div class="latest_popular_events">
                    <img src="<?php echo base_url();?>uploads/banner/<?php echo $rightBanner[0]->image;?>" alt="" class="img-responsive">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="border-customer"></div>
            </div>
        </div>
        <div class="row public-invitations">
            <div class="col-md-6">
                <h2>Offentlige invitationer</h2>
                <div id="owl-demo3" class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="item-img">
                            <span class="cate">Restaurant</span>
                            <img src="<?php echo base_url();?>templates/img/img05-larg.jpg" alt="" class="img-responsive">
                            <div class="item-content">
                                <h3>Restaurant Sletten</h3>
                                <p>Succesen er tilbage!!! Inviter på den ultimative spiseoplevelse når formel B byder på
                                    <br>aperitif, 4 sublime retter, vinmenu, kaffe, the & petit four.</p>
                            </div>
                        </div>
                        <div class="info-bottom clearfix">
                            <ul class="list-peo clearfix">
                                <li>
                                    <a href="#">
                                        <img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo12-small-2.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo12-small-2.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                        <div class="box-tooltip">
                                            <div class="popover2 arrow-left clearfix">
                                                <img src="<?php echo base_url();?>templates/img/peo12-small-2.jpg" alt="">
                                                <h3>Heidi H.</h3>
                                                <p>Alder: 29 år
                                                    <br> Postnr. 2000</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-img">
                            <span class="cate">Ophold</span>
                            <img src="<?php echo base_url();?>templates/img/img05-larg.jpg" alt="" class="img-responsive">
                            <div class="item-content">
                                <h3>Restaurant Sletten</h3>
                                <p>Succesen er tilbage!!! Inviter på den ultimative spiseoplevelse når formel B byder på
                                    <br>aperitif, 4 sublime retter, vinmenu, kaffe, the & petit four.</p>
                            </div>
                        </div>
                        <div class="info-bottom clearfix">
                            <ul class="list-peo clearfix">
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-img">
                            <span class="cate">Restaurant</span>
                            <img src="<?php echo base_url();?>templates/img/img05-larg.jpg" alt="" class="img-responsive">
                            <div class="item-content">
                                <h3>Restaurant Sletten</h3>
                                <p>Succesen er tilbage!!! Inviter på den ultimative spiseoplevelse når formel B byder på
                                    <br>aperitif, 4 sublime retter, vinmenu, kaffe, the & petit four.</p>
                            </div>
                        </div>
                        <div class="info-bottom clearfix">
                            <ul class="list-peo clearfix">
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-img">
                            <span class="cate">Ophold</span>
                            <img src="<?php echo base_url();?>templates/img/img05-larg.jpg" alt="" class="img-responsive">
                            <div class="item-content">
                                <h3>Restaurant Sletten</h3>
                                <p>Succesen er tilbage!!! Inviter på den ultimative spiseoplevelse når formel B byder på
                                    <br>aperitif, 4 sublime retter, vinmenu, kaffe, the & petit four.</p>
                            </div>
                        </div>
                        <div class="info-bottom clearfix">
                            <ul class="list-peo clearfix">
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo12-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo13-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo14-small.jpg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?php echo base_url();?>templates/img/peo15-small.jpg" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h2>Shoutouts</h2>
                <?php if(!empty($shoutouts)){?>
                <div id="owl-demo4" class="owl-carousel owl-theme">
                    <?php for($i = 0; $i < count($shoutouts); $i = $i + 2){?>
                    <div class="item">
                        <div class="row border2">
                            <div class="box-info clearfix">
                                <div class="col-md-3 col-xs-3">
                                    <div class="box-info-img">
                                        <a href="<?php echo site_url('user/profile/'.$shoutouts[$i]->userId.'/'.seoUrl($shoutouts[$i]->name));?>">
                                        <?php echo modules::run('left/left/avatar',(object)$shoutouts[$i], 122, 122);?>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-9">
                                    <div class="box-info-detail">
                                        <h4><a href="<?php echo site_url('user/profile/'.$shoutouts[$i]->userId.'/'.seoUrl($shoutouts[$i]->name));?>"><?php echo $shoutouts[$i]->name?></a></h4>
                                        <p>“ <?php echo $shoutouts[$i]->content?> ”</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(!empty($shoutouts[$i+1])){?>
                        <div class="row">
                            <div class="box-info clearfix">
                                <div class="col-md-3 col-xs-3">
                                    <div class="box-info-img">
                                        <a href="<?php echo site_url('user/profile/'.$shoutouts[$i+1]->userId.'/'.seoUrl($shoutouts[$i+1]->name));?>">
                                        <?php echo modules::run('left/left/avatar',(object)$shoutouts[$i+1], 122, 122);?>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-9">
                                    <div class="box-info-detail">
                                        <h4><a href="<?php echo site_url('user/profile/'.$shoutouts[$i+1]->userId.'/'.seoUrl($shoutouts[$i+1]->name));?>"><?php echo $shoutouts[$i+1]->name?></a></h4>
                                        <p>“ <?php echo $shoutouts[$i+1]->content?> ”</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <?php }?>
                </div>
                <?php } else {echo 'Ingen shoutout at vise';}?>
            </div>
        </div>
    </div>
</section>