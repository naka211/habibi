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
            <a class="btn bntMessage" href="<?php echo site_url('user/uploadPhoto');?>" style="margin-bottom: 20px; font-size: 14px;">
                <span>Upload billede</span>
            </a>
            <div class="row">
                <?php foreach($listImages as $image){?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-12 photo<?php echo $image->id;?>">
                        <div class="box_favorites_item">
                            <div class="favorites_img">
                                <a href="javascript:void(0);" class="btnClose_img" onclick="deletePhoto(<?php echo $image->id;?>)"><i class="fa fa-times-circle fa-2x"></i></a>
                                <a href="<?php echo site_url('user/editphoto/'.$image->id)?>" class="btnEdit_img"><i class="far fa-edit fa-2x"></i></a>
                                <a data-fancybox="gallery" href="<?php echo base_url();?>uploads/photo/<?php echo $image->image;?>?<?php echo time(); ?>"><img src="<?php echo base_url();?>uploads/thumb_photo/<?php echo $image->image;?>?<?php echo time(); ?>" alt="" class="img-responsive"></a>
                                <?php if($image->status == 0) echo 'Afventer godkendelse';?>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </section>
</div>