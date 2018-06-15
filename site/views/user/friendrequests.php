<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead" style="border-bottom: none;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#receivedSection">Venneanmodninger</a></li>
                            <li><a data-toggle="tab" href="#sentSection">Sendte</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="receivedSection" class="tab-pane fade in active">
                                <?php
                                if(!empty($receivedRequests)) {
                                    foreach ($receivedRequests as $key => $user) {
                                        if(isGoldMember()){
                                            $acceptLink = 'href="'.site_url('user/acceptAddFriend/'.$user->id).'"';
                                            $rejectLink = 'href="'.site_url('user/rejectAddFriend/'.$user->id).'"';
                                            $blockLink = 'href="'.site_url('user/blockUser/'.$user->id).'"';

                                        } else {
                                            $acceptLink = $rejectLink = $blockLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
                                        }
                                        ?>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="frend_item">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-3 col-xs-3">
                                                        <div class="frend_item_avatar">
                                                            <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>" alt="" class="img-responsive <?php if(!isGoldMember() && $user->avatar != 'no-avatar.jpg') echo 'blur'?>"></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-ms-9 col-xs-9">
                                                        <?php if(isGoldMember()){?>
                                                            <h4><?php echo $user->name; ?></h4>
                                                        <?php }?>
                                                        <p><?php echo printAge($user->year); ?> – <?php echo $user->region; ?></p>
                                                        <p>Modtaget: d.<span><?php echo date("d/m/Y", $user->dt_create); ?></span> kl.<span><?php echo date("H:i", $user->dt_create); ?></span>
                                                        </p>
                                                        <a <?php echo $acceptLink;?> class="btn bntMessage">Acceptere</a>
                                                        <a <?php echo $rejectLink;?> class="btn bntReject">Afvise</a>
                                                        <a <?php echo $blockLink;?> class="btn bntBlock">Blok</a>
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
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="frend_item">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-3 col-xs-3">
                                                        <div class="frend_item_avatar">
                                                            <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>" alt="" class="img-responsive"></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-ms-9 col-xs-9">
                                                        <h4><?php echo $user->name; ?></h4>
                                                        <p><?php echo printAge($user->year); ?> – <?php echo $user->region; ?></p>
                                                        <p>Modtaget: d.<span><?php echo date("d/m/Y", $user->dt_create); ?></span> kl.<span><?php echo date("H:i", $user->dt_create); ?></span>
                                                        </p>
                                                        <a href="<?php echo site_url('user/cancelAddFriend/' . $user->id); ?>"
                                                           class="btn bntBlock">Annuller anmodning</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else {?>
                                    Ingen anmodning
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