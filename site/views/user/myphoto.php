<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Mine billeder</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach($listImages as $image){?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6 photo<?php echo $image->id;?>">
                        <div class="box_favorites_item">
                            <div class="favorites_img">
                                <a href="javascript:void(0);" class="btnClose_img" onclick="deletePhoto(<?php echo $image->id;?>)"><i class="fas fa-times-circle fa-2x"></i></a>
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