<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead bor_none" style="margin-bottom: 0px;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo form_open('user/searching', array('method'=>'get', 'class'=>'frm_search'))?>
                            <h3><?php echo $num;?> profiler fundet</h3>
                            <p>Faste kriterier</p>

                            <div class="row_search clearfix">
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
                                        <?php for($i=18; $i<=70; $i++){?>
                                            <option value="<?php echo $i;?>" <?php if($this->input->get('fromAge') == $i) echo 'selected';?>><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
                                    <span class="i_line">−</span>
                                    <select name="toAge" class="form-control option_age" id="toAge">
                                        <?php for($i=18; $i<=70; $i++){?>
                                            <option value="<?php echo $i;?>" <?php if($this->input->get('toAge') == $i) echo 'selected';?>><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="box_form_group">
                                    <p for="">Sortering:</p>
                                    <select name="order" class="form-control" id="order">
                                        <option value="newest" <?php if($this->input->get('order') == 'newest') echo 'selected';?> >Nyeste</option>
                                        <option value="popular" <?php if($this->input->get('order') == 'popular') echo 'selected';?>>Populær</option>
                                    </select>
                                </div>
                            </div>
                            <p>Valgfrie kriterier</p>
                            <div class="row" id="filter"></div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <a href="#" class="btn btn_addCriteria"><span>Tilføj kriterie:</span> <i class="i_plus_xs"></i></a>
                                    <button type="button" class="btn btn_searchResult" style="width: auto;">Se hele søgeresultatet</button>
                                </div>
                            </div>

                        <?php echo form_close();?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3>Fremhævet profil</h3>
                </div>

                <?php foreach($list as $user){?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6">
                        <div class="box_favorites_item">
                            <div class="favorites_img">
                                <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/user/<?php echo $user->avatar;?>" alt="" class="img-responsive"></a>
                                <div class="gallery_number"><i class="i_img"></i> <span><?php echo countImages($user->id);?></span></div>
                                <?php if(isFriend($user->id) == false){?>
                                <div class="favorites_footer">
                                    <a href="<?php echo site_url('user/requestAddFriend/'.$user->id);?>" class="btn btn_addFriend">Tilføj ven</a>
                                </div>
                                <?php }?>
                            </div>
                            <h5 class="name"><?php echo $user->name;?></h5>
                            <p class="nation"><?php echo $user->ethnic_origin;?></p>
                            <p class="old"><?php echo printAge($user->year);?> – <span class="area"><?php echo $user->region;?></span></p>
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
        $("#searchMenu").addClass('active');

        $(function() {
            $(".btn_searchResult").click(function() {
                var params = {};
                var getSelect = ['fromAge', 'toAge', 'region'];

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
                    var url = [location.protocol, '//', location.host, location.pathname].join('');
                    window.location.href = url + '?' + $.param(params);
                }
            });
        });

        $('.regionSelection').multiselect({
            columns: 2,
            texts:{
                'selectAll': 'Vælg alle',
                'unselectAll': 'Fravælg alle',
                'selectedOptions': ' valgt region'
            },
            selectAll: true,
            maxPlaceholderOpts: 1
        });
    });
</script>