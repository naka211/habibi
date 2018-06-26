<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>FAVORITTER LIST</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach($list as $user){?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6">
                    <div class="box_favorites_item">
                        <div class="favorites_img">
                            <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>" alt="" class="img-responsive"></a>
                            <div class="gallery_number"><i class="i_img"></i> <span><?php echo countImages($user->id);?></span></div>
                            <div class="favorites_footer">
                                <?php if(isFriend($user->id) == false){?><a href="<?php echo site_url('user/requestAddFriend/'.$user->id);?>" class="btn btn_addFriend">Tilføj ven</a><?php }?>
                                <a href="javascript:void(0)"; onclick="confirmRemoveFavorite(<?php echo $user->id;?>)" class="btn btn_addRemove">Remove</a>
                            </div>
                        </div>
                        <h5 class="name"><?php echo $user->name;?></h5>
                        <p class="nation"><?php echo $user->ethnic_origin;?></p>
                        <p class="old"><?php echo printAge($user->year);?> – <span class="area"><?php echo $user->region;?></span></p>
                        <p class="old">Tilføjet tid: d. <span><?php echo date("d/m/Y", $user->added_time); ?></span> kl. <span><?php echo date("H:i", $user->added_time); ?></p>
                    </div>
                </div>
                <?php }?>
            </div>
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
                <a href="#" class="btn btnYes">JA</a>
                <a href="javascript:void(0);" onclick="$.fancybox.close();" class="btn btnNo">NEJ</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
       $("#favoriteMenu").addClass('active');
    });
</script>