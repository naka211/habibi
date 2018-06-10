<link rel="stylesheet" href="<?php echo base_url();?>templates/css/peke.css">
<script src="<?php echo base_url();?>templates/js/pekeUpload.js" type="text/javascript"></script>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <div class="row top_infoProfile">
                <div class="col-lg-4 col-md-4 col-sm-4 col-ms-4 col-xs-12">
                    <div class="img_avatar">
                        <img class="img-responsive" src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>">
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-ms-8 col-xs-12">
                    <input id="file" type="file" name="file"/>
                    <?php if($user->avatar != 'no-avatar.jpg'){?>
                    <a href="<?php echo site_url('user/blurAvatar');?>" class="btn bntMessage">Sløre</a>
                    <a href="<?php echo site_url('user/unblurAvatar');?>" class="btn bntMessage">Un-sløre</a>
                    <a href="<?php echo site_url('user/deleteAvatar');?>" class="btn bntDelete">Slet</a>
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
    });
</script>