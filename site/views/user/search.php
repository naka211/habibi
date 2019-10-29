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
                                    <?php echo generateSelectInSearch('land');?>
                                </div>
                                <div class="box_form_group">
                                    <p for="">Region:</p>
                                    <?php echo generateSelectInSearch('region');?>
                                </div>
                                <div class="box_form_group box_form_group_age">
                                    <p for="">Alder:</p>
                                    <?php echo generateOptionsInRangeHTML('fromAge', 18, 90, $searchData['fromAge'], 'år');?>
                                    <span class="i_line">−</span>
                                    <?php echo generateOptionsInRangeHTML('toAge', 18, 90, $searchData['toAge'], 'år');?>
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
                                <div class="box_wrap" style="display: none;">
                                    <div class="box_form_group box_form_group_age">
                                        <p for="">Højde:</p>
                                        <?php echo generateOptionsInRangeHTML('fromHeight', 100, 230, !empty($searchData['fromHeight'])?$searchData['fromHeight']:'', 'cm');?>
                                        <span class="i_line">−</span>
                                        <?php echo generateOptionsInRangeHTML('toHeight', 100, 230, !empty($searchData['toHeight'])?$searchData['toHeight']:'', 'cm');?>
                                    </div>
                                    <div class="box_form_group box_form_group_age">
                                        <p for="">Vægt:</p>
                                        <?php echo generateOptionsInRangeHTML('fromWeight', 40, 220, !empty($searchData['fromWeight'])?$searchData['fromWeight']:'', 'kg');?>
                                        <span class="i_line">−</span>
                                        <?php echo generateOptionsInRangeHTML('toWeight', 40, 220, !empty($searchData['toWeight'])?$searchData['toWeight']:'', 'kg');?>
                                    </div>
                                    <!--<div class="box_form_group">
                                        <p for="">Køn</p>
                                        <select class="form-control 3col active regionSelection" name="gender[]" id="gender" multiple="multiple">
                                            <option value="1" <?php /*if(inSearch('gender', 1)) echo 'selected';*/?>>Mand</option>
                                            <option value="2" <?php /*if(inSearch('gender', 2)) echo 'selected';*/?>>Kvinde</option>
                                        </select>
                                    </div>-->
                                    <div class="box_form_group">
                                        <p for="">Forhold</p>
                                        <?php echo generateSelectInSearch('relationship');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Børn</p>
                                        <?php echo generateSelectInSearch('children');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Rygning</p>
                                        <?php echo generateSelectInSearch('smoking');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Religion</p>
                                        <?php echo generateSelectInSearch('religion');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Uddannelse</p>
                                        <?php echo generateSelectInSearch('training');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Kropsbygning</p>
                                        <?php echo generateSelectInSearch('body');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Branche</p>
                                        <?php echo generateSelectInSearch('business');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Job type</p>
                                        <?php echo generateSelectInSearch('job_type');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Hårfarve</p>
                                        <?php echo generateSelectInSearch('hair_color');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Øjenfarve</p>
                                        <?php echo generateSelectInSearch('eye_color');?>
                                    </div>
                                    <div class="box_form_group">
                                        <p for="">Stjernetegn</p>
                                        <?php echo generateSelectInSearch('zodiac');?>
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

            <div class="row">
                <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3>Fremhævet profil</h3>
                </div>-->
                <div id="profileList" style="margin-top: 20px;"></div>
                <div class="text-center clearfix" style="display: none;" id="loadMore"><img src="<?php echo base_url();?>templates/images/preloader.gif" width="100" /></div>
                <input type="hidden" value="0" id="offset">
                <input type="hidden" value="" id="num">
            </div>


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
            selectAll: false,
            maxPlaceholderOpts: 1
        });

        //Count number of profile
        $.ajax({
            method: "POST",
            url: base_url+"ajax/countProfiles",
            data: {csrf_site_name: token_value },
            success: function (num) {
                if(parseInt(num) > 1){
                    var txt = num+' profiler fundet';
                } else {
                    var txt = num+' profil fundet';
                }
                $('#viewResult').text(txt);
                $('#num').val(num);
            }
        });

        $(".frm_search select").change( function(){
            var searchKey = $(this).attr('id');
            var searchValue = $(this).val();
            $.ajax({
                method: "POST",
                url: base_url+"ajax/updateSearchDataAndCountResult",
                data: { searchKey: searchKey, searchValue: searchValue, csrf_site_name: token_value },
                success: function (num) {
                    if(parseInt(num) > 1){
                        var txt = num+' profiler fundet';
                    } else {
                        var txt = num+' profil fundet';
                    }
                    $('#viewResult').text(txt);
                    $('#num').val(num);
                }
            });
        });

        loadSearchResult = function(offset){
            $.ajax({
                method: "POST",
                url: base_url+"ajax/loadSearchResult",
                data: {offset: offset, csrf_site_name: token_value },
                beforeSend: function(){
                    $('#loadMore').show();
                },
                complete: function(){
                    $('#loadMore').hide();
                },
                success: function (html) {
                    $('#profileList').append(html);
                    $('#offset').val(parseInt(offset)+12);
                    $("a").bind("click", function() {
                        validNavigation = true;
                    });
                }
            });
        }

        $('#viewResult').click(function () {
            $('#profileList').html('');
            $('#offset').val(0);
            var offset = $('#offset').val();
            loadSearchResult(offset);
        });
        $( "#viewResult" ).trigger( "click" );

        $(window).scroll(function() {
            if(typeof timeout == "number") {
                window.clearTimeout(timeout);
                delete timeout;
            }
            timeout = window.setTimeout( check, 600);
        });

        check = function () {
            if($(window).scrollTop() >= ($(document).height() - $(window).height() - 600)) {
                var offset = $('#offset').val();
                var num = $('#num').val();
                if(parseInt(offset) < parseInt(num)){
                    loadSearchResult(offset);
                }
            }
        }
    });
</script>