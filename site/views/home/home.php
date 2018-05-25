<script src="<?php echo base_url().'templates/';?>js/functions.js"></script>
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
                        <form class="frm_trySearch" action="" method="POST" role="form">
                            <div class="form-group">
                                <label for="">Alder</label>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="" class="form-control">
                                            <option value="">18</option>
                                            <option value="">19</option>
                                            <option value="">20</option>
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="" class="form-control">
                                            <option value="">50</option>
                                            <option value="">51</option>
                                            <option value="">52</option>
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="">Region</label>
                                <select name="" class="form-control">
                                    <option value="">Fyn</option>
                                    <option value="">Fyn</option>
                                    <option value="">Fyn</option>
                                    <option value="">...</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Etnisk oprindelse</label>
                                <select name="" class="form-control">
                                    <option value="">Indvandrere</option>
                                    <option value="">Indvandrere</option>
                                    <option value="">Indvandrere</option>
                                    <option value="">...</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn_searchResult">Se hele søgeresultatet</button>
                        </form>
                    </div>
                </div>

                <div class="w_owl_trySearch">
                    <h2 class="title">Prøv en søgning</h2>
                    <div class="owl-carousel owl-theme owl_trySearch">
                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user01.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user02.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="section_latestProfiles">
            <div class="row">
                <h2 class="title">Nyeste profiler</h2>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="owl-carousel owl-theme owl_latestProfiles">
                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user01.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user02.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                    </div>
                </div>
        </section>

        <section class="section_mostvisitedProfiles" style="border-bottom: none;">
            <div class="row">
                <h2 class="title">Nyeste profiler</h2>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="owl-carousel owl-theme owl_mostvisitedProfiles">
                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user01.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user02.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="box_user">
                                <a href="profile_detail.php" title=""><img src="<?php echo base_url();?>/templates/images/1x/user03.jpg" alt="" class="img-responsive"></a>
                                <h5 class="name">Abu Dhabi Tutoring</h5>
                                <p class="nation">Tyrkisk</p>
                                <p class="old">20 år – <span class="area">Syddanmark</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
</div>