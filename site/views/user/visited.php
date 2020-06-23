<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-tabs" style="margin-bottom: 0; border: none;">
                            <li><a href="<?php echo site_url('user/visitMe');?>">Besøgende</a></li>
                            <li class="active"><a href="javascript:void();">Jeg har besøgt</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php if(!empty($list)){
                foreach($list as $user){
                    $status = $this->user->checkStatus($userId, $user->id);
                    if($status->isFriend != 1){
                        if(isGoldMember()){
                            $sendBlinkLink = 'href="javascript:void(0);" onclick="sendBlink('.$user->id.')"';
                        } else {
                            $sendBlinkLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
                        }
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12 profile<?php echo $user->id;?>">
                    <div class="frend_item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="frend_item_avatar">
                                    <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                        <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/raw_thumb_user/<?php echo $user->avatar; ?>" alt="" class="img-responsive"></a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>" alt="" class="img-responsive"></a>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <h4><?php echo $user->name; ?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h4>
                                <p class="age_city"><?php echo printAge($user->id); ?> – <?php echo $user->region; ?></p>
                                <p>Besøgt: d. <?php echo date("d/m/Y", $user->seen_time); ?> kl.<span><?php echo date("H:i", $user->seen_time); ?></p>
                                <a <?php echo $sendBlinkLink;?> class="btn bntMessage"><?php echo $user->returnBlink?'Blink retur':'Send blink'?></a>
                                <?php if($status->isFriend == -1 || $status->isFriend == 2){?>
                                    <a href="javascript:void(0);" id="requestAddFriendBtn<?php echo $user->id;?>" class="btn bntMessage" onclick="callAjaxFunction(<?php echo $user->id;?>, 'requestAddFriendInFavorite')">Venneanmodning</a>
                                <?php }?>
                                <?php if($status->isFriend == 0){
                                    if(isGoldMember()){?>
                                        <a href="javascript:void(0);" id="requestAddFriendBtn<?php echo $user->id;?>" class="btn btn_cancel_request mb0" onclick="callAjaxFunction(<?php echo $user->id;?>, 'cancelAddFriendInFavorite')">Annuller anmodning</a>
                                    <?php } else {?>
                                        <a data-fancybox data-src="#modalUpgrade" href="javascript:;" class="btn btn_cancel_request mb0">Annuller anmodning</a>
                                    <?php }
                                }?>
                                <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $user->id;?>, 'blockUser')" class="btn bntBlock">Bloker</a>
                                <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $user->id;?>, 'deleteVisited')" class="btn bntDelete" style="margin-top: 5px;">Slet</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
                }
            }?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <ul class="pagination friends_pagination">
                        <?php echo $pagination;?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("#visitMenu").addClass('active');
    });
</script>