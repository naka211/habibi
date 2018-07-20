<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead bor_none" style="margin-bottom: 0px;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo form_open('user/searching', array('method'=>'get', 'class'=>'frm_search'))?>
                            <h3>Søgeresultat</h3>
                            <p>Faste kriterier</p>

                            <div class="row_search clearfix">
                                <div class="box_form_group">
                                    <p for="">Land:</p>
                                    <select class="form-control 3col active regionSelection" name="land[]" id="land" multiple="multiple">
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
                                <div class="box_form_group">
                                    <p for="">Region:</p>
                                    <select class="form-control 3col active regionSelection" name="region[]" id="region" multiple="multiple">
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
                                <div class="box_form_group box_form_group_age">
                                    <p for="">Alder:</p>
                                    <select name="fromAge" class="form-control" id="fromAge">
                                        <?php for($i=18; $i<=90; $i++){
                                            if($searchData['fromAge']){
                                                $selected = $searchData['fromAge'] == $i?'selected':'';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
                                    <span class="i_line">−</span>
                                    <select name="toAge" class="form-control option_age" id="toAge">
                                        <?php for($i=18; $i<=90; $i++){
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
                                <div class="box_form_group">
                                    <p for="">Sortering:</p>
                                    <select name="order" class="form-control" id="order">
                                        <option value="newest" <?php if($searchData['order'] == 'newest') echo 'selected';?> >Nyeste</option>
                                        <option value="popular" <?php if($searchData['order'] == 'popular') echo 'selected';?>>Populær</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn_searchResult" style="width: auto; padding-top: 5px; padding-bottom: 5px;" id="seeMoreCriteria">Valgfrie kriterier</button>
                            <div class="row_search clearfix" id="filter">
                                <div class="box_wrap">
                                    <div class="box_form_group">
                                        <p for="">Køn</p>
                                        <select class="form-control 3col active regionSelection" name="gender[]" id="gender" multiple="multiple">
                                            <option value="1" <?php if(inSearch('gender', 1)) echo 'selected';?>>Mand</option>
                                            <option value="2" <?php if(inSearch('gender', 2)) echo 'selected';?>>Kvinde</option>
                                        </select>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Forhold</p>
                                        <select class="form-control 3col active regionSelection" name="relationship[]" id="relationship" multiple="multiple">
                                            <option value="Aldrig gift" <?php if(inSearch('relationship', 'Aldrig gift')) echo 'selected';?>>Aldrig gift</option>
                                            <option value="Separeret" <?php if(inSearch('relationship', 'Separeret')) echo 'selected';?>>Separeret</option>
                                            <option value="Skilt" <?php if(inSearch('relationship', 'Skilt')) echo 'selected';?>>Skilt</option>
                                            <option value="Enke/enkemand" <?php if(inSearch('relationship', 'Enke/enkemand')) echo 'selected';?>>Enke/enkemand</option>
                                            <option value="Det får du at vide senere" <?php if(inSearch('relationship', 'Det får du at vide senere')) echo 'selected';?>>Det får du at vide senere</option>
                                        </select>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Børn</p>
                                        <select class="form-control 3col active regionSelection" name="children[]" id="children" multiple="multiple">
                                            <option value="Nej" <?php if(inSearch('children', 'Nej')) echo 'selected';?>>Nej</option>
                                            <option value="Ja, hjemmeboende" <?php if(inSearch('children', 'Ja, hjemmeboende')) echo 'selected';?>>Ja, hjemmeboende</option>
                                            <option value="Ja, udeboende" <?php if(inSearch('children', 'Ja, udeboende')) echo 'selected';?>>Ja, udeboende</option>
                                            <option value="1" <?php if(inSearch('children', '1')) echo 'selected';?>>1</option>
                                            <option value="2" <?php if(inSearch('children', '2')) echo 'selected';?>>2</option>
                                            <option value="3" <?php if(inSearch('children', '3')) echo 'selected';?>>3</option>
                                            <option value="3+" <?php if(inSearch('children', '3+')) echo 'selected';?>>3+</option>
                                        </select>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Ryger</p>
                                        <select class="form-control 3col active regionSelection" name="smoking[]" id="smoking" multiple="multiple">
                                            <option value="Ja" <?php if(inSearch('smoking', 'Ja')) echo 'selected';?>>Ja</option>
                                            <option value="Nej" <?php if(inSearch('smoking', 'Nej')) echo 'selected';?>>Nej</option>
                                            <option value="Ja, festryger" <?php if(inSearch('smoking', 'Ja, festryger')) echo 'selected';?>>Ja, festryger</option>
                                        </select>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Religion</p>
                                        <select class="form-control 3col active regionSelection" name="religion[]" id="religion" multiple="multiple">
                                            <option value="Suni" <?php if(inSearch('religion', 'Suni')) echo 'selected';?>>Suni</option>
                                            <option value="Shia" <?php if(inSearch('religion', 'Shia')) echo 'selected';?>>Shia</option>
                                            <option value="Andet" <?php if(inSearch('religion', 'Andet')) echo 'selected';?>>Andet</option>
                                        </select>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Uddannelse</p>
                                        <select class="form-control 3col active regionSelection" name="training[]" id="training" multiple="multiple">
                                            <option value="Ingen eksamen" <?php if(inSearch('training', 'Ingen eksamen')) echo 'selected';?>>Ingen eksamen</option>
                                            <option value="Gymnasium/HF" <?php if(inSearch('training', 'Gymnasium/HF')) echo 'selected';?>>Gymnasium/HF</option>
                                            <option value="Fagskole" <?php if(inSearch('training', 'Fagskole')) echo 'selected';?>>Fagskole</option>
                                            <option value="Bachelorgrad" <?php if(inSearch('training', 'Bachelorgrad')) echo 'selected';?>>Bachelorgrad</option>
                                            <option value="Kandidat/ph.d." <?php if(inSearch('training', 'Kandidat/ph.d.')) echo 'selected';?>>Kandidat/ph.d.</option>
                                        </select>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Kropsbygning</p>
                                        <select class="form-control 3col active regionSelection" name="body[]" id="body" multiple="multiple">
                                            <option value="Slank" <?php if(inSearch('body', 'Slank')) echo 'selected';?>>Slank</option>
                                            <option value="Atletisk" <?php if(inSearch('body', 'Atletisk')) echo 'selected';?>>Atletisk</option>
                                            <option value="Gennemsnitlig" <?php if(inSearch('body', 'Gennemsnitlig')) echo 'selected';?>>Gennemsnitlig</option>
                                            <option value="Buttet" <?php if(inSearch('body', 'Buttet')) echo 'selected';?>>Buttet</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn_searchResult" id="viewResult" style="width: auto;">0 profiler fundet</button>
                                </div>
                            </div>

                        <?php echo form_close();?>
                    </div>
                </div>
            </div>

            <!--<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3>Fremhævet profil</h3>
                </div>

                <?php /*foreach($list as $user){*/?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6">
                        <div class="box_favorites_item">
                            <div class="favorites_img">
                                <a href="<?php /*echo site_url('user/profile/'.$user->id.'/'.$user->name);*/?>"><img src="<?php /*echo base_url();*/?>/uploads/thumb_user/<?php /*echo $user->avatar;*/?>" alt="" class="img-responsive"></a>
                                <div class="gallery_number"><i class="i_img"></i> <span><?php /*echo countImages($user->id);*/?></span></div>
                                <?php /*if(isFriend($user->id) == false){*/?>
                                <div class="favorites_footer">
                                    <a href="<?php /*echo site_url('user/requestAddFriend/'.$user->id);*/?>" class="btn btn_addFriend">Tilføj ven</a>
                                </div>
                                <?php /*}*/?>
                            </div>
                            <h5 class="name"><?php /*echo $user->name;*/?></h5>
                            <p class="nation"><?php /*echo $user->ethnic_origin;*/?></p>
                            <p class="old"><?php /*echo printAge($user->year);*/?> – <span class="area"><?php /*echo $user->region;*/?></span></p>
                        </div>
                    </div>
                <?php /*}*/?>
            </div>-->


        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("#searchMenu").addClass('active');
        $("#seeMoreCriteria").click(function(){
            $(".box_wrap").toggle(500);
        });

        $('.regionSelection').multiselect({
            columns: 2,
            texts:{
                'selectAll': 'Vælg alle',
                'unselectAll': 'Fravælg alle',
                'selectedOptions': ' valgt'
            },
            selectAll: true,
            maxPlaceholderOpts: 1
        });

        $(".frm_search select").change( function(){
            var searchKey = $(this).attr('id');
            var searchValue = $(this).val();
            $.ajax({
                method: "POST",
                url: base_url+"ajax/updateSearchDataAndCountResult",
                data: { searchKey: searchKey, searchValue: searchValue, csrf_site_name: token_value },
                success: function (html) {
                    $('#viewResult').text(html);
                }
            });
        })
    });
</script>