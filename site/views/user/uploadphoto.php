<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Upload billede</h3>
                    </div>
                </div>
            </div>
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dignissim a arcu et rutrum. Phasellus vel fringilla mi. Nunc convallis sapien sit amet pretium aliquam. Integer nec pharetra elit, nec aliquam justo.<br><br>
                Quisque est massa, lobortis eu efficitur sed, tempus scelerisque orci. Suspendisse interdum massa non nisl mollis mollis. Nullam lacinia, metus interdum accumsan feugiat, arcu mi venenatis neque, quis tristique dui arcu ut lectus.<br><br>
                Aenean vitae commodo odio, a pharetra diam. Sed at nisl fermentum, porttitor augue et, imperdiet nunc. Duis feugiat nisi quis malesuada auctor.</p>
            <input id="file" type="file" name="file" multiple="multiple"/>
            <div class="row">
                <?php foreach($listImages as $image){?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6">
                        <div class="box_favorites_item">
                            <div class="favorites_img">
                                <a href="javascript:void(0);" class="btnClose_img" onclick="confirmRemovePhoto(<?php echo $image->id;?>)"><i class="fas fa-times-circle fa-2x"></i></a>
                                <a data-fancybox="gallery" href="<?php echo base_url();?>/uploads/photo/<?php echo $image->image;?>"><img src="<?php echo base_url();?>/uploads/thumb_photo/<?php echo $image->image;?>" alt="" class="img-responsive"></a>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </section>
</div>

<div style="display: none;" id="modalConfirm" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p id="confirmText"></p>
            <div class="text-center">
                <a href="#" class="btn btnYes">JA</a>
                <a href="javascript:void(0);" onclick="$.fancybox.close();" class="btn btnNo">NEJ</a>
            </div>
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
            url: base_url+'ajax/uploadPhoto',
            data: {'csrf_site_name':token_value},
            onFileSuccess: function (file,data) {
                location.reload();
            }
        });
    });
</script>