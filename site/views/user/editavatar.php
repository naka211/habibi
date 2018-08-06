<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>templates/js/StackBlur.js" type="text/javascript"></script>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <a href="javascript:history.back()" class="btn btnUpload" style="margin-bottom: 20px;">&longleftarrow; Tilbage</a>
            <div class="row top_infoProfile" style="height: 550px;">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <!--<div class="img_avatar" id="imageHolder">
                        <img class="img-responsive" src="<?php /*echo base_url();*/?>/uploads/raw_thumb_user/<?php /*echo $user->avatar;*/?>">
                    </div>-->
                    <div id="canvasHolder" style="position:absolute;left:15px; top:0px;">
                        <canvas height="500" width="504" style="width: 500px; height: 500px;" id="canvas"></canvas>
                        <?php if($user->new_avatar){?>Afventer godkendelse<?php }?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dignissim a arcu et rutrum. Phasellus vel fringilla mi. Nunc convallis sapien sit amet pretium aliquam. Integer nec pharetra elit, nec aliquam justo.<br><br>
                        Quisque est massa, lobortis eu efficitur sed, tempus scelerisque orci. Suspendisse interdum massa non nisl mollis mollis. Nullam lacinia, metus interdum accumsan feugiat, arcu mi venenatis neque, quis tristique dui arcu ut lectus.<br><br>
                        Aenean vitae commodo odio, a pharetra diam. Sed at nisl fermentum, porttitor augue et, imperdiet nunc. Duis feugiat nisi quis malesuada auctor.</p>
                    <input id="file" type="file" name="file"/>
                    <?php if($listImages){?>
                        <div class="text-center">
                            OR<br>
                            <a data-fancybox data-src="#modalSelectImage" href="javascript:void(0);" class="btn bntMessage" style="margin-top: 10px; margin-right: 0px; padding: 10px 30px;">Vælg avatar fra galleri</a>
                        </div>
                    <?php }?>
                    <?php if($user->avatar != 'no-avatar.jpg' || ($user->avatar == 'no-avatar.jpg' && $user->new_avatar != '')){
                        $avatarData = $user->new_avatar?$user->new_avatar:$user->avatar;
                        ?>
                    <!--<a href="<?php /*echo site_url('user/blurAvatar');*/?>" class="btn bntMessage">Sløre</a>
                    <a href="<?php /*echo site_url('user/unblurAvatar');*/?>" class="btn bntMessage">Un-sløre</a>-->

                        <br><br>
                        <?php echo form_open('user/saveAvatar', array('method'=>'post'))?>
                        <div>Sløringsstørrelse</div>
                        <div class="tooltipSlider">
                            <input type="range" min="0" max="50" value="<?php echo $user->blurIndex;?>" id="slider" style="padding: 0px;" />
                            <span class="tooltipText">0</span>
                        </div>

                        <input type="hidden" id="imageData" name="imageData" value="<?php echo base64_encode(file_get_contents( './uploads/raw_thumb_user/'.$avatarData));?>">
                        <input type="hidden" id="blurIndex" name="blurIndex" value="<?php echo $user->blurIndex;?>">
                        <button type="submit" class="btn bntMessage" style="margin-top: 30px;">Gem</button>
                        <a href="<?php echo site_url('user/deleteAvatar');?>" class="btn bntDelete" style="margin-top: 30px;">Slet avatar</a>
                        <?php echo form_close();?>
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
                $.ajax({
                    method: "POST",
                    url: base_url+"ajax/sendEmailAdminToApproveAvatar",
                    data: { csrf_site_name: token_value}
                }).done(function() {
                    $('#reloadPage').click();
                });
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
    });
</script>