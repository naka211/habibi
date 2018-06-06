<?php
if(isGoldMember()){
    $messageLink = 'data-fancybox data-src="#modalChat" href="javascript:void(0)" onclick="loadMoreMessages('.$profile->id.',0, true)"';
    //$chatLink = 'href="javascript:jqcc.cometchat.chatWith('.$profile->id.');"';
} else {
    $messageLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
}
if($status->isFavorite){
    $favoriteLink = 'href="javascript:void(0)" class="hover" onclick="removeFavorite('.$profile->id.')" title="Fjern favorit"';
} else {
    $favoriteLink = 'href="javascript:void(0)" onclick="addFavorite('.$profile->id.')" title="Tilføj favorit"';
}
$blinkAction = 'href="javascript:void(0);" onclick="sendBlink('.$profile->id.')"';
$blockLink = 'href="'.site_url('user/blockUser/'.$profile->id).'"';
?>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <div class="row top_infoProfile">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <div class="img_avatar">
                        <img class="img-responsive" src="<?php echo base_url();?>/uploads/user/<?php echo $profile->avatar;?>">
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <div class="box_top_infoProfile">
                        <h3><?php echo $profile->name;?></h3>
                        <p><?php echo $profile->slogan;?></p>

                        <?php if($status->isFriend == -1 || $status->isFriend == 2){?>
                        <a href="<?php echo site_url('user/requestAddFriend/'.$profile->id);?>" class="btn btnadd_friend">Tilføj ven</a>
                        <?php }?>
                        <?php if($status->isFriend == 0){?>
                            <a href="<?php echo site_url('user/cancelAddFriend/'.$profile->id);?>" class="btn btn_cancel_request">Annuller anmodning</a>
                        <?php }?>
                        <?php if($status->isFriend == 1){?>
                            <a href="<?php echo site_url('user/unFriend/'.$profile->id);?>" class="btn btnUnfriend">Unfriend</a>
                        <?php }?>
                        <div class="w_table_infoProfile">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="table_infoProfile">
                                        <table class="table table-condensed" width="100%" style="margin-bottom: 0px">
                                            <tbody>
                                            <tr>
                                                <th>Alder:</th>
                                                <td><?php echo printAge($profile->year);?></td>
                                            </tr>
                                            <tr>
                                                <th>Forhold:</th>
                                                <td><?php echo $profile->relationship;?></td>
                                            </tr>
                                            <tr>
                                                <th>Etnisk oprindelse: </th>
                                                <td><?php echo $profile->ethnic_origin;?></td>
                                            </tr>
                                            <tr>
                                                <th>Uddannelse:</th>
                                                <td><?php echo $profile->training;?></td>
                                            </tr>
                                            <tr>
                                                <th>Region:</th>
                                                <td><?php echo $profile->region;?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="table_infoProfile">
                                        <table class="table table-condensed" style="margin-bottom: 0px">
                                            <tbody>
                                            <tr>
                                                <th>Køn:</th>
                                                <td><?php echo $profile->gender==1?'Mand':'Kvinde';?></td>
                                            </tr>
                                            <tr>
                                                <th>Born:</th>
                                                <td><?php echo $profile->children;?></td>
                                            </tr>
                                            <tr>
                                                <th>Religion: </th>
                                                <td><?php echo $profile->religion;?></td>
                                            </tr>
                                            <tr>
                                                <th>Kropsbygning:</th>
                                                <td><?php echo $profile->body;?></td>
                                            </tr>
                                            <tr>
                                                <th>Ryger:</th>
                                                <td><?php echo $profile->smoking;?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btnShowlist">...</a>
                        <ul class="list_action">
                            <li><a <?php echo $messageLink;?>><i class="i_email"></i></a></li>
                            <?php /*if($status->isFriend == 2){?><li><a <?php echo $chatLink;?>><i class="i_comment"></i></a></li><?php }*/?>
                            <li><a <?php echo $blinkAction;?>><i class="i_blink"></i></a></li>
                            <li><a <?php echo $favoriteLink;?> id="favoriteBtn"><i class="i_star"></i></a></li>
                            <li><a <?php echo $blockLink;?>><i class="i_block"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if(!empty($images)){?>
                    <div class="owl-carousel owl-theme owl_gallerys">
                        <?php foreach ($images as $image){?>
                        <div class="item">
                            <a data-fancybox="gallery" href="<?php echo base_url();?>uploads/photo/<?php echo $image->image;?>"><img src="<?php echo base_url();?>uploads/photo/<?php echo $image->image;?>" class="img-responsive"></a>
                        </div>
                        <?php }?>
                    </div>
                    <?php }?>
                    <blockquote class="quote-card">
                        <p><?php echo $profile->description;?></p>
                    </blockquote>
                </div>
            </div>

        </div>
    </section>
</div>

<?php if(isGoldMember()){?>
<div style="display: none;" id="modalChat" class="animated-modal modalChat">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="chat">
                <ul>
                </ul>
                <form class="frm_Chat" action="" method="POST" role="form">
                    <input type="text" class="form-control" id="message" placeholder="Skriv en besked her.........">
                    <button type="button" class="btn btnSend" onclick="sendMessage()">SEND</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }?>