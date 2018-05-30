<?php
if(isGoldMember()){
    $blinkAction = 'href="javascript:void(0);" onclick="sendBlink('.$profile->id.')"';
    $messageLink = 'data-fancybox data-src="#modalChat" href="javascript:;"';
    $visitingLink = 'href="'.site_url('user/visits').'"';
    $chatLink = 'href="javascript:jqcc.cometchat.chatWith('.$profile->id.');"';
} else {
    $blinkAction = $messageLink = $visitingLink = $friendRequestLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
}
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
                                                <th>Postnr:</th>
                                                <td><?php echo $profile->code;?></td>
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
                            <?php if($status->isFriend == 2){?><li><a <?php echo $chatLink;?>><i class="i_comment"></i></a></li><?php }?>
                            <li><a <?php echo $blinkAction;?>><i class="i_blink"></i></a></li>
                            <li><a href="favorites.php"><i class="i_star"></i></a></li>
                            <li><a href="block_list.php"><i class="i_block"></i></a></li>
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

<div style="display: none;" id="modalChat" class="animated-modal modalChat">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="chat">
                <ul>
                    <li class="other">
                        <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/toffeenutdesign/128.jpg" /></a>

                        <div class="message blur">
                            <div class="hider">
                                <span>Click to read</span>
                            </div>
                            <p>
                                Itaque quod et dolore accusantium. Labore aut similique ab voluptas rerum quia. Reprehenderit voluptas doloribus ut nam tenetur ipsam.
                            </p>
                        </div>
                        <div class="date">Sendt: d. 13/02/2018 kl. 22:09</div>
                    </li>
                    <li class="other">
                        <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/toffeenutdesign/128.jpg" /></a>
                        <div class="message">
                            <div class="hider">
                                <span>Click to read</span>
                            </div>
                            <p>
                                Modi ratione aliquid non. Et porro deserunt illum sed velit necessitatibus. Quis fuga et et fugit consequuntur. Et veritatis fugiat veniam pariatur maxime iusto aperiam.
                            </p>
                        </div>
                        <div class="date">
                            Sendt: d. 13/02/2018 kl. 22:09
                        </div>
                    </li>
                    <li class="you">
                        <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/igorgarybaldi/128.jpg" /></a>
                        <div class="message">
                            <div class="hider">
                                <span>Click to read</span>
                            </div>
                            <p>
                                Provident impedit atque nemo culpa et modi molestiae. Error non dolorum voluptas non a. Molestiae et nobis nisi sed.
                            </p>
                        </div>
                        <div class="date">
                            Sendt: d. 13/02/2018 kl. 22:09
                        </div>
                    </li>
                    <li class="other">
                        <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/toffeenutdesign/128.jpg" /></a>
                        <div class="message">
                            <div class="hider">
                                <span>Click to read</span>
                            </div>
                            <p>
                                Id vel ducimus perferendis fuga excepturi nulla. Dolores dolores amet et laborum facilis. Officia magni ut non autem et qui incidunt. Qui similique fugit vero porro qui cupiditate.
                            </p>
                        </div>
                        <div class="date">
                            Sendt: d. 13/02/2018 kl. 22:09
                        </div>
                    </li>
                    <li class="you">
                        <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/igorgarybaldi/128.jpg" /></a>
                        <div class="message">
                            <div class="hider">
                                <span>Click to read</span>
                            </div>
                            <p>
                                Provident impedit atque nemo culpa et modi molestiae. Error non dolorum voluptas non a. Molestiae et nobis nisi sed.
                            </p>
                        </div>
                        <div class="date">
                            Sendt: d. 13/02/2018 kl. 22:09
                        </div>
                    </li>
                    <li class="you">
                        <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/igorgarybaldi/128.jpg" /></a>
                        <div class="message">
                            <div class="hider">
                                <span>Click to read</span>
                            </div>
                            <p>
                                Est ut at eum sed perferendis ea hic. Tempora perspiciatis magnam aspernatur explicabo ea. Sint atque quod.
                            </p>
                        </div>
                        <div class="date">
                            Sendt: d. 13/02/2018 kl. 22:09
                        </div>
                    </li>
                </ul>
                <form class="frm_Chat" action="" method="POST" role="form">
                    <input type="text" class="form-control" placeholder="Skriv en besked her.........">
                    <button type="submit" class="btn btnSend">SEND</button>
                </form>
            </div>
        </div>
    </div>
</div>