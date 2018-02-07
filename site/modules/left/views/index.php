<?php
if(isGoldMember()){
    $shoutoutLink = 'href="'.site_url('user/shoutouts').'"';
    $myInvitationLink = 'href="'.site_url('user/myinvitationer').'"';
    $myJoinInvitationLink = 'href="'.site_url('user/myinvitationerjoin').'"';
    $myApprovedInvitationLink = 'href="'.site_url('user/myinvitationerapproved').'"';
} else {
    $shoutoutLink = $myInvitationLink = $myJoinInvitationLink = $myApprovedInvitationLink = 'href="#PUupgrade" data-toggle="modal"';
}
?>
<div class="col-md-3">
    <div class="img_product">
        <!--<p class="f12">Profilenr. <?php /*echo $item->id;*/?></p>-->
        <div class="row">
            <div class="col-lg-12">
                <div id="sync1" class="owl-carousel">
                    <div class="item">
                        <a href="javascript:void(0)">
                            <?php echo modules::run('left/left/avatar',(object)$item, 263, 263);?>
                        </a>
                    </div>
                    <?php if($photo){ foreach($photo as $row){?>
                    <div class="item">
                        <a href="javascript:void(0)">
                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/user/<?php echo $row->image;?>&w=263&h=263&q=100" alt="" class="img-responsive"/>
                        </a>
                    </div>
                    <?php }}?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="sync2" class="owl-carousel">
                    <div class="item">
                        <a href="javascript:void(0)">
                            <?php echo modules::run('left/left/avatar',(object)$item, 63, 63);?>
                        </a>
                    </div>
                    <?php if($photo){ foreach($photo as $row){?>
                    <div class="item">
                        <a href="javascript:void(0)">
                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/user/<?php echo $row->image;?>&w=63&h=63&q=100" alt="" class="img-responsive"/>
                        </a>
                    </div>
                    <?php }}?>
                </div>
            </div>
        </div>
    </div>

    <?php if($item->slogan){?>
        <p class="f12 profile_number2"><?php echo $item->slogan; ?></p>
    <?php }?>

    <ul class="list_info_profile">
        <li><a href="<?php echo site_url('user/profile/'.$item->id.'/'.seoUrl($item->name))?>">Se min Profil</a></li>
        <li><a href="<?php echo site_url('user/myphoto')?>">Mine Billeder (<span class="red" id="num-myphoto"><?php if($numphoto){echo $numphoto;}else{echo '0';}?></span>)</a></li>
        <li><a href="<?php echo site_url('user/mydeal')?>">Mine tilbud</a></li>
        <li><a href="<?php echo site_url('user/mymessages')?>">Mine beskeder (<span class="red"><?php echo $numUnreadMessage;?></span>)</a></li>
        <li><a <?php echo $myInvitationLink;?>>Mine invitationer</a></li>
        <li><a <?php echo $myJoinInvitationLink;?>>Du skal forkæles! (<span class="red"><?php echo $numinvitajoin;?></span>)</a></li>
        <li><a <?php echo $myApprovedInvitationLink;?>>Det er mig der forkæler! (<span class="red"><?php echo $numinvitaapproved;?></span>)</a></li>
        <li><a href="<?php echo site_url('user/mycontactperson')?>">Mine Kontaktpersoner</a></li>
        <li><a href="<?php echo site_url('user/sentkisses')?>">Sendt kys</a></li>
        <li><a href="<?php echo site_url('user/receivedkisses')?>">Modtaget kys</a></li>
        <li><a <?php echo $shoutoutLink;?>>Se shoutouts</a></li>
        <li><a href="<?php echo site_url('user/blocked')?>">Blokeret liste</a></li>
    </ul>
</div>