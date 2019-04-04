<script src="<?php echo base_url();?>templates/js/StackBlur.js" type="text/javascript"></script>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <a href="javascript:history.back()" class="btn backLink">« Tilbage</a>
            <div class="row top_infoProfile" style="height: 550px;">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12 wrap_canvas">
                    <div id="canvasHolder" style="position:absolute;left:15px; top:0px;">
                        <canvas id="canvas"></canvas>
                        <?php if($image->status == 0){?>Afventer godkendelse<?php }?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <br><br>
                    <?php echo form_open('user/saveEditedPhoto', array('method'=>'post', 'id'=>'blurForm'))?>
                    <div>Sløringsstørrelse</div>
                    <div class="tooltipSlider">
                        <input type="range" min="0" max="50" value="<?php echo $image->blurIndex;?>" id="slider" style="padding: 0px;" />
                        <span class="tooltipText">0</span>
                    </div>

                    <input type="hidden" id="imageData" name="imageData" value="<?php echo base64_encode(file_get_contents( './uploads/raw_photo/'.$image->image));?>">
                    <input type="hidden" id="blurIndex" name="blurIndex" value="<?php echo $image->blurIndex;?>">
                    <input type="hidden" id="imageName" name="imageName" value="<?php echo $image->image;?>">
                    <button type="submit" class="btn bntMessage m_fz14" style="margin-top: 30px;">Gem</button>
                    <?php
                    echo form_close();?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        // Canvas
        var canvas = $("#canvas")[0];
        var cctx = canvas.getContext("2d");

        var imageObj = new Image();
        // this will make CORS happy because the server is well configured
        imageObj.crossOrigin = 'anonymous';
        // Easiest is to always host your images on your own server
        imageObj.src = '<?php echo base_url();?>uploads/raw_photo/<?php echo $image->image;?>';

        imageObj.onload = function() {
            <?php if($isMobile == false){?>
            canvas.width = imageObj.width;
            canvas.height = imageObj.height;

            $('.wrap_canvas').css('width', '500px');
            $('.wrap_canvas').css('height', '500px');
            <?php } else {?>
            var screenWidth = $(window).width();
            var scaleWidth = canvas.width = screenWidth - 30;
            var ratio = canvas.width/imageObj.width;
            var scaleHeight = canvas.height = imageObj.height*ratio;

            $('.wrap_canvas').css('width', scaleWidth+'px');
            $('.wrap_canvas').css('height', scaleHeight+15+'px');
            <?php }?>
            //StackBlur.image(imageObj, canvas, $("#slider").val(), false);
            StackBlur.image(imageObj, canvas, $("#slider").val(), false, scaleWidth, scaleHeight);

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
                StackBlur.image(imageObj, canvas, this.value, false, scaleWidth, scaleHeight);
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