<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>templates/js/StackBlur.js" type="text/javascript"></script>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <a href="javascript:history.back()" class="btn btnUpload" style="margin-bottom: 20px;">&longleftarrow; Tilbage</a>
            <div class="row top_infoProfile" style="height: 550px;">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12" style="min-height: 500px;">
                    <!--<div class="img_avatar" id="imageHolder">
                        <img class="img-responsive" src="<?php /*echo base_url();*/?>/uploads/raw_thumb_user/<?php /*echo $user->avatar;*/?>">
                    </div>-->
                    <div id="canvasHolder" style="position:absolute;left:15px; top:0px;">
                        <canvas height="500" width="504" style="width: 500px; height: 500px;" id="canvas"></canvas>
                        <?php if($user->new_avatar){?>Afventer godkendelse<?php }?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <h4>Her kan du uploade dit personlige profilbillede</h4>
                    <p>Det må kun være dig selv på billedet. Når du har uploadet det, skal det valideres. Der kan gå op til 24 timer før det er valideret.<br>
                        1: Du trykker på upload og dit bibliotek åbner op og derefter vælger du et billede.<br>
                        2: Du kan gemme billedet, eller uploade et nyt.<br>
                        3: Når billedet er uploadet, kan du vælge at sløre det hvis du vil, derefter klikker du på  gem og det bliver sendt til validering.

                    <h4>Regler for profilbilleder:</h4>
                        <img src="<?php echo base_url();?>templates/images/green.png" style="margin-top: -5px;"> Man skal kunne se hele dit ansigt<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være seksuelle undertoner på billedet<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være andre end dig på billedet<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være skrevet tekst eller lignede på billedet<br>
                        <img src="<?php echo base_url();?>templates/images/red.png" style="margin-top: -5px;"> Der må ikke være rammer rundt om billedet<br>
                    </p>
                    <input id="file" type="file" name="file"/>
                    <!--<div class="text-center">
                        <a data-fancybox data-src="#modalNotification" href="javascript:void(0)" class="btn btnUpload" style="margin-bottom: 10px;"><i class="fas fa-cloud-upload-alt fa-lg"></i> Upload</a>
                    </div>-->
                    <?php if($listImages){?>
                        <div class="text-center">
                            OR<br>
                            <a data-fancybox data-src="#modalSelectImage" href="javascript:void(0);" class="btn bntMessage m_fz13" style="margin-top: 10px; margin-right: 0px; padding: 10px 30px;">Vælg profilbilled fra galleri</a>
                        </div>
                    <?php }?>
                    <?php if(($user->avatar != 'no-avatar1.png' && $user->avatar != 'no-avatar2.png') || (($user->avatar == 'no-avatar1.png' || $user->avatar == 'no-avatar2.png') && $user->new_avatar != '')){
                        $avatarData = $user->new_avatar?$user->new_avatar:$user->avatar;
                        ?>
                    <!--<a href="<?php /*echo site_url('user/blurAvatar');*/?>" class="btn bntMessage">Sløre</a>
                    <a href="<?php /*echo site_url('user/unblurAvatar');*/?>" class="btn bntMessage">Un-sløre</a>-->

                        <br><br>
                        <?php echo form_open('user/saveAvatar', array('method'=>'post', 'id'=>'blurForm'))?>
                        <div>Sløringsstørrelse</div>
                        <div class="tooltipSlider">
                            <input type="range" min="0" max="50" value="<?php echo $user->blurIndex;?>" id="slider" style="padding: 0px;" />
                            <span class="tooltipText">0</span>
                        </div>

                        <input type="hidden" id="imageData" name="imageData" value="<?php echo base64_encode(file_get_contents( './uploads/raw_thumb_user/'.$avatarData));?>">
                        <input type="hidden" id="blurIndex" name="blurIndex" value="<?php echo $user->blurIndex;?>">
                        <?php if($user->new_avatar != ''){?>
                            <a href="javascript:void(0);" data-fancybox data-src="#modalNotification" class="btn bntMessage  m_fz14 m_mr10" style="margin-top: 30px;">Gem</a>
                        <?php } else {?>
                            <button type="submit" class="btn bntMessage m_fz14 m_mr10" style="margin-top: 30px;">Gem</button>
                        <?php }?>
                        <a href="<?php echo site_url('user/deleteAvatar');?>" class="btn bntDelete m_mr0" style="margin-top: 30px;">Slet profilbillede</a>
                        <?php
                        $sendEmail = $user->new_avatar != ''?1:0;
                        echo form_hidden('sendEmailToApprove', $sendEmail);
                        echo form_close();?>
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
            <?php echo form_open('user/selectAvatarFromGallery', array('id'=>'selectAvatrForm'))?>
            <?php foreach ($listImages as $image){?>
                <label>
                    <input type="radio" name="imageName" value="<?php echo $image->image;?>" />
                    <img src="<?php echo base_url();?>/uploads/thumb_photo/<?php echo $image->image;?>" width="100">
                </label>
            <?php }?>
            <div class="text-center">
                <button type="submit" class="btn btn_viewSearch">OK</button>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<div style="display: none;" id="modalNotification" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Billedet er sendt til validering, det bliver gjort indefor 24 timer Mvh Kundeservice</p>
            </div>
            <button type="button" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="confirmClick();">OK</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#file").pekeUpload({
            bootstrap: true,
            showPreview: true,
            showFilename: false,
            btnText: 'Upload',
            allowedExtensions:"jpeg|jpg|png",
            url: base_url+'ajax/uploadAvatar',
            data: {'csrf_site_name':token_value},
            onFileSuccess: function (file,data) {
                $('#reloadPage').click();
                /*$.ajax({
                    method: "POST",
                    url: base_url+"ajax/sendEmailAdminToApproveAvatar",
                    data: { csrf_site_name: token_value}
                }).done(function() {
                    $('#reloadPage').click();
                });*/
            }
        });


        // Canvas
        var canvas = $("#canvas")[0];
        var cctx = canvas.getContext("2d");
        /*var buff = document.createElement("canvas");
        buff.width = canvas.width;
        buff.height = canvas.height;*/

        var imageObj = new Image();
        // this will make CORS happy because the server is well configured
        imageObj.crossOrigin = 'anonymous';
        // Easiest is to always host your images on your own server
        imageObj.src = '<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $user->new_avatar?$user->new_avatar:$user->avatar;?>';
        imageObj.onload = function() {
            canvas.width = imageObj.width;
            canvas.height = imageObj.height;
            cctx.drawImage(imageObj, 0, 0);
            StackBlur.image(imageObj, canvas, $("#slider").val(), false);
        };

        // slider onchange
        $("#slider").on("change", function () {
            StackBlur.image(imageObj, canvas, this.value, false);
            /*StackBlur.canvasRGBA(canvas, 50, 50, 200, 200, this.value);*/
            $("#imageData").val($("#canvas")[0].toDataURL());
            $("#blurIndex").val(this.value);
        })

        $("#slider").bind('input', function(e) {
            $(".tooltipText").text(this.value);
        })

        confirmClick = function () {
            $.fancybox.close();
            $('#blurForm').submit();
        }
    });
</script>