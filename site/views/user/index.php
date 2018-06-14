<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <div class="row top_infoProfile">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <div class="img_avatar">
                        <img class="img-responsive" src="<?php echo base_url();?>uploads/thumb_user/<?php echo $user->avatar;?>">
                        <a href="<?php echo site_url('user/editAvatar');?>" class="btn btnEidt_avatar"><i class="i_image"></i> <span>Skift din avatar</span></a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <div class="box_top_infoProfile box_top_infoProfile_edit">
                        <h3><?php echo $user->name;?></h3>
                        <div class="box_gray">
                            <?php echo $user->slogan;?>
                        </div>
                        <div class="w_table_infoProfile mr0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="table_infoProfile">
                                        <table class="table table-condensed" width="100%">
                                            <tbody>
                                            <tr>
                                                <th>Alder:</th>
                                                <td><?php echo printAge($user->year);?></td>
                                            </tr>
                                            <tr>
                                                <th>Forhold:</th>
                                                <td><?php echo $user->relationship;?></td>
                                            </tr>
                                            <tr>
                                                <th>Etnisk oprindelse: </th>
                                                <td><?php echo $user->ethnic_origin;?></td>
                                            </tr>
                                            <tr>
                                                <th>Uddannelse:</th>
                                                <td><?php echo $user->training;?></td>
                                            </tr>
                                            <tr>
                                                <th>Region:</th>
                                                <td><?php echo $user->region;?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="table_infoProfile">
                                        <table class="table table-condensed">
                                            <tbody>
                                            <tr>
                                                <th>Køn:</th>
                                                <td><?php echo $user->gender==1?'Mand':'Kvinde';?></td>
                                            </tr>
                                            <tr>
                                                <th>Born:</th>
                                                <td><?php echo $user->children;?></td>
                                            </tr>
                                            <tr>
                                                <th>Religion:</th>
                                                <td><?php echo $user->religion;?></td>
                                            </tr>
                                            <tr>
                                                <th>Kropsbygning:</th>
                                                <td><?php echo $user->body;?></td>
                                            </tr>
                                            <tr>
                                                <th>Ryger:</th>
                                                <td><?php echo $user->smoking;?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <a class="btn_edit" href="<?php echo site_url('user/update');?>"><i class="i_edit"></i> <span>Redigere</span></a>
                        </div>

                        <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="switch-field">
                                <div class="switch-title">Chat</div>
                                <input type="radio" id="switch_left" name="chat" value="1" <?php /*if($user->chat == 1) echo 'checked';*/?> />
                                <label for="switch_left">Ja</label>
                                <input type="radio" id="switch_right" name="chat" value="0" <?php /*if($user->chat == 0) echo 'checked';*/?> />
                                <label for="switch_right">Nej</label>
                            </div>
                        </div>-->

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="owl-carousel owl-theme owl_gallerys">
                        <div class="item">
                            <a class="btn_editGallery" href="<?php echo site_url('user/uploadPhoto');?>">
                                <i class="i_plus"></i>
                                <span>Uploade billede</span>
                            </a>
                        </div>
                        <?php if(!empty($images)) {
                            foreach ($images as $image) {
                                ?>
                                <div class="item">
                                    <a data-fancybox="gallery" href="<?php echo base_url();?>uploads/photo/<?php echo $image->image;?>"><img src="<?php echo base_url();?>/uploads/thumb_photo/<?php echo $image->image;?>" alt="" class="img-responsive"></a>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>

                    <blockquote class="quote-card">
                        <p><?php echo $user->description;?></p>
                    </blockquote>
                </div>
            </div>

        </div>
    </section>
</div>
}