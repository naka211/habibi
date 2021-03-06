<?php
if(isGoldMember()){
    $isMobileVal = $isMobile?'true':'false';
    $messageLink = 'href="javascript:void(0)" onclick="loadMoreMessages('.$profile->id.',0, true, '. $isMobileVal.', \''.$profile->name.'\')"';
    //$messageLink = 'href="'.site_url('user/chat/'.$profile->id.'/'.$profile->name).'"';
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
if(empty($status->isBlocked)){
    $blockLink = 'href="'.site_url('user/blockUser/'.$profile->id).'" title="Blokere profil"';
} else {
    $blockLink = 'href="javascript:void(0);" style="background-color: red;"';
}

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
                               href="<?php echo base_url(); ?>uploads/raw_thumb_user/<?php echo $profile->avatar; ?>"><img class="img-responsive" src="<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $profile->avatar;?>"></a>
                         <?php } else {?>
                            <a data-fancybox="avatarGallery"
                               href="<?php echo base_url(); ?>uploads/thumb_user/<?php echo $profile->avatar; ?>"><img class="img-responsive" src="<?php echo base_url();?>uploads/thumb_user/<?php echo $profile->avatar;?>"></a>
                            <!--<img class="img-responsive" src="<?php /*echo base_url();*/?>uploads/thumb_user/<?php /*echo $profile->avatar;*/?>">-->
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
                            <a href="javascript:void(0);" onclick="callAjaxFunction(<?php echo $profile->id;?>, 'requestAddFriendInProfile')" id="requestBtn" class="btn btnadd_friend">Venneanmodning</a>
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
                                                <td><?php echo printAge($profile->id);?></td>
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
                                                <th>Børn:</th>
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
                            <li><a <?php echo $blockLink;?>><i class="i_block"></i></a></li>
                            <li><a <?php echo $reportLink;?> title="Anmeld profil"><i class="i_report"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if(!empty($images)){?>
                    <div class="owl-carousel owl-theme owl_gallerys">
                        <?php if(hasBlurredImage($profile->id) && allowViewAvatar($profile->id)) { ?>
                            <?php foreach ($images as $image) {
                                if(file_exists($this->config->item('root').'uploads/raw_thumb_photo/'.$image->image)){
                                    $fileFolder = 'raw_thumb_photo';
                                } else {
                                    $fileFolder = 'thumb_photo';
                                }
                                ?>
                                <div class="item">
                                    <a data-fancybox="gallery"
                                       href="<?php echo base_url(); ?>uploads/raw_photo/<?php echo $image->image; ?>?<?php echo time(); ?>"><img src="<?php echo base_url(); ?>uploads/<?php echo $fileFolder.'/'.$image->image; ?>" class="img-responsive"></a>
                                </div>
                            <?php }
                        } else {?>
                            <?php foreach ($images as $image) { ?>
                                <div class="item">
                                    <a data-fancybox="gallery"
                                       href="<?php echo base_url(); ?>uploads/photo/<?php echo $image->image; ?>"><img
                                                src="<?php echo base_url(); ?>uploads/thumb_photo/<?php echo $image->image; ?>?<?php echo time(); ?>"
                                                class="img-responsive"></a>
                                </div>
                            <?php }
                        }?>
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
                <a href="javascript:;" class="btn bntBlock">Slet historik</a>
                <span class="deleteWaiting" style="display: none;">
                    <img src="<?php echo base_url();?>templates/images/preloader.gif" width="64">
                </span>
                <h4></h4>
                <div class="chat">
                    <ul>
                    </ul>
                    <input type="hidden" id="latestMsgId" value="">
                    <div id="imgContainer" style="display: none;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                        <div class="canvas_wrap">
                        </div>
                        <div class="preview_action">
                            <a href="javascript:void(0);" id="deletePreviewImage"><img src="<?php echo base_url(); ?>templates/images/1x/delete_icon.png" style="width: 24px;"></a>
                            <button type="button" class="btn" id="sendImage" style="margin-top: 50px; width: 24px; height: 24px;"><img src="<?php echo base_url().'templates/';?>images/1x/i_send.png" alt="" class="img-responsive"></button>
                        </div>

                    </div>
                    <span class="waiting" style="display: none;">
                        <img src="<?php echo base_url();?>templates/images/preloader.gif" width="64">
                    </span>
                    <form class="frm_Chat col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0" action="" method="POST" role="form" enctype="multipart/form-data">
                        <input type="hidden" id="profileId" name="profileId" value="">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="box_sendmedia">
                            <input type="file" name="messageImage" id="messageImage" accept="image/*">
                        </div>
                        <textarea class="form-control" id="message" placeholder="Skriv en besked her........." onkeyup="textAreaAdjust(this)"></textarea>
                        <button type="button" class="btn btnSend" id="btnSend"><img src="<?php echo base_url().'templates/';?>images/1x/i_send.png" alt="" class="img-responsive"></button>
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
            <button type="submit" class="btn btn_viewSearch">Send anmeldelse</button>
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
<script>
    $(document).ready(function() {
        confirmDeleteMessage = function (profileId, text) {
            $('#confirmText').html(text);
            $('#modalConfirm .btnYes').attr('onclick', 'deleteMessageOnPage('+profileId+')');
            $.fancybox.open({src: '#modalConfirm'});
        }

        deleteMessageOnPage = function (profileId) {
            $.fancybox.close();

            $('.bntBlock').hide();
            $(".deleteWaiting").show();

            $.ajax({
                method: "POST",
                url: base_url+"ajax/deleteMessage",
                data: { csrf_site_name: token_value, profile_id: profileId }
            }).done(function(data) {
                $(".deleteWaiting").hide();
                $('.bntBlock').show();
                $.fancybox.destroy();
                //location.reload();
            });
        }

        <?php if($isMobile == false){?>
        $("#message").emojioneArea({
            search: false,
            useInternalCDN: true,
            filtersPosition: "bottom",
            tones: false,
            /*saveEmojisAs: "unicode",*/
            events:{
                keydown: function (editor, event) {
                    if(event.keyCode == 13){
                        $("#message").data("emojioneArea").hidePicker();
                        sendMessage($("#profileId").val(), this.getText(), <?php echo $isMobile?'true':'false';?>)
                        // not new line
                        event.preventDefault();
                        return false;
                    }
                }
            }
        });
        <?php } else {?>
        //Handle enter key in message
        $('#message').keyup(function(e){
            if(e.keyCode == 13){
                $('.btnSend').click();
                // not new line
                e.preventDefault();
                return false;
            }
        });

        $('.frm_Chat').on('keypress', function(e) {
            return e.which !== 13;
        });
        ////
        <?php }?>

        ver = iOSversion();

        document.getElementById("messageImage").onchange = function (evt) {
            var image = evt.target.files[0]; // FileList object

            if(image != undefined){
                $('#messageImage').click(function (event) {
                    event.preventDefault();
                });

                <?php if($isMobile == false){?>
                $("#message").data("emojioneArea").disable();
                <?php } else {?>
                $("#message").attr('disabled', 'disabled');
                <?php }?>

                $(".waiting").fadeIn(100);

                if (window.File && window.FileReader && window.FileList && window.Blob) {
                    var reader = new FileReader();
                    // Closure to capture the file information.
                    reader.addEventListener("load", function (e) {
                        const imageData = e.target.result;
                        window.loadImage(imageData, function (img) {
                            if (img.type === "error") {
                                console.log("couldn't load image:", img);
                            } else {
                                window.EXIF.getData(img, function () {
                                    <?php if($isMobile == false){?>
                                    var canvas = window.loadImage.scale(img, {orientation: 0, canvas: true, maxHeight: 100});
                                    <?php } else {?>
                                    var orientation = window.EXIF.getTag(this, "Orientation");
                                    if(ver === undefined){
                                        var canvas = window.loadImage.scale(img, {orientation: 0 || 0, canvas: true, maxHeight: 100});
                                    } else {
                                        if (ver[0] >= 13) {
                                            var canvas = window.loadImage.scale(img, {orientation: 0, canvas: true, maxHeight: 100});
                                        } else {
                                            var canvas = window.loadImage.scale(img, {orientation: orientation || 0, canvas: true, maxHeight: 100});
                                        }
                                    }
                                    <?php }?>
                                    //document.getElementById("container2").appendChild(canvas);
                                    $(".canvas_wrap").html('');
                                    $(".canvas_wrap").append(canvas);

                                    $("#imgContainer").show();
                                    $(".waiting").fadeOut(100);
                                });
                            }
                        });
                    });
                    reader.readAsDataURL(image);
                } else {
                    console.log('The File APIs are not fully supported in this browser.');
                }
            }
        };

        $('#sendImage').click(function () {
            //Stop check new messages
            stopCheckMessageInterval();

            //Handle click event
            $('#imgContainer').hide();
            $(".waiting").show();

            var formData = new FormData($('form.frm_Chat')[0]);
            $.ajax({
                type: "POST",
                url: base_url+"ajax/sendImage",
                data: formData,
                dataType: 'json',
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    $('#latestMsgId').val(data.latestMsgId);

                    <?php if($isMobile == false){?>
                    $("#message").data("emojioneArea").enable();
                    <?php } else {?>
                    $("#message").removeAttr('disabled');
                    <?php }?>
                    $('#messageImage').val('');
                    $(".waiting").hide();
                    //add html to chat box
                    $(".chat ul").append(data.html);
                    //Scroll to bottom of ul
                    $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight") + 200);
                    //continue to check the new messages
                    setCheckMessageInterval($('#profileId').val());
                    //Undo prevent default
                    $('#messageImage').unbind('click');

                    $.ajax({
                        method: "POST",
                        url: base_url+"ajax/sendImageMessageToFirebase",
                        data: { csrf_site_name: token_value, imageWidth: data.imageWidth, imageHeight: data.imageHeight, imageUrl: data.imageUrl, profileId: data.profileId, userId: data.userId }
                    }).done(function(data) {
                        console.log(data);
                    });
                }
            });
        });

        textAreaAdjust = function (o) {
            o.style.height = "1px";
            o.style.height = (5+o.scrollHeight)+"px";
        }
    });
</script>
