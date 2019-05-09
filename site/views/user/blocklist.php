<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Blokerede</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if(!empty($list)) { ?>
                    <?php foreach ($list as $user) { ?>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6 profile<?php echo $user->id;?>">
                            <div class="box_favorites_item">
                                <div class="favorites_img">
                                    <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img
                                                src="<?php echo base_url(); ?>/uploads/thumb_user/<?php echo $user->avatar; ?>"
                                                alt="" class="img-responsive"></a>
                                    <?php if($isMobile == false){?>
                                    <div class="gallery_number">
                                        <i class="i_img"></i>
                                        <span><?php echo countImages($user->id); ?></span>
                                    </div>
                                    <?php }?>
                                    <div class="favorites_footer">
                                        <a href="javascript:void(0)" ;
                                           onclick="callAjaxFunction(<?php echo $user->id; ?>, 'unblockUser')"
                                           class="btn btn_addFriend">Slet blokeringen</a>
                                    </div>
                                </div>
                                <h5 class="name"><?php echo $user->name; ?></h5>
                                <p class="nation"><?php echo $user->ethnic_origin; ?></p>
                                <p class="old"><?php echo printAge($user->year); ?> – <span class="area"><?php echo $user->region; ?></span></p>
                            </div>
                        </div>
                    <?php }
                } else {?>
                    Ingen blokeret
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