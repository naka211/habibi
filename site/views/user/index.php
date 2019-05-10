<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <div class="row top_infoProfile">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <div class="img_avatar">
                        <img class="img-responsive" src="<?php echo base_url();?>uploads/thumb_user/<?php echo $user->new_avatar?$user->new_avatar:$user->avatar;?>?<?php echo time();?>">
                        <a href="<?php echo site_url('user/editAvatar');?>" class="btn btnEidt_avatar"><i class="i_image"></i> <span>Skift profilbillede</span></a>
                    </div>
                    <?php if($user->new_avatar){?>Afventer godkendelse<?php }?>
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
                                                <td><?php echo printAge($user->id);?></td>
                                            </tr>
                                            <tr>
                                                <th>Højde: </th>
                                                <td><?php echo $user->height?$user->height.' cm':'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Hårfarve: </th>
                                                <td><?php echo $user->hair_color?$user->hair_color:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Land:</th>
                                                <td><?php echo $user->land?$user->land:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Branche: </th>
                                                <td><?php echo $user->business?$user->business:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Forhold:</th>
                                                <td><?php echo $user->relationship?$user->relationship:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Uddannelse:</th>
                                                <td><?php echo $user->training?$user->training:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Kropsbygning:</th>
                                                <td><?php echo $user->body?$user->body:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Stjernetegn:</th>
                                                <td><?php echo $user->zodiac?$user->zodiac:'Ej oplyst';?></td>
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
                                                <th>Vægt: </th>
                                                <td><?php echo $user->weight?$user->weight.' kg':'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Øjenfarve: </th>
                                                <td><?php echo $user->eye_color?$user->eye_color:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Region:</th>
                                                <td><?php echo $user->region?$user->region:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Jobtype: </th>
                                                <td><?php echo $user->job_type?$user->job_type:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Børn:</th>
                                                <td><?php echo $user->children?$user->children:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Religion:</th>
                                                <td><?php echo $user->religion?$user->religion:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Rygning:</th>
                                                <td><?php echo $user->smoking?$user->smoking:'Ej oplyst';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <a class="btn_edit" href="<?php echo site_url('user/update');?>"><i class="i_edit"></i> <span>Rediger</span></a>
                        </div>
                        <?php if($user->deactivation == 1){?>
                            <a href="<?php echo site_url('user/setDeactivation/0')?>" class="btn btn_viewSearch">Aktivér</a>
                        <?php }?>
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
                                <span>Upload billede</span>
                            </a>
                        </div>
                        <?php if(!empty($images)) {
                            foreach ($images as $image) {
                                ?>
                                <div class="item">
                                    <a data-fancybox="gallery" href="<?php echo base_url();?>uploads/raw_photo/<?php echo $image->image;?>"><img src="<?php echo base_url();?>/uploads/thumb_photo/<?php echo $image->image;?>" alt="" class="img-responsive"></a>
                                    <?php if($image->status == 0) echo 'Afventer godkendelse';?>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <blockquote class="quote-card">
                        <p><?php echo nl2br($user->description);?></p>
                    </blockquote>
                </div>
            </div>

        </div>
    </section>
</div>