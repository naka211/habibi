<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>templates/js/StackBlur.js" type="text/javascript"></script>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <div class="row top_infoProfile" style="height: 550px;">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <!--<div class="img_avatar" id="imageHolder">
                        <img class="img-responsive" src="<?php /*echo base_url();*/?>/uploads/raw_thumb_user/<?php /*echo $user->avatar;*/?>">
                    </div>-->
                    <div id="canvasHolder" style="position:absolute;left:15px; top:0px;">
                        <canvas height="500" width="504" style="width: 500px; height: 500px;" id="canvas"></canvas>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <input id="file" type="file" name="file"/>
                    <?php if($user->avatar != 'no-avatar.jpg'){?>
                    <!--<a href="<?php /*echo site_url('user/blurAvatar');*/?>" class="btn bntMessage">Sløre</a>
                    <a href="<?php /*echo site_url('user/unblurAvatar');*/?>" class="btn bntMessage">Un-sløre</a>-->

                        <br><br>
                        <?php echo form_open('user/saveAvatar', array('method'=>'post'))?>
                        Sløringsstørrelse
                        <input type="range" min="0" max="50" value="<?php echo $user->blurIndex;?>" id="slider" />
                        <input type="hidden" id="imageData" name="imageData" value="<?php echo base64_encode(file_get_contents( './uploads/raw_thumb_user/'.$user->avatar ));?>">
                        <input type="hidden" id="blurIndex" name="blurIndex" value="<?php echo $user->blurIndex;?>">
                        <button type="submit" class="btn bntMessage" style="margin-top: 30px;">Gem</button>
                        <a href="<?php echo site_url('user/deleteAvatar');?>" class="btn bntDelete" style="margin-top: 30px;">Slet avatar</a>
                        <?php echo form_close();?>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>
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
                location.reload();
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
        imageObj.src = '<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $user->avatar;?>';
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
    });
</script>