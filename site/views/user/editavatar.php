<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>templates/js/StackBlur.js" type="text/javascript"></script>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <a href="javascript:history.back()" class="btn backLink">« Tilbage</a>
            <div class="row top_infoProfile">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12 wrap_canvas">
                    <div id="canvasHolder" style="position:absolute;left:15px; top:0px;">
                        <canvas id="canvas"></canvas>
                        <div id="previewAvatar" style="display: none;"></div>
                        <?php if($user->new_avatar){?>Afventer godkendelse<?php }?>
                        <div id="newAvatarActions" style="display: none;">
                            <a href="javascript:void(0);" data-fancybox data-src="#modalNotification" class="btn bntMessage  m_fz14 m_mr10" style="margin-top: 15px;">Gem</a>
                            <a href="<?php echo site_url('user/cancelAvatar');?>" id="cancelAvatar" class="btn bntDelete m_mr0" style="margin-top: 15px;">Slet</a>
                        </div>

                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12 wrap_info">
                    <?php if($isMobile != true){?>
                    <h4>Upload billed</h4>
                    <p>Her kan du uploade dit personlige profilbillede.<br>
                        Det må kun være dig selv på billedet. Når du har uploadet det, skal det valideres. Der kan gå op til 24 timer før det er valideret.<br>
                        1: Du trykker på upload og dit bibliotek åbner op og derefter vælger du et billede.<br>
                        2: Du kan gemme billedet, eller uploade et nyt.<br>
                        3: Når billedet er uploadet, kan du vælge at sløre det hvis du vil, derefter klikker du på  gem og det bliver sendt til validering.
                    </p>
                    <h4>Regler for profilbilleder</h4>
                    <p>
                        <img src="<?php echo base_url();?>templates/images/green.png" style="margin-top: -5px;"> Man skal kunne se hele dit ansigt<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være seksuelle undertoner på billedet<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være andre end dig på billedet<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være skrevet tekst eller lignede på billedet<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være rammer rundt om billedet<br>
                    </p>
                    <h4>Upload Avatar</h4>
                    <p>Når du klikker på denne, så vil det være muligt at vælge imellem nogle forskellige avatarer, du vælger blot den du syntes der passer digbedst.</p>

                    <?php } else {?>
                        <h4>Her kan du uploade dit personlige profilbillede <a href="#modal_moretext" data-toggle="modal" class="system_link">Læs mere</a></h4>
                        <div id="modal_moretext" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Upload billed</h4>
                                        <p>Her kan du uploade dit personlige profilbillede.<br>
                                            Det må kun være dig selv på billedet. Når du har uploadet det, skal det valideres. Der kan gå op til 24 timer før det er valideret.<br>
                                            1: Du trykker på upload og dit bibliotek åbner op og derefter vælger du et billede.<br>
                                            2: Du kan gemme billedet, eller uploade et nyt.<br>
                                            3: Når billedet er uploadet, kan du vælge at sløre det hvis du vil, derefter klikker du på  gem og det bliver sendt til validering.
                                        </p>
                                        <h4>Regler for profilbilleder</h4>
                                        <p>
                                            <img src="<?php echo base_url();?>templates/images/green.png" style="margin-top: -5px;"> Man skal kunne se hele dit ansigt<br>
                                            <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være seksuelle undertoner på billedet<br>
                                            <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være andre end dig på billedet<br>
                                            <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være skrevet tekst eller lignede på billedet<br>
                                            <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være rammer rundt om billedet<br>
                                        </p>
                                        <h4>Upload Avatar</h4>
                                        <p>Når du klikker på denne, så vil det være muligt at vælge imellem nogle forskellige avatarer, du vælger blot den du syntes der passer digbedst.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="text-center">
                        <input id="file" type="file" name="file" accept="image/*"/>
                        <a data-fancybox data-src="#modalSelectAvatar" href="javascript:void(0)" class="btn btnUpload"><i class="fas fa-cloud-upload-alt fa-lg"></i> UPLOAD AVATAR</a>
                    </div>
                    <?php if($listImages){?>
                        <div class="text-center">
                            <!--Eller<br>-->
                            <a data-fancybox data-src="#modalSelectImage" href="javascript:void(0);" class="btn bntMessage m_fz13" style="margin-top: 10px; margin-right: 0px; padding: 10px 30px;">Vælg profilbilled fra galleri</a>
                        </div>
                    <?php }?>
                    <?php if((!in_array($user->avatar, $defaultAvatars)) || ((in_array($user->avatar, $defaultAvatars)) && $user->new_avatar != '')){
                        $avatarData = $user->new_avatar?$user->new_avatar:$user->avatar;
                        ?>
                    <!--<a href="<?php /*echo site_url('user/blurAvatar');*/?>" class="btn bntMessage">Sløre</a>
                    <a href="<?php /*echo site_url('user/unblurAvatar');*/?>" class="btn bntMessage">Un-sløre</a>-->

                        <br><br>
                        <?php echo form_open('user/saveAvatar', array('method'=>'post', 'id'=>'blurForm'))?>
                        <div>Sløringsstørrelse</div>
                        <div class="tooltipSlider">
                            <input type="range" min="0" max="100" value="<?php echo $user->blurIndex;?>" id="slider" style="padding: 0px;" />
                            <span class="tooltipText">0</span>
                        </div>

                        <input type="hidden" id="imageData" name="imageData" value="<?php echo base64_encode(file_get_contents( './uploads/raw_thumb_user/'.$avatarData));?>">
                        <input type="hidden" id="blurIndex" name="blurIndex" value="<?php echo $user->blurIndex;?>">
                        <?php /*if($user->new_avatar != ''){*/?><!--
                            <a href="javascript:void(0);" data-fancybox data-src="#modalNotification" class="btn bntMessage  m_fz14 m_mr10" style="margin-top: 30px;">Gem</a>
                        <?php /*} else {*/?>
                            <button type="submit" class="btn bntMessage m_fz14 m_mr10" style="margin-top: 30px;">Gem</button>
                        --><?php /*}*/?>
                        <button type="submit" class="btn bntMessage m_fz14 m_mr10" style="margin-top: 30px;">Gem</button>
                        <a href="<?php echo site_url('user/deleteAvatar');?>" class="btn bntDelete m_mr0" style="margin-top: 30px;">Slet profilbillede</a>
                        <?php
                        $sendEmail = $user->new_avatar != ''?1:0;
                        echo form_hidden('sendEmailToApprove', $sendEmail);
                        echo form_close();?>
                    <?php }?>
                    <?php if(in_array($user->avatar, getGenderAvatars()) && $user->new_avatar == ''){?>
                    <div class="text-center">
                        <a href="<?php echo site_url('user/deleteAvatar');?>" class="btn bntDelete m_mr0" style="margin-top: 30px;">Slet avatar</a>
                    </div>
                    <?php }?>
                    <a href="javascript:void(0);" onclick="location.reload();" id="reloadPage" style="display: none;">Reload</a>
                </div>
            </div>
        </div>
    </section>
</div>
<div style="display: none;" id="modalSelectImage" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>Galleri</h2>
            <?php echo form_open('user/selectAvatarFromGallery', array('id'=>'selectAvatarGalleryForm', 'class' => 'selectAvatarForm'))?>
            <?php foreach ($listImages as $image){?>
                <label>
                    <input type="radio" name="imageName" value="<?php echo $image->image;?>" />
                    <img src="<?php echo base_url();?>uploads/thumb_photo/<?php echo $image->image;?>" width="100">
                </label>
            <?php }?>
            <div class="text-center">
                <button type="submit" class="btn btn_viewSearch">OK</button>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<div style="display: none;" id="modalSelectAvatar" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>Avatars</h2>
            <?php echo form_open('user/selectAvatarFromList', array('id'=>'selectAvatarListForm', 'class' => 'selectAvatarForm'))?>
            <?php
            if($user->gender == 1){
                $limit = 16;
                $gender = 'male';
            } else {
                $limit = 30;
                $gender = 'female';
            }
            for ($i = 1; $i <= $limit; $i++){?>
                <label>
                    <input type="radio" name="imageName" value="<?php echo $gender.$i.'.png';?>" onclick="setButton();" />
                    <img src="<?php echo base_url();?>uploads/thumb_user/<?php echo $gender.$i.'.png';?>">
                </label>
            <?php }?>
            <div class="text-center">
                <button data-fancybox-close class="btn btn_viewSearch" id="closeSelection">OK</button>
                <button type="submit" class="btn btn_viewSearch" style="display: none;" id="acceptSelection">OK</button>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<div style="display: none;" id="modalNotification" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Billedet er sendt til validering.<br><br>
                    Der kan gå optil 24 timer før det bliver valideret.<br><br>
                    Mvh. Habibidating.dk</p>
            </div>
            <a href="<?php echo site_url('user/confirmAvatar');?>" id="confirmButton" class="btn bntMessage m_fz14 m_mr10" style="margin-bottom: 0px;">OK</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#file").pekeUpload({
            bootstrap: true,
            showPreview: false,
            showFilename: false,
            btnText: 'UPLOAD BILLED',
            allowedExtensions:"jpeg|jpg|png",
            url: base_url+'ajax/uploadAvatar',
            data: {'csrf_site_name':token_value},
            onFileSuccess: function (file, data) {
                <?php if($isMobile == true){?>
                $(".wrap_info").css('margin-top', '40px');
                <?php }?>
                $("#canvas").hide();
                $("#previewAvatar").html('<img src="'+base_url+'uploads/raw_thumb_user/'+data.message.file_name+'" style="width: 100%;" />');
                $("#previewAvatar").show();
                $("#newAvatarActions").show();

                $('#confirmButton').attr('href', $('#confirmButton').attr('href')+'/'+data.message.file_name);
                $('#cancelAvatar').attr('href', $('#cancelAvatar').attr('href')+'/'+data.message.file_name);
            }
        });

        setButton = function () {
            $('#closeSelection').hide();
            $('#acceptSelection').show();
        }

        // Canvas
        var canvas = $("#canvas")[0];
        //var cctx = canvas.getContext("2d");
        /*var buff = document.createElement("canvas");
        buff.width = canvas.width;
        buff.height = canvas.height;*/

        var imageObj = new Image();
        // this will make CORS happy because the server is well configured
        imageObj.crossOrigin = 'anonymous';
        // Easiest is to always host your images on your own server
        imageObj.src = '<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $user->new_avatar?$user->new_avatar:$user->avatar;?>';

        imageObj.onload = function() {
            <?php if($isMobile == false){?>
            canvas.width = imageObj.width;
            canvas.height = imageObj.height;

            /*$('.wrap_canvas').css('width', '500px');*/
            $('.wrap_canvas').css('height', '500px');
            <?php } else {?>
            var screenWidth = $(window).width();
            var scaleWidth = canvas.width = screenWidth - 30;
            var ratio = canvas.width/imageObj.width;
            var scaleHeight = canvas.height = imageObj.height*ratio;

            $('.wrap_canvas').css('width', scaleWidth+'px');
            $('.wrap_canvas').css('height', scaleHeight+15+'px');
            <?php }?>
            //Draw canvas
            StackBlur.image(imageObj, canvas, $("#slider").val()/2, false);

            //set width and height to canvas
            <?php if($isMobile == false){?>
            $('#canvas').css('width', '500px');
            $('#canvas').css('height', '500px');
            <?php } else {?>
            $('#canvas').css('width', scaleWidth+'px');
            $('#canvas').css('height', scaleHeight+'px');
            <?php }?>

            // slider onchange
            $("#slider").on("change", function () {
                StackBlur.image(imageObj, canvas, this.value/2, false);
                <?php if($isMobile == true){?>
                $('#canvas').css('width', scaleWidth+'px');
                $('#canvas').css('height', scaleHeight+'px');
                <?php }?>
                $("#imageData").val($("#canvas")[0].toDataURL());
                $("#blurIndex").val(this.value);
            })

            $("#slider").bind('input', function(e) {
                $(".tooltipText").text(this.value);
            })
        };
    });
</script>