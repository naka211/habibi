<script src="<?php echo base_url().'templates/';?>js/landing.js"></script>
<?php if(!isGoldMember()){?>
<section class="banner_info">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mh">
                <div class="display_table">
                    <div class="table_content">
                        <h2><?php echo getContent(20, 'title');?></h2>
                        <?php echo getContent(20, 'content');?>
                        <a data-fancybox data-src="#modalUpgrade" href="javascript:;" class="btn btn_Upgrade">Opgrader nu</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mh">
                <div class="display_table">
                    <div class="table_content">
                        <img src="<?php echo base_url();?>/templates/images/1x/premium.png" alt="" class="img-responsive premium_img">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php }?>
<div id="content" class="content_profile">
    <div class="container">
        <section class="section_trySearch">
            <div class="row">
                <div class="w_box_trySearch clearfix">
                    <div class="box_trySearch">
                        <h2 class="title">Prøv en søgning</h2>
                        <p>Udfyld de faste søgekriterier og få altid opdaterede profiler her.</p>
                        <?php echo form_open('user/searching', array('method'=>'post', 'class'=>'frm_trySearch'))?>
                            <div class="form-group">
                                <label for="">Alder</label>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="fromAge" class="form-control" id="fromAge">
                                            <?php for($i=18; $i<=89; $i++){
                                                if($searchData['fromAge']){
                                                    $selected = $searchData['fromAge'] == $i?'selected':'';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                            <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="toAge" class="form-control" id="toAge">
                                            <?php for($i=19; $i<=90; $i++){
                                                if($searchData['toAge']){
                                                    $selected = $searchData['toAge'] == $i?'selected':'';
                                                } else {
                                                    $selected = $i==90?'selected':'';
                                                }
                                                ?>
                                                <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Land</label>
                                <select name="land[]" id="land" class="form-control 3col active regionSelection" multiple="multiple">
                                    <option value="Tyrkiet" <?php if(inSearch('land', 'Tyrkiet')) echo 'selected';?>>Tyrkiet</option>
                                    <option value="Syrien" <?php if(inSearch('land', 'Syrien')) echo 'selected';?>>Syrien</option>
                                    <option value="Irak" <?php if(inSearch('land', 'Irak')) echo 'selected';?>>Irak</option>
                                    <option value="Libanon" <?php if(inSearch('land', 'Libanon')) echo 'selected';?>>Libanon</option>
                                    <option value="Pakistan" <?php if(inSearch('land', 'Pakistan')) echo 'selected';?>>Pakistan</option>
                                    <option value="Palæstina" <?php if(inSearch('land', 'Palæstina')) echo 'selected';?>>Palæstina</option>
                                    <option value="Somalia" <?php if(inSearch('land', 'Somalia')) echo 'selected';?>>Somalia</option>
                                    <option value="Afghanistan" <?php if(inSearch('land', 'Afghanistan')) echo 'selected';?>>Afghanistan</option>
                                    <option value="Bosnien" <?php if(inSearch('land', 'Bosnien')) echo 'selected';?>>Bosnien</option>
                                    <option value="Iran" <?php if(inSearch('land', 'Iran')) echo 'selected';?>>Iran</option>
                                    <option value="Marokko" <?php if(inSearch('land', 'Marokko')) echo 'selected';?>>Marokko</option>
                                    <option value="Albanien" <?php if(inSearch('land', 'Albanien')) echo 'selected';?>>Albanien</option>
                                    <option value="Algeriet" <?php if(inSearch('land', 'Algeriet')) echo 'selected';?>>Algeriet</option>
                                    <option value="Egypten" <?php if(inSearch('land', 'Egypten')) echo 'selected';?>>Egypten</option>
                                    <option value="Makedionen" <?php if(inSearch('land', 'Makedionen')) echo 'selected';?>>Makedionen</option>
                                    <option value="Andet" <?php if(inSearch('land', 'Andet')) echo 'selected';?>>Andet</option>
                                </select>
                            </div>
                        <div class="form-group">
                            <label for="">Region</label>
                            <select name="region[]" id="region" class="form-control 3col active regionSelection" multiple="multiple">
                                <option value="København" <?php if(inSearch('region', 'København')) echo 'selected';?>>København</option>
                                <option value="Storkøbenhavn" <?php if(inSearch('region', 'Storkøbenhavn')) echo 'selected';?>>Storkøbenhavn</option>
                                <option value="Århus" <?php if(inSearch('region', 'Århus')) echo 'selected';?>>Århus</option>
                                <option value="Aalborg" <?php if(inSearch('region', 'Aalborg')) echo 'selected';?>>Aalborg</option>
                                <option value="Odense" <?php if(inSearch('region', 'Odense')) echo 'selected';?>>Odense</option>
                                <option value="Nordsjælland" <?php if(inSearch('region', 'Nordsjælland')) echo 'selected';?>>Nordsjælland</option>
                                <option value="Midt/Vestsjælland" <?php if(inSearch('region', 'Midt/Vestsjælland')) echo 'selected';?>>Midt/Vestsjælland</option>
                                <option value="Sydsjælland" <?php if(inSearch('region', 'Sydsjælland')) echo 'selected';?>>Sydsjælland</option>
                                <option value="Lolland/Falster" <?php if(inSearch('region', 'Lolland/Falster')) echo 'selected';?>>Lolland/Falster</option>
                                <option value="Fyn" <?php if(inSearch('region', 'Fyn')) echo 'selected';?>>Fyn</option>
                                <option value="Nordjylland" <?php if(inSearch('region', 'Nordjylland')) echo 'selected';?>>Nordjylland</option>
                                <option value="Østjylland" <?php if(inSearch('region', 'Østjylland')) echo 'selected';?>>Østjylland</option>
                                <option value="Vestjylland" <?php if(inSearch('region', 'Vestjylland')) echo 'selected';?>>Vestjylland</option>
                                <option value="Sydjylland" <?php if(inSearch('region', 'Sydjylland')) echo 'selected';?>>Sydjylland</option>
                                <option value="Midtjylland" <?php if(inSearch('region', 'Midtjylland')) echo 'selected';?>>Midtjylland</option>
                                <option value="Sønderjylland" <?php if(inSearch('region', 'Sønderjylland')) echo 'selected';?>>Sønderjylland</option>
                                <option value="Bornholm" <?php if(inSearch('region', 'Bornholm')) echo 'selected';?>>Bornholm</option>
                            </select>
                        </div>
                            <button type="submit" class="btn btn_searchResult">Se hele søgeresultatet</button>
                        <?php echo form_close();?>
                    </div>
                </div>

                <div class="w_owl_trySearch">
                    <h2 class="title">Prøv en søgning</h2>
                    <div class="owl-carousel owl-theme owl_trySearch">
                        <?php foreach ($randomUsers as $user){?>
                        <div class="item">
                            <div class="box_user">
                                <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                    <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                <?php } else {?>
                                    <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                <?php }?>
                                <h5 class="name"><?php echo $user->name;?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h5>
                                <p class="nation"><?php echo $user->land;?></p>
                                <p class="old"><?php echo printAge($user->year);?> - <span class="area"><?php echo $user->region;?></span></p>
                            </div>
                        </div>
                        <?php }?>

                    </div>
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
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php }?>
                                    <h5 class="name"><?php echo $user->name;?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h5>
                                    <p class="nation"><?php echo $user->land;?></p>
                                    <p class="old"><?php echo printAge($user->year);?> - <span class="area"><?php echo $user->region;?></span></p>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
        </section>

        <section class="section_mostvisitedProfiles" style="border-bottom: none;">
            <div class="row">
                <h2 class="title">Populær profiler</h2>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="owl-carousel owl-theme owl_mostvisitedProfiles">
                        <?php foreach ($popularUsers as $user){?>
                            <div class="item">
                                <div class="box_user">
                                    <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive"></a>
                                    <?php }?>
                                    <h5 class="name"><?php echo $user->name;?> <?php if($user->login == 1){?><span class="status"></span><?php }?></h5>
                                    <p class="nation"><?php echo $user->land;?></p>
                                    <p class="old"><?php echo printAge($user->year);?> - <span class="area"><?php echo $user->region;?></span></p>
                                </div>
                            </div>
                        <?php }?>

                    </div>
                </div>
            </div>
        </section>

    </div>
</div>