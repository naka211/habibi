<script src="<?php echo base_url().'templates/';?>js/landing.js"></script>
<?php if(!isGoldMember()){?>
<section class="banner_info">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mh">
                <div class="display_table">
                    <div class="table_content">
                        <h2><?php echo getContent(20, 'title');?></h2>
                        <p>Ved guldmedlemskab:</p>
                        <?php echo getContent(20, 'content');?>
                        <a href="<?php echo site_url('user/upgrade');?>" class="btn btn_Upgrade">Opgrader nu</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mh">
                <div class="box_label_member">
                    <img src="<?php echo base_url();?>templates/images/1x/premium.png" alt="" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
</section>
<?php }?>
<div id="content" class="content_profile">
    <div class="container">
        <!--<section class="section_trySearch">
            <div class="row">
                <div class="w_box_trySearch clearfix">
                    <div class="box_trySearch">
                        <h2 class="title">Søg</h2>
                        <p>Udfyld de faste søgekriterier og få altid opdaterede profiler her.</p>
                        <?php /*echo form_open('user/searching', array('method'=>'post', 'class'=>'frm_trySearch'))*/?>
                            <div class="form-group">
                                <label for="">Alder</label>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="fromAge" class="form-control" id="fromAge">
                                            <?php /*for($i=18; $i<=89; $i++){
                                                if($searchData['fromAge']){
                                                    $selected = $searchData['fromAge'] == $i?'selected':'';
                                                } else {
                                                    $selected = '';
                                                }
                                                */?>
                                            <option value="<?php /*echo $i;*/?>" <?php /*echo $selected;*/?>><?php /*echo $i;*/?></option>
                                            <?php /*}*/?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="toAge" class="form-control" id="toAge">
                                            <?php /*for($i=19; $i<=90; $i++){
                                                if($searchData['toAge']){
                                                    $selected = $searchData['toAge'] == $i?'selected':'';
                                                } else {
                                                    $selected = $i==90?'selected':'';
                                                }
                                                */?>
                                                <option value="<?php /*echo $i;*/?>" <?php /*echo $selected;*/?>><?php /*echo $i;*/?></option>
                                            <?php /*}*/?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Land</label>
                                <?php /*echo generateSelectInSearch('land');*/?>
                            </div>
                            <div class="form-group">
                                <label for="">Region</label>
                                <?php /*echo generateSelectInSearch('region');*/?>
                            </div>
                            <button type="submit" class="btn btn_searchResult">Se hele søgeresultatet</button>
                        <?php /*echo form_close();*/?>
                    </div>
                </div>

                <div class="w_owl_trySearch">
                    <h2 class="title">Udvalgte profiler</h2>
                    <div class="owl-carousel owl-theme owl_trySearch">
                        <?php /*foreach ($randomUsers as $user){*/?>
                        <div class="item">
                            <div class="box_user">
                                <?php /*if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { */?>
                                    <a href="<?php /*echo site_url('user/profile/'.$user->id.'/'.$user->name);*/?>"><img src="<?php /*echo base_url();*/?>uploads/raw_thumb_user/<?php /*echo $user->avatar;*/?>" class="img-responsive"></a>
                                <?php /*} else {*/?>
                                    <a href="<?php /*echo site_url('user/profile/'.$user->id.'/'.$user->name);*/?>"><img src="<?php /*echo base_url();*/?>uploads/thumb_user/<?php /*echo $user->avatar;*/?>" class="img-responsive"></a>
                                <?php /*}*/?>
                                <h5 class="name"><?php /*echo $user->name;*/?> <?php /*if($user->login == 1){*/?><span class="status"></span><?php /*}*/?></h5>
                                <p class="nation"><?php /*echo $user->land;*/?></p>
                                <p class="old"><?php /*echo printAge($user->id);*/?> - <span class="area"><?php /*echo $user->region;*/?></span></p>
                            </div>
                        </div>
                        <?php /*}*/?>

                    </div>
                </div>
            </div>
        </section>-->

        <section class="section_randomProfiles" style="margin-top: 50px;">
            <div class="row">
                <h2 class="title">Udvalgte profiler</h2>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="owl-carousel owl-theme owl_latestProfiles">
                        <?php foreach ($randomUsers as $user){?>
                            <div class="item">
                                <div class="box_user">
                                    <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php }?>
                                    <h5 class="name"><?php echo $user->name;?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h5>
                                    <p class="nation"><?php echo $user->land;?></p>
                                    <p class="old"><?php echo printAge($user->id);?> - <span class="area"><?php echo $user->region;?></span></p>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
        </section>

        <section class="section_latestProfiles">
            <div class="row">
                <h2 class="title">Nyeste profiler</h2>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="owl-carousel owl-theme owl_latestProfiles">
                        <?php foreach ($newestUsers as $user){?>
                            <div class="item">
                                <div class="box_user">
                                    <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php }?>
                                    <h5 class="name"><?php echo $user->name;?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h5>
                                    <p class="nation"><?php echo $user->land;?></p>
                                    <p class="old"><?php echo printAge($user->id);?> - <span class="area"><?php echo $user->region;?></span></p>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
        </section>

        <section class="section_mostvisitedProfiles" style="border-bottom: none;">
            <div class="row">
                <h2 class="title">Populære profiler</h2>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="owl-carousel owl-theme owl_mostvisitedProfiles">
                        <?php foreach ($popularUsers as $user){?>
                            <div class="item">
                                <div class="box_user">
                                    <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php }?>
                                    <h5 class="name"><?php echo $user->name;?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h5>
                                    <p class="nation"><?php echo $user->land;?></p>
                                    <p class="old"><?php echo printAge($user->id);?> - <span class="area"><?php echo $user->region;?></span></p>
                                </div>
                            </div>
                        <?php }?>

                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<!--Login user to cometchat-->
<script>
    $(document).ready(function() {
        var appID = "<?php echo $this->config->item('comet_app_id');?>";
        var region = "eu";
        var appSetting = new CometChat.AppSettingsBuilder().subscribePresenceForAllUsers().setRegion(region).build();
        CometChat.init(appID, appSetting);
        CometChat.login('<?php echo $userLoggedIn->cometAuthToken;?>').then(
            function(User){
                console.log("Login successfully:", { User });
                // User loged in successfully.
            },
            function(error){
                console.log("Login failed with exception:", { error });
                // User login failed, check error and take appropriate action.
            }
        );
    });
</script>
