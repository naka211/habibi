<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-8">
                <div class="main_right">
                    <div class="invitationer_box">
                        <h3 class="text-uppercase">Profil billeder</h3>
                        <ul class="list_photo gallery" id="listMyProfilePicture">
                            <li class="portfolio isotope-item">
                                <a class="portfolio_img" href="#" data-target="#f_Transfer_Profile_Picture" data-toggle="modal">
                                    <img src="<?php echo base_url();?>templates/img/browser_img.png" alt="" class="img-responsive"/>
                                </a>
                            </li>
                            <?php if($listProfilePictures){foreach($listProfilePictures as $row){?>
                            <li id="show_images_<?php echo $row->id;?>" class="portfolio isotope-item">
                                <a class="portfolio_img" href="javascript:void(0)">
                                    <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/user/<?php echo $row->image;?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
                                </a>
                                <a href="javascript:void(0)" onclick="deletedata('user_image','<?php echo $row->id;?>','show_images_<?php echo $row->id;?>');"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
                            </li>
                            <?php }}?>
                        </ul>
                    </div>
                    <div class="invitationer_box">
                        <h3 class="text-uppercase">Mit live i billede</h3>
                        <ul class="list_photo gallery" id="list_myphoto">
                            <li class="portfolio isotope-item">
                                <a class="portfolio_img" href="#" data-target="#f_Transfer" data-toggle="modal">
                                    <img src="<?php echo base_url();?>templates/img/browser_img.png" alt="" class="img-responsive"/>
                                </a>
                            </li>
                            <?php if($listImages){foreach($listImages as $row){?>
                                <li id="show_images_<?php echo $row->id;?>" class="portfolio isotope-item">
                                    <a class="portfolio_img" href="javascript:void(0)">
                                        <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row->image;?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
                                    </a>
                                    <a href="javascript:void(0)" onclick="deletedata('user_image','<?php echo $row->id;?>','show_images_<?php echo $row->id;?>');"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
                                </li>
                            <?php }}?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="f_Transfer" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg_white">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Overfør fra</h4>
            </div>
            <div class="modal-body text-center pt10">
                <?php echo form_open_multipart(site_url('user/uploadPhoto'), array('name'=>'frm_uploadPhoto','id'=>'frm_uploadPhoto'))?>
                <label>Min computer</label>
                <input name="myImage[]" id="myImage" type="file" multiple="true" accept="image/*" style="borer:none; width: 200px;"/>
                <?php echo form_hidden('type', '1');?>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<div id="f_Transfer_Profile_Picture" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg_white">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Overfør fra</h4>
            </div>
            <div class="modal-body text-center pt10">
                <?php echo form_open_multipart(site_url('user/uploadPhoto'), array('name'=>'frm_uploadProfilePicture','id'=>'frm_uploadProfilePicture'))?>
                <label>Min computer</label>
                <input name="myImage[]" id="myProfilePicture" type="file" multiple="true" accept="image/*" style="borer:none; width: 200px;"/>
                <?php echo form_hidden('type', '2');?>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>