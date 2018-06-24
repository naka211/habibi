<?php
$filterArr = array('gender'=>'Køn', 'relationship'=>'Forhold', 'children'=>'Børn', 'ethnic'=>'Etnisk oprindelse', 'religion'=>'Religion', 'training'=>'Uddannelse', 'body'=>'Kropsbygning', 'smoking'=>'Ryger');
?>
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
                                    <p for="">Land:</p>
                                    <select class="form-control 3col active regionSelection" name="region[]" id="region" multiple="multiple">
                                        <option value="Tyrkiet" <?php if(inSearch('region', 'Tyrkiet')) echo 'selected';?>>Tyrkiet</option>
                                        <option value="Syrien" <?php if(inSearch('region', 'Syrien')) echo 'selected';?>>Syrien</option>
                                        <option value="Irak" <?php if(inSearch('region', 'Irak')) echo 'selected';?>>Irak</option>
                                        <option value="Libanon" <?php if(inSearch('region', 'Libanon')) echo 'selected';?>>Libanon</option>
                                        <option value="Pakistan" <?php if(inSearch('region', 'Pakistan')) echo 'selected';?>>Pakistan</option>
                                        <option value="Palæstina" <?php if(inSearch('region', 'Palæstina')) echo 'selected';?>>Palæstina</option>
                                        <option value="Somalia" <?php if(inSearch('region', 'Somalia')) echo 'selected';?>>Somalia</option>
                                        <option value="Afghanistan" <?php if(inSearch('region', 'Afghanistan')) echo 'selected';?>>Afghanistan</option>
                                        <option value="Bosnien" <?php if(inSearch('region', 'Bosnien')) echo 'selected';?>>Bosnien</option>
                                        <option value="Iran" <?php if(inSearch('region', 'Iran')) echo 'selected';?>>Iran</option>
                                        <option value="Marokko" <?php if(inSearch('region', 'Marokko')) echo 'selected';?>>Marokko</option>
                                        <option value="Albanien" <?php if(inSearch('region', 'Albanien')) echo 'selected';?>>Albanien</option>
                                        <option value="Algeriet" <?php if(inSearch('region', 'Algeriet')) echo 'selected';?>>Algeriet</option>
                                        <option value="Egypten" <?php if(inSearch('region', 'Egypten')) echo 'selected';?>>Egypten</option>
                                        <option value="Makedionen" <?php if(inSearch('region', 'Makedionen')) echo 'selected';?>>Makedionen</option>
                                        <option value="Andet" <?php if(inSearch('region', 'Andet')) echo 'selected';?>>Andet</option>
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
                            <div class="row_search clearfix" id="filter"></div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="box_form_group" style="background-color: #ffa507;">
                                        <p for="">Tilføj kriterie:</p>
                                        <select name="criteria" class="form-control" id="criteria">
                                            <option value="">Vælg</option>
                                            <?php
                                            foreach ($filterArr as $filter=>$label){
                                            ?>
                                            <option id="<?php echo $filter;?>Option" value="<?php echo $filter;?>" <?php if(!empty($this->input->get($filter))) echo 'style="display:none;"';?>><?php echo $label;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
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
                                <a href="<?php echo site_url('user/profile/'.$user->id.'/'.$user->name);?>"><img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>" alt="" class="img-responsive"></a>
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
                var getSelect = ['fromAge', 'toAge', 'region', 'gender', 'relationship', 'children', 'ethnic', 'religion', 'training', 'body', 'smoking', 'order'];

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

            $("#criteria").change(function () {
                var type = this.value;
                var label = $(this).find("option:selected").text();
                loadMultiFilter(type, label, '');
            })
        });

        loadMultiFilter = function (type, label, selectedStr) {
            $.ajax({
                method: "POST",
                url: base_url+"ajax/loadMultiFilter",
                data: { csrf_site_name: token_value, type: type, label: label, selectedStr: selectedStr},
                success: function (html) {
                    //adding a filter
                    $("#filter").append(html);
                    //hide an option and move to top
                    $("#"+type+"Option").hide();
                    $("#criteria").val($("#criteria option:first").val());
                    //create multiselect style
                    $('.'+type+'Selection').multiselect({
                        columns: 2,
                        texts:{
                            'selectAll': 'Vælg alle',
                            'unselectAll': 'Fravælg alle',
                            'selectedOptions': ' valgt'
                        },
                        selectAll: true,
                        maxPlaceholderOpts: 1
                    });
                }
            });
        }

        closeFilter = function(type){
            $("#"+type+"Filter").remove();
            $("#"+type+"Option").show();
        }
        <?php
        foreach ($filterArr as $filter=>$label){
            if(!empty($this->input->get($filter))){
        ?>
        loadMultiFilter('<?php echo $filter?>', '<?php echo $label?>', '<?php echo $this->input->get($filter);?>');
        <?php
            }
        }
        ?>


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