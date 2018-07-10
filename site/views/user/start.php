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
                        <?php echo form_open('user/searching', array('method'=>'get', 'class'=>'frm_trySearch'))?>
                            <div class="form-group">
                                <label for="">Alder</label>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="fromAge" class="form-control" id="fromAge">
                                            <?php for($i=18; $i<=70; $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <select name="toAge" class="form-control" id="toAge">
                                            <?php for($i=19; $i<=90; $i++){?>
                                                <option value="<?php echo $i;?>" <?php echo $i==90?'selected':'';?> ><?php echo $i;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="">Land</label>
                                <select name="land[]" id="land" class="form-control 3col active regionSelection" multiple="multiple">
                                    <option value="Tyrkiet">Tyrkiet</option>
                                    <option value="Syrien">Syrien</option>
                                    <option value="Irak">Irak</option>
                                    <option value="Libanon">Libanon</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palæstina">Palæstina</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Bosnien">Bosnien</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Marokko">Marokko</option>
                                    <option value="Albanien">Albanien</option>
                                    <option value="Algeriet">Algeriet</option>
                                    <option value="Egypten">Egypten</option>
                                    <option value="Makedionen">Makedionen</option>
                                    <option value="Andet">Andet</option>
                                </select>
                            </div>
                        <div class="form-group">
                            <label for="">Region</label>
                            <select name="region[]" id="region" class="form-control 3col active regionSelection" multiple="multiple">
                                <option value="København">København</option>
                                <option value="Storkøbenhavn">Storkøbenhavn</option>
                                <option value="Århus">Århus</option>
                                <option value="Aalborg">Aalborg</option>
                                <option value="Odense">Odense</option>
                                <option value="Nordsjælland">Nordsjælland</option>
                                <option value="Midt/Vestsjælland">Midt/Vestsjælland</option>
                                <option value="Sydsjælland">Sydsjælland</option>
                                <option value="Lolland/Falster">Lolland/Falster</option>
                                <option value="Fyn">Fyn</option>
                                <option value="Nordjylland">Nordjylland</option>
                                <option value="Østjylland">Østjylland</option>
                                <option value="Vestjylland">Vestjylland</option>
                                <option value="Sydjylland">Sydjylland</option>
                                <option value="Midtjylland">Midtjylland</option>
                                <option value="Sønderjylland">Sønderjylland</option>
                                <option value="Bornholm">Bornholm</option>
                            </select>
                        </div>
                            <button type="button" class="btn btn_searchResult">Se hele søgeresultatet</button>
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
                                <h5 class="name"><?php echo $user->name;?></h5>
                                <p class="nation"><?php echo $user->ethnic_origin;?></p>
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
                                    <h5 class="name"><?php echo $user->name;?></h5>
                                    <p class="nation"><?php echo $user->ethnic_origin;?></p>
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
                                    <h5 class="name"><?php echo $user->name;?></h5>
                                    <p class="nation"><?php echo $user->ethnic_origin;?></p>
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
<script>
    $(function() {
        $(".btn_searchResult").click(function() {
            var params = {};
            var getSelect = ['fromAge', 'toAge', 'land', 'region'];

            $.each(getSelect, function(index, value) {
                var select = $('#' + value);
                if (select.val() != '') {
                    var selected = select.val();
                    if (select.attr('multiple'))
                        selected = selected.join(',');
                    params[value] = selected;
                }
            });
            if (!$.isEmptyObject(params)) {
                var url = ['<?php echo base_url();?>', 'user/searching'].join('');
                window.location.href = url + '?' + $.param(params);
            }
        });
    });
</script>