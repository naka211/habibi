<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <div class="row top_infoProfile">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <div class="img_avatar">
                        <img class="img-responsive" src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>">
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <input id="file" type="file" name="file"/>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("#file").pekeUpload({
            theme:'bootstrap',
            btnText: 'Upload',
            allowedExtensions:"jpeg|jpg|png",
            url: base_url+'ajax/uploadAvatar',
            data: {'csrf_site_name':token_value},
            onFileSuccess: function (file,data) {
                location.reload();
            }
        });
    });
</script>