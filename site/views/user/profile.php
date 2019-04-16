<?php
if(isGoldMember()){
    $messageLink = 'href="javascript:void(0)" onclick="loadMoreMessages('.$profile->id.',0, true, \''.$profile->name.'\')"';
    //$chatLink = 'href="javascript:jqcc.cometchat.chatWith('.$profile->id.');"';
} else {
    $messageLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
}
if($status->isFavorite){
    $favoriteLink = 'href="javascript:void(0)" class="hover" onclick="callAjaxFunction('.$profile->id.', \'removeFavorite\')" title="Fjern favorit"';
} else {
    $favoriteLink = 'href="javascript:void(0)" onclick="callAjaxFunction('.$profile->id.', \'addFavorite\')" title="Tilføj favorit"';
}
$blinkAction = 'href="javascript:void(0);" onclick="sendBlink('.$profile->id.')"';
$blockLink = 'href="'.site_url('user/blockUser/'.$profile->id).'"';
$reportLink = 'data-fancybox data-src="#modalReport" href="javascript:void(0);"';
?>
<div id="content">
    <section class="section_infoProfile">
        <div class="container">
            <div class="row top_infoProfile">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <div class="img_avatar">
                        <?php if($profile->blurIndex == 0 || ($profile->blurIndex != 0 && allowViewAvatar($profile->id))) { ?>
                            <a data-fancybox="avatarGallery"
                               href="<?php echo base_url(); ?>uploads/user/<?php echo $profile->avatar; ?>"><img class="img-responsive" src="<?php echo base_url();?>/uploads/raw_thumb_user/<?php echo $profile->avatar;?>"></a>
                         <?php } else {?>
                            <img class="img-responsive" src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $profile->avatar;?>">
                        <?php }?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <div class="box_top_infoProfile">
                        <h3><?php echo $profile->name;?> <?php if($profile->login == 1){?><span class="status"></span><?php }?></h3>
                        <?php if($profile->type == 2){?>
                            <p>Guld medlem</p>
                        <?php } else {?>
                            <p>Gratis medlem</p>
                        <?php }?>
                        <p><?php echo $profile->slogan;?></p>

                        <?php if($status->isFriend == -1 || $status->isFriend == 2){?>
                            <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $profile->id;?>, 'requestAddFriendInProfile')" id="requestBtn" class="btn btnadd_friend">Tilføj ven</a>
                        <?php }?>
                        <?php if($status->isFriend == 0){?>
                            <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $profile->id;?>, 'cancelAddFriendInProfile')" id="requestBtn" class="btn btn_cancel_request">Annuller anmodning</a>
                        <?php }?>
                        <?php if($status->isFriend == 1){?>
                            <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $profile->id;?>, 'unFriendInProfile')" id="requestBtn" class="btn btnUnfriend">Fjern ven</a>
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
                                                <th>Højde: </th>
                                                <td><?php echo $profile->height?$profile->height.' cm':'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Hårfarve: </th>
                                                <td><?php echo $profile->hair_color?$profile->hair_color:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Land:</th>
                                                <td><?php echo $profile->land?$profile->land:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Branche: </th>
                                                <td><?php echo $profile->business?$profile->business:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Forhold:</th>
                                                <td><?php echo $profile->relationship?$profile->relationship:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Uddannelse:</th>
                                                <td><?php echo $profile->training?$profile->training:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Kropsbygning:</th>
                                                <td><?php echo $profile->body?$profile->body:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Stjernetegn:</th>
                                                <td><?php echo $profile->zodiac?$profile->zodiac:'Ej oplyst';?></td>
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
                                                <th>Vægt: </th>
                                                <td><?php echo $profile->weight?$profile->weight.' kg':'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Øjenfarve: </th>
                                                <td><?php echo $profile->eye_color?$profile->eye_color:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Region:</th>
                                                <td><?php echo $profile->region?$profile->region:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Jobtype: </th>
                                                <td><?php echo $profile->job_type?$profile->job_type:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Born:</th>
                                                <td><?php echo $profile->children?$profile->children:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Religion:</th>
                                                <td><?php echo $profile->religion?$profile->religion:'Ej oplyst';?></td>
                                            </tr>
                                            <tr>
                                                <th>Rygning:</th>
                                                <td><?php echo $profile->smoking?$profile->smoking:'Ej oplyst';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btnShowlist">...</a>
                        <ul class="list_action">
                            <?php if(($status->isFriend == 1 && $profile->chat == 0) || $profile->chat == 1){?>
                                <li><a <?php echo $messageLink;?> title="Send besked"><i class="i_email"></i></a></li>
                            <?php } else {?>
                                <li><a href="javascript:void(0);" title="Deaktiveret" style="background-color: red;"><i class="i_email"></i></a></li>
                            <?php }?>
                            <li><a <?php echo $blinkAction;?> <?php if($status->isKissed) echo 'class="hover"'?>  title="Send blink"><i class="i_blink"></i></a></li>
                            <li><a <?php echo $favoriteLink;?> id="favoriteBtn"><i class="i_star"></i></a></li>
                            <li><a <?php echo $blockLink;?>  title="Blokere profil"><i class="i_block"></i></a></li>
                            <li><a <?php echo $reportLink;?> title="Anmeld profil"><i class="i_report"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if(!empty($images)){?>
                    <div class="owl-carousel owl-theme owl_gallerys">
                        <?php foreach ($images as $image) { ?>
                            <div class="item">
                                <a data-fancybox="gallery"
                                   href="<?php echo base_url(); ?>uploads/photo/<?php echo $image->image; ?>"><img
                                            src="<?php echo base_url(); ?>uploads/thumb_photo/<?php echo $image->image; ?>"
                                            class="img-responsive"></a>
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
            <h4></h4>
            <div class="chat">
                <ul>
                </ul>
                <form class="frm_Chat" action="" method="POST" role="form">
                    <input type="text" class="form-control" id="message" placeholder="Skriv en besked her.........">
                    <button type="button" class="btn btnSend">SEND</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }?>
<div style="display: none;" id="modalReport" class="animated-modal modalChat">
    <div class="row">
        <?php echo form_open('user/report', array('id'=>'reportForm', 'class'=>'frm_register'))?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4>Anmeld profil <?php echo $profile->name;?></h4>
            Årsag til anmeldelse<br><br>
            For at anmelde en profil skal der være en relevant årsag, som f.eks. stødende profiltekst, en mulig falsk profil, misbrug af billede, stødende i forbindelse med kontakt.<br>
            Anmeld venligst IKKE en profil på baggrund af manglede svar på dine beskeder og lignende.<br><br>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="">Angiv årsag</label>
            <select name="reason" class="form-control">
                <option value="Stødende profiltekst">Stødende profiltekst</option>
                <option value="Brugernavn">Brugernavn</option>
                <option value="Kontaktinformation i profiltekst">Kontaktinformation i profiltekst</option>
                <option value="Falsk profil">Falsk profil</option>
                <option value="Misbrug af billede">Misbrug af billede</option>
                <option value="Stødende beskeder">Stødende beskeder</option>
                <option value="Kontaktinformation i profilnavn">Kontaktinformation i profilnavn</option>
            </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button type="button" class="btn btn_viewSearch" onclick="thanksClick();">Send anmeldelse</button>
        </div>
        <?php
        echo form_hidden('profileId', $profile->id);
        echo form_hidden('profileName', $profile->name);
        echo form_hidden('userId', $user->id);
        echo form_hidden('userName', $user->name);
        echo form_close();
        ?>
    </div>
</div>
<div style="display: none;" id="modalNotification" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Tak for anmeldesen vi undersøger den så hurtigt som muligt mvh kundeservice</p>
            </div>
            <button type="button" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="submitReportForm();">Luk</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        thanksClick = function () {
            $.fancybox.close();
            $.fancybox.open({src: '#modalNotification'});
        }
        submitReportForm = function () {
            $('#reportForm').submit();
        }
    });
</script>
