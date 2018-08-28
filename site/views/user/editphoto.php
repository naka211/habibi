<script src="<?php echo base_url();?>templates/js/StackBlur.js" type="text/javascript"></script>
<style>
    #canvas{
        max-width: 500px !important;
        height: auto !important;
    }
</style>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <a href="javascript:history.back()" class="btn btnUpload" style="margin-bottom: 20px;">&longleftarrow; Tilbage</a>
            <div class="row top_infoProfile" style="height: 550px;">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <div id="canvasHolder" style="position:absolute;left:15px; top:0px;">
                        <canvas height="500" width="504" style="width: 500px; height: 500px;" id="canvas"></canvas>
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
                    <button type="submit" class="btn bntMessage" style="margin-top: 30px;">Gem</button>
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
        if(imageObj.width <= 500){
            var widthCan = imageObj.width;
            var heightCan = imageObj.height;
        } else {
            var widthCan = imageObj.width;
            var ratio = imageObj.width/500;
            var heightCan = imageObj.height*ratio;
        }
        imageObj.onload = function() {
            canvas.width = widthCan;
            canvas.height = heightCan;
            cctx.drawImage(imageObj, 0, 0, 200, 100);
            StackBlur.image(imageObj, canvas, $("#slider").val(), false);
        };

        // slider onchange
        $("#slider").on("change", function () {
            StackBlur.image(imageObj, canvas, this.value, false);
            $("#imageData").val($("#canvas")[0].toDataURL());
            $("#blurIndex").val(this.value);
        })

        $("#slider").bind('input', function(e) {
            $(".tooltipText").text(this.value);
        })
    });
</script>