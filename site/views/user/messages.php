<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Beskeder</h3>
                    </div>
                </div>
            </div>
            <?php if(!empty($list)){
                foreach ($list as $user){
                    if(!in_array($user->id, $ignore)){
                    if(isGoldMember()){
                        $messageLink = 'href="javascript:void(0)" onclick="loadMoreMessages('.$user->id.',0, true, \''.$user->name.'\')"';
                    } else {
                        $messageLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
                    }
            ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12 profile<?php echo $user->id;?>">
                <div class="frend_item">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="friend_item_avatar">
                                <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>">
                                <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                    <img src="<?php echo base_url();?>/uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive <?php if(!isGoldMember() && $user->avatar != 'no-avatar1.png' && $user->avatar != 'no-avatar2.png') echo 'blur'?>">
                                <?php } else {?>
                                    <img src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>" class="img-responsive <?php if(!isGoldMember() && $user->avatar != 'no-avatar1.png' && $user->avatar != 'no-avatar2.png') echo 'blur'?>">
                                <?php }?>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <?php if(isGoldMember()){?>
                                <h4><?php echo $user->name; ?> <?php if($user->login == 1){?><span class="status"></span><?php }?><?php if($user->seen == 0){?><span class="new">Ny</span><?php } ?></h4>
                            <?php }?>

                            <p><?php echo printAge($user->year); ?> – <?php echo $user->region; ?></p>
                            <p>Sendt: d. <span><?php echo date("d/m/Y", $user->added_time); ?></span> kl. <span><?php echo date("H:i", $user->added_time); ?></span></p>
                            <?php if(isGoldMember() === true){?>
                            <p class="gray_friend_item"><?php //echo character_limiter($user->message, 20);
                                echo substr($user->message, 0, 45); ?></p>
                            <?php }?>
                            <a <?php echo $messageLink;?> class="btn bntMessage">Besked</a>
                            <a onclick="confirmDeleteMessage(<?php echo $user->id;?>, 'Er du sikker på du vil slette chat historik?')" href="javascript:;" class="btn bntBlock">Slet historik</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }}
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
<?php if(isGoldMember()){?>
    <div style="display: none;" id="modalChat" class="animated-modal modalChat">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="javascript:;" class="btn bntBlock">Slet historik</a>
                <h4></h4>
                <div class="chat">
                    <ul>
                    </ul>
                    <form class="frm_Chat" action="" method="POST" role="form">
                        <input type="text" class="form-control" id="message" placeholder="Skriv en besked her.........">
                        <button type="button" class="btn btnSend">SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<script>
    $(document).ready(function() {
        $("#messageMenu").addClass('active');

        confirmDeleteMessage = function (profileId, text) {
            $('#confirmText').html(text);
            $('#modalConfirm .btnYes').attr('onclick', 'deleteMessage('+profileId+')');
            $.fancybox.open({src: '#modalConfirm'});
        }

        deleteMessage = function (profileId) {
            $.fancybox.destroy();
            callAjaxFunction(profileId, 'deleteMessage');
        }
    });
</script>