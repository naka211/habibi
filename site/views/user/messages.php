<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Besked</h3>
                    </div>
                </div>
            </div>
            <?php if(!empty($list)){
                foreach ($list as $user){
                    if(isGoldMember()){
                        $messageLink = 'data-fancybox data-src="#modalChat" href="javascript:void(0)" onclick="loadMoreMessages('.$user->id.',0, true)"';
                    } else {
                        $messageLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
                    }
            ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                <div class="frend_item <?php if($user->seen == 0) echo 'frend_item_new"';?>">
                    <?php if($user->seen == 0){?>
                        <span class="new">Ny</span>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="friend_item_avatar">
                                <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/user/<?php echo $user->avatar; ?>" alt="" class="img-responsive"></a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <h4><?php echo $user->name; ?></h4>
                            <p><?php echo printAge($user->year); ?> – <?php echo $user->region; ?></p>
                            <p>Sendt: d. <span><?php echo date("d/m/Y", $user->added_time); ?></span> kl. <span><?php echo date("H:i", $user->added_time); ?></span></p>
                            <p class="gray_friend_item"><?php echo word_limiter($user->message, 8);?></p>
                            <a <?php echo $messageLink;?> class="btn bntMessage">Se chatbesked</a>
                            <a onclick="confirmDeleteMessage(<?php echo $user->id;?>)" href="javascript:;" class="btn bntBlock">SLET</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
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
                <div class="chat">
                    <ul>
                    </ul>
                    <form class="frm_Chat" action="" method="POST" role="form">
                        <input type="text" class="form-control" id="message" placeholder="Skriv en besked her.........">
                        <button type="button" class="btn btnSend" onclick="sendMessage()">SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<div style="display: none;" id="modalConfirm" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p id="confirmText"></p>
            <div class="text-center">
                <a href="#" class="btn btnYes">JA</a>
                <a href="javascript:void(0);" onclick="$.fancybox.close();" class="btn btnNo">NEJ</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#messageMenu").addClass('active');
    });
</script>