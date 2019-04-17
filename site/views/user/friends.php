<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <h3>Venner (<?php echo $friendQuantity;?>)</h3>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?php echo form_open('user/friends', array('method'=>'get', 'class'=>'frm_searchFriend'))?>
                            <button type="submit" class="btn btnSearch"></button>
                            <div class="form-group">
                                <input class="form-control" placeholder="Skriv navn for at søge..." type="text" name="keyword" value="<?php echo $this->input->get('keyword', true)?>">
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
            <?php if(!empty($list)){
                foreach($list as $profile){
                    if(isGoldMember()){
                        $messageLink = 'href="javascript:void(0)" onclick="loadMoreMessages('.$profile->id.',0, true, \''.$profile->name.'\')"';
                    } else {
                        $messageLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
                    }
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12 profile<?php echo $profile->id;?>">
                    <div class="frend_item <?php if($profile->new == 1) echo 'frend_item_new';?>">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="frend_item_avatar">
                                    <?php if($profile->blurIndex == 0 || ($profile->blurIndex != 0 && allowViewAvatar($profile->id))) { ?>
                                        <a href="<?php echo site_url('user/profile/'.$profile->id.'/'.$profile->name);?>"><img src="<?php echo base_url();?>/uploads/raw_thumb_user/<?php echo $profile->avatar;?>" class="img-responsive"></a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url('user/profile/'.$profile->id.'/'.$profile->name);?>"><img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $profile->avatar;?>" class="img-responsive"></a>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <h4>
                                    <?php echo $profile->name; ?> <?php if($profile->login == 1){?><span class="status"></span><?php }?><?php if($profile->new == 1){?><span class="new">Ny</span><?php } ?>
                                    <?php if($user->blurIndex != 0){
                                        if($profile->viewAvatar == 0){
                                            ?>
                                            <a href="javascript:void(0);" id="blurBtn<?php echo $profile->id?>" onclick="callAjaxFunction(<?php echo $profile->id?>, 'removeBlurAvatar')" class="btn btnadd_friend" style="float: right">Fjern sløring</a>
                                        <?php } else {?>
                                            <a href="javascript:void(0);" id="blurBtn<?php echo $profile->id?>" onclick="callAjaxFunction(<?php echo $profile->id?>, 'blurAvatar')" class="btn btn_cancel_request" style="float: right">Sløring</a>
                                        <?php }}?>
                                </h4>
                                <p><?php echo printAge($profile->year); ?> – <?php echo $profile->region; ?></p>
                                <p>Venner siden d. <?php echo date("d/m/Y", $profile->added_time); ?></p>
                                <a <?php echo $messageLink;?> class="btn bntMessage">Besked</a>
                                <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $profile->id;?>, 'unFriend')" class="btn bntDelete">Fjern ven</a>
                                <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $profile->id;?>, 'blockUser')" class="btn bntBlock">Bloker</a>
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
<div style="display: none;" id="modalConfirm" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p id="confirmText"></p>
            <div class="text-center">
                <a href="javascript:void(0);" class="btn btnYes">JA</a>
                <a href="javascript:void(0);" onclick="$.fancybox.close();" class="btn btnNo">NEJ</a>
            </div>
        </div>
    </div>
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
        $("#friendMenu").addClass('active');

        confirmDeleteMessage = function (profileId, text) {
            $('#confirmText').html(text);
            $('#modalConfirm .btnYes').attr('onclick', 'deleteMessage('+profileId+')');
            $.fancybox.open({src: '#modalConfirm'});
        }

        deleteMessage = function (profileId) {
            $.fancybox.destroy();
            callAjaxFunction(profileId, 'deleteMessage', false);
        }
    });
</script>