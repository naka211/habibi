<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <a href="javascript:history.back()" class="btn btnUpload" style="margin: 20px 0 0 0">&longleftarrow; Tilbage</a>
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Upload billede</h3>
                    </div>
                </div>
            </div>
            <p>Billedet er sendt til validering og det blir gjordt indenfor 24 timer mvh kundeservice</p>
            <input id="file" type="file" name="file" multiple="multiple"/>
            <div class="row">
                <?php foreach($listImages as $image){?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6 photo<?php echo $image->id;?>">
                        <div class="box_favorites_item">
                            <div class="favorites_img">
                                <a href="javascript:void(0);" class="btnClose_img" onclick="deletePhoto(<?php echo $image->id;?>)"><i class="fas fa-times-circle fa-2x"></i></a>
                                <a data-fancybox="gallery" href="<?php echo base_url();?>/uploads/photo/<?php echo $image->image;?>"><img src="<?php echo base_url();?>/uploads/thumb_photo/<?php echo $image->image;?>" alt="" class="img-responsive"></a>
                                <?php if($image->status == 0) echo 'Afventer godkendelse';?>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <a href="javascript:void(0);" onclick="location.reload();" id="reloadPage" style="display: none;">Reload</a>
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
<div style="display: none;" id="modalNotification" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Billedet er sendt til validering og det blir gjordt indenfor 24 timer mvh kundeservice</p>
            </div>
            <button type="button" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="confirmClick();">Luk</button>
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
                $.ajax({
                    method: "POST",
                    url: base_url+"ajax/sendEmailAdminToApprovePhoto",
                    data: { csrf_site_name: token_value}
                }).done(function() {
                    $('#reloadPage').click();
                });
            }
        });

        confirmClick = function () {
            $.fancybox.close();
            $('#file').click();
        }
    });
</script>