<?php
$user = getUser();
$friendRequestQuantity = $this->user->friendRequestQuantity($user->id);
$rejectRequestQuantity = $this->user->rejectRequestQuantity($user->id, 1);
$friendRequestQuantityHTML = $friendRequestQuantity != 0 ? '<span>' . $friendRequestQuantity . '</span>' : '';
$rejectRequestQuantityHTML = $rejectRequestQuantity != 0 ? '<span>' . $rejectRequestQuantity . '</span>' : '';
?>
<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead" style="border-bottom: none;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#receivedSection">Modtagne <?php echo $friendRequestQuantityHTML;?></a></li>
                            <li><a data-toggle="tab" href="#sentSection">Sendte</a></li>
                            <li><a data-toggle="tab" href="#rejectedSection">Afviste <?php echo $rejectRequestQuantityHTML;?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="receivedSection" class="tab-pane fade in active">
                                <?php
                                if(!empty($receivedRequests)) {
                                    foreach ($receivedRequests as $key => $user) {
                                        if(isGoldMember()){
                                            $acceptLink = 'onclick="callAjaxFunction('.$user->id.', \'acceptAddFriend\')"';
                                            $rejectLink = 'onclick="callAjaxFunction('.$user->id.', \'rejectAddFriend\')"';
                                            $blockLink = 'onclick="callAjaxFunction('.$user->id.', \'blockUser\')"';
                                            $profileLink = 'href="'.site_url('user/profile/'.$user->id.'/'.$user->name).'"';
                                        } else {
                                            $acceptLink = $rejectLink = $blockLink = $profileLink = 'data-fancybox data-src="#modalUpgrade"';
                                        }
                                        ?>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 profile<?php echo $user->id;?>">
                                            <div class="frend_item">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-3 col-xs-12">
                                                        <div class="frend_item_avatar">
                                                            <a <?php echo $profileLink;?>>
                                                                <img src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>" alt="" class="img-responsive <?php if(!isGoldMember() && $user->avatar != 'no-avatar1.png' && $user->avatar != 'no-avatar2.png') echo 'blur'?>">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-ms-9 col-xs-12">
                                                        <?php if(isGoldMember()){?>
                                                            <h4><?php echo $user->name; ?> <?php if($user->login == 1){?><span class="status"></span><?php }?><span class="new">Ny</span></h4>
                                                        <?php }?>
                                                        <p><?php echo printAge($user->id); ?> – <?php echo $user->region; ?></p>
                                                        <p>Modtaget: d.<span><?php echo date("d/m/Y", $user->dt_create); ?></span> kl.<span><?php echo date("H:i", $user->dt_create); ?></span>
                                                        </p>
                                                        <a href="javascript:void(0);" <?php echo $acceptLink;?> class="btn bntMessage">Acceptere</a>
                                                        <a href="javascript:void(0);" <?php echo $rejectLink;?> class="btn bntReject">Afvis</a>
                                                        <a href="javascript:void(0);" <?php echo $blockLink;?> class="btn bntBlock">Bloker</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else {?>
                                    Ingen anmodning
                                <?php }?>
                            </div>

                            <div id="sentSection" class="tab-pane fade">
                                <?php
                                if(!empty($sentRequests)) {
                                    foreach ($sentRequests as $key => $user) { ?>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 profile<?php echo $user->id;?>">
                                            <div class="frend_item">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-3 col-xs-12">
                                                        <div class="frend_item_avatar">
                                                            <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>" alt="" class="img-responsive"></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-ms-9 col-xs-12">
                                                        <h4><?php echo $user->name; ?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h4>
                                                        <p><?php echo printAge($user->id); ?> – <?php echo $user->region; ?></p>
                                                        <p>Sendt: d.<span><?php echo date("d/m/Y", $user->dt_create); ?></span> kl.<span><?php echo date("H:i", $user->dt_create); ?></span>
                                                        </p>
                                                        <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $user->id;?>, 'cancelAddFriend')" class="btn bntBlock">Annuller anmodning</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else {?>
                                    Ingen anmodning
                                <?php }?>
                            </div>

                            <div id="rejectedSection" class="tab-pane fade">
                                <?php
                                if(!empty($rejectedRequests)) {
                                    foreach ($rejectedRequests as $key => $user) {
                                        if(isGoldMember()){
                                            //$reAddFriendLink = 'onclick="callAjaxFunction('.$user->id.', \'reAddFriend\')"';
                                            $profileLink = 'href="'.site_url('user/profile/'.$user->id.'/'.$user->name).'"';
                                        } else {
                                            //$reAddFriendLink = $profileLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
                                        }
                                        ?>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 profile<?php echo $user->id;?>">
                                            <div class="frend_item">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-3 col-xs-12">
                                                        <div class="frend_item_avatar">
                                                            <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>" alt="" class="img-responsive"></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-ms-9 col-xs-12">
                                                        <h4><?php echo $user->name; ?> <?php if($user->login == 1){?><span class="status"></span><?php }?><?php if($user->seen == 0){?><span class="new">Ny</span><?php }?></h4>
                                                        <p><?php echo printAge($user->id); ?> – <?php echo $user->region; ?></p>
                                                        <p>Afvist: d.<span><?php echo date("d/m/Y", $user->dt_update); ?></span> kl.<span><?php echo date("H:i", $user->dt_update); ?></span>
                                                        </p>
                                                        <!--<a <?php /*echo $reAddFriendLink;*/?> class="btn btnadd_friend" style="margin-bottom: 0px;">Venneanmodning</a>-->
                                                        <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $user->id;?>, 'cancelAddFriend')" class="btn btnUnfriend" style="margin: 10px 0 0">Slet</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else {?>
                                    Ingen afvist
                                <?php }?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("#friendRequestMenu").addClass('active');
    });
</script>