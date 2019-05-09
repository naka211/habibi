<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Favoritter</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach($list as $user){?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6 profile<?php echo $user->id;?>">
                    <div class="box_favorites_item">
                        <div class="favorites_img">
                            <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>">
                            <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) {
                                $avatarFolder = 'raw_thumb_user';
                            } else {
                                $avatarFolder = 'thumb_user';
                            }
                            ?>
                                <img src="<?php echo base_url();?>/uploads/<?php echo $avatarFolder;?>/<?php echo $user->avatar;?>" class="img-responsive">
                            </a>
                            <div class="gallery_number"><i class="i_img"></i> <span><?php echo countImages($user->id);?></span></div>
                            <?php if($isMobile == false){?>
                            <div class="favorites_footer">
                                <?php if(isFriend($user->id) == false){?><a href="javascript:void(0);" id="requestAddFriendBtn<?php echo $user->id;?>" class="btn btn_addFriend" onclick="callAjaxFunction(<?php echo $user->id;?>, 'requestAddFriendInFavorite')">Venneanmodning</a><?php }?>
                                <a href="javascript:void(0)"; onclick="callAjaxFunction(<?php echo $user->id;?>, 'removeFavoriteInPage')" class="btn btn_addFriend">Fjern favorit</a>
                            </div>
                            <?php }?>
                        </div>
                        <h5 class="name"><?php echo $user->name;?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h5>
                        <p class="nation"><?php echo $user->land;?></p>
                        <p class="old"><?php echo printAge($user->year);?> – <span class="area"><?php echo $user->region;?></span></p>
                        <p class="old">Tilføjet: d. <span><?php echo date("d/m/Y", $user->added_time); ?></span> kl. <span><?php echo date("H:i", $user->added_time); ?></p>
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
<script>
    $(document).ready(function() {
       $("#favoriteMenu").addClass('active');
    });
</script>