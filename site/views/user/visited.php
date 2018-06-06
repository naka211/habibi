<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-tabs" style="margin-bottom: 0; border: none;">
                            <li><a href="<?php echo site_url('user/visitme');?>">Modtagne</a></li>
                            <li class="active"><a href="javascript:void();">Sendte</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php if(!empty($list)){
                foreach($list as $user){
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                    <div class="frend_item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="frend_item_avatar">
                                    <a href="<?php echo site_url('user/profile/' . $user->id . '/' . $user->name); ?>"><img src="<?php echo base_url(); ?>/uploads/user/<?php echo $user->avatar; ?>" alt="" class="img-responsive"></a>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                <h4><?php echo $user->name; ?></h4>
                                <p class="age_city"><?php echo printAge($user->year); ?> – <?php echo $user->region; ?></p>
                                <p>Modtaget: d. <?php echo date("d/m/Y", $user->seen_time); ?></p>
                                <?php if(isFriend($user->id) == false){?><a href="<?php echo site_url('user/requestAddFriend/'.$user->id);?>" class="btn bntMessage">Tilføj ven</a><?php }?>
                                <a href="<?php echo site_url('user/blockUser/' . $user->id); ?>" class="btn bntBlock">Blok</a>
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
<script>
    $(document).ready(function() {
        $("#visitMenu").addClass('active');
    });
</script>