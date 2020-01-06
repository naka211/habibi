<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Beskeder</h3>
                    </div>
                </div>
            </div>
            <?php if(!empty($list)){
                foreach ($list as $user){
                    if(!in_array($user->id, $ignore)){
                    if(isGoldMember()){
                        $isMobileVal = $isMobile?'true':'false';
                        $messageLink = 'href="javascript:void(0)" onclick="loadMoreMessages('.$user->id.',0, true, '. $isMobileVal.', \''.$user->name.'\')"';
                        //$messageLink = 'href="'.site_url('user/chat/'.$user->id.'/'.$user->name).'"';
                        $profileLink = 'href="'.site_url('user/profile/'.$user->id.'/'.$user->name).'"';
                    } else {
                        $messageLink = $profileLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
                    }
            ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12 profile<?php echo $user->id;?>">
                <div class="frend_item">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="friend_item_avatar">
                                <a <?php echo $profileLink;?>>
                                <?php if($user->blurIndex == 0 || ($user->blurIndex != 0 && allowViewAvatar($user->id))) { ?>
                                    <img src="<?php echo base_url();?>uploads/raw_thumb_user/<?php echo $user->avatar;?>" class="img-responsive <?php if(!isGoldMember() && $user->avatar != 'no-avatar1.png' && $user->avatar != 'no-avatar2.png') echo 'blur'?>">
                                <?php } else {?>
                                    <img src="<?php echo base_url(); ?>uploads/thumb_user/<?php echo $user->avatar; ?>" class="img-responsive <?php if(!isGoldMember() && $user->avatar != 'no-avatar1.png' && $user->avatar != 'no-avatar2.png') echo 'blur'?>">
                                <?php }?>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <?php if(isGoldMember()){?>
                                <h4><?php echo $user->name; ?> <?php if($user->login == 1){?><span class="status"></span><?php }?><?php if($user->seen == 0){?><span class="new">Ny</span><?php } ?></h4>
                            <?php }?>

                            <p><?php echo printAge($user->id); ?> – <?php echo $user->region; ?></p>
                            <p>Sendt: d. <span><?php echo date("d/m/Y", $user->added_time); ?></span> kl. <span><?php echo date("H:i", $user->added_time); ?></span></p>
                            <?php if(isGoldMember() === true){?>
                            <p class="gray_friend_item"><?php
                                if($user->messageType == 'text'){
                                    echo substr($user->message, 0, 27);
                                } else if($user->messageType == 'image'){
                                    echo 'Et billede var vedhæftet';
                                } else if($user->messageType == 'video'){
                                    echo 'En video var vedhæftet';
                                } else if($user->messageType == 'image'){
                                    echo 'En lyd var knyttet';
                                }
                            ?></p>
                            <?php }?>
                            <a <?php echo $messageLink;?> class="btn bntMessage">Besked</a>
                            <a onclick="confirmDeleteMessage(<?php echo $user->id;?>, 'Er du sikker på du vil slette chat historik?')" href="javascript:;" class="btn bntBlock">Slet historik</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }}
            }?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <ul class="pagination friends_pagination">
                        <?php echo $pagination;?>
                    </ul>
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
                <span class="deleteWaiting"></span>
                <h4></h4>
                <div class="chat">
                    <ul>
                    </ul>
                    <img id="image" style="width: 100px; margin-bottom: 20px; display: none;" />
                    <img id="imagePre" style="width: 100px; margin-bottom: 20px; display: none;" />
                    <span class="previewAction" style="display: none;">
                        <a href="javascript:void(0);" id="deletePreviewImage"><img src="<?php echo base_url(); ?>templates/images/1x/delete_icon.png"></a>
                        <a href="javascript:void(0);" id="sendImage"><img src="<?php echo base_url(); ?>templates/images/1x/paper-plane-24.png"></a>
                        <input type="hidden" id="imageName" value="">
                        <input type="hidden" id="profileId" value="">
                    </span>
                    <span class="waiting"></span>
                    <form class="frm_Chat" action="" method="POST" role="form">
                        <div class="box_sendmedia">
                            <input type="file" name="messageImage" id="messageImage" accept="image/*">
                        </div>
                        <textarea class="form-control" id="message" placeholder="Skriv en besked her........." onkeyup="textAreaAdjust(this)" style="overflow:hidden"></textarea>
                        <button type="button" class="btn btnSend" id="btnSend"><img src="<?php echo base_url().'templates/';?>images/1x/i_send.png" alt="" class="img-responsive"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<script>
    $(document).ready(function() {
        $("#messageMenu").addClass('active');

        confirmDeleteMessage = function (profileId, text) {
            $('#confirmText').html(text);
            $('#modalConfirm .btnYes').attr('onclick', 'deleteMessageOnPage('+profileId+')');
            $.fancybox.open({src: '#modalConfirm', touch : false});
        }

        deleteMessageOnPage = function (profileId) {
            $.fancybox.close();

            $('.bntBlock').hide();
            $(".deleteWaiting").append('<img src="'+base_url+'templates/images/preloader.gif" width="64">');

            $.ajax({
                method: "POST",
                url: base_url+"ajax/deleteMessage",
                data: { csrf_site_name: token_value, profile_id: profileId }
            }).done(function(data) {
                location.reload();
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
                    }
                }
            }
        });
        <?php } else {?>
        //Handle enter key in message
        $('#message').keyup(function(e){
            if(e.keyCode == 13){
                $('.btnSend').click();
            }
        });

        $('.frm_Chat').on('keypress', function(e) {
            return e.which !== 13;
        });
        ////
        <?php }?>

        document.getElementById("messageImage").onchange = function () {
            $(".waiting").append('<img src="'+base_url+'templates/images/preloader.gif" width="64">');
            var img = $('#image');
            var imgPre = $('#imagePre');
            //readURLimg(this);
            var reader = new FileReader();
            reader.onload = function (e) {
                // get loaded data and render thumbnail.
                img.attr('src', e.target.result);
                imgPre.attr('src', e.target.result);
                //$('.previewAction').show();
            };

            img.on('load', function() {
                EXIF.getData(img[0], function () {
                    var orient = parseInt(EXIF.getTag(this, "Orientation"));
                    if(isNaN(orient) == true){
                        $(".waiting").fadeOut(100);
                        imgPre.show();
                        $('.previewAction').show();
                        $("#imageName").val('');
                    } else {
                        $.ajax({
                            method: "POST",
                            url: base_url+"ajax/uploadTempMessageImage",
                            data: { csrf_site_name: token_value, imageData: img.attr('src'), extension: $("#messageImage").val().split('.').pop() }
                        }).done(function(filename) {
                            console.log(filename);
                            imgPre.attr('src', base_url+'uploads/file/'+filename);
                            $(".waiting").fadeOut(100);
                            imgPre.show();
                            $("#imageName").val(filename);
                            $('.previewAction').show();
                        });
                    }
                });
            });
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        };

        $('#sendImage').click(function () {
            //Handle click event
            $('.previewAction').hide();
            $('#imagePre').attr('src', '');
            $(".waiting").show();

            var appId = "<?php echo $this->config->item('comet_app_id');?>";
            var imageName = $("#imageName").val();
            if(imageName == ''){
                //Send message to comet server
                var mediaMessage = new CometChat.MediaMessage($("#profileId").val(), document.getElementById('messageImage').files[0], CometChat.MESSAGE_TYPE.IMAGE, CometChat.RECEIVER_TYPE.USER);

                CometChat.init(appId);
                CometChat.sendMediaMessage(mediaMessage).then(
                    function(message){
                        $.ajax({
                            type: "post",
                            url: base_url+"ajax/sendImage",
                            dataType: 'text',
                            data: {message: message.url, profileId: $("#profileId").val(), cometMessageId: message.id, 'csrf_site_name':token_value}
                        }).done(function(html){
                            $(".waiting").fadeOut(100);
                            //add html to chat box
                            $(".chat ul").append(html);
                            //Scroll to bottom of ul
                            $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight") + 200);
                        });
                    },
                    function(error){
                        console.log("Media message sending failed with error", error);
                        // Handle exception.
                    }
                );
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', base_url+'uploads/file/'+imageName, true);
                xhr.responseType = 'blob';
                xhr.onload = function(e) {
                    if (this.status == 200) {
                        var myBlob = this.response;

                        var mediaMessage = new CometChat.MediaMessage($("#profileId").val(), myBlob, CometChat.MESSAGE_TYPE.IMAGE, CometChat.RECEIVER_TYPE.USER);

                        CometChat.init(appId);
                        CometChat.sendMediaMessage(mediaMessage).then(
                            function(message){
                                $.ajax({
                                    type: "post",
                                    url: base_url+"ajax/sendImage",
                                    dataType: 'text',
                                    data: {message: message.url, profileId: $("#profileId").val(), cometMessageId: message.id, imageName: imageName, 'csrf_site_name':token_value}
                                }).done(function(html){
                                    $(".waiting").fadeOut(100);
                                    //add html to chat box
                                    $(".chat ul").append(html);
                                    //Scroll to bottom of ul
                                    $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight") + 200);
                                    //Delete temp image
                                    $.ajax({
                                        method: "POST",
                                        url: base_url+"ajax/deleteTempMessageImage",
                                        data: { csrf_site_name: token_value, imageName: imageName }
                                    });
                                    //
                                    $("#imageName").val('');
                                });
                            },
                            function(error){
                                console.log("Media message sending failed with error", error);
                                // Handle exception.
                            }
                        );
                    }
                };
                xhr.send();
            }
        });

        textAreaAdjust = function (o) {
            o.style.height = "1px";
            o.style.height = (5+o.scrollHeight)+"px";
        }
    });
</script>