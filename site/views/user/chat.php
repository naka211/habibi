<div id="content">
    <section class="chat mt52">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="frame_chat frame_chat_pc">
                        <a href="javascript:void(0);" class="btn bntBlock" onclick="confirmDeleteMessage('<?php echo $profile->id;?>', 'Er du sikker på du vil slette chat historik?');">Slet historik</a>
                        <span class="deleteWaiting"></span>
                        <div class="chat">
                            <h4>Chatbesked med <?php echo $profile->name;?></h4>
                            <ul>
                            </ul>
                            <img id="image" style="width: 100px; margin-bottom: 20px;" />
                            <span class="previewAction" style="display: none;">
                                <a href="javascript:void(0);" id="deletePreviewImage"><img src="<?php echo base_url(); ?>templates/images/1x/delete_icon.png"></a>
                                <a href="javascript:void(0);" id="sendImage"><img src="<?php echo base_url(); ?>templates/images/1x/paper-plane-24.png"></a>
                            </span>
                            <span class="waiting"></span>
                            <form class="frm_Chat" action="" method="POST" role="form" id="chatForm">
                                <div class="box_sendmedia">
                                    <input type="file" name="messageImage" id="messageImage" accept="image/*">
                                </div>
                                <input type="text" class="form-control" placeholder="Skriv en besked her........." id="message">
                                <button type="button" class="btn btnSend" onclick="sendMessage('<?php echo $profile->id;?>', '', <?php echo $isMobile?'true':'false';?>)" id="btnSend"><img src="<?php echo base_url().'templates/';?>images/1x/i_send.png" alt="" class="img-responsive"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js" integrity="sha256-hhA2Nn0YvhtGlCZrrRo88Exx/6H8h2sd4ITCXwqZOdo=" crossorigin="anonymous"></script>-->
<script src="<?php echo base_url().'templates/';?>js/emojionearea.js"></script>
<script src="https://cdn.jsdelivr.net/npm/exif-js"></script>
<script>
    $(document).ready(function() {
        loadMoreMessages('<?php echo $profile->id;?>', 0, true, <?php echo $isMobile?'true':'false';?>);

        confirmDeleteMessage = function (profileId, text) {
            $('#confirmText').html(text);
            $('#modalConfirm .btnYes').attr('onclick', 'deleteMessageOnPage('+profileId+')');
            $.fancybox.open({src: '#modalConfirm'});
        }

        deleteMessageOnPage = function (profileId) {
            $.fancybox.destroy();

            $('.bntBlock').hide();
            $(".deleteWaiting").append('<img src="'+base_url+'templates/images/preloader.gif" width="64">');

            $.ajax({
                method: "POST",
                url: base_url+"ajax/deleteMessage",
                data: { csrf_site_name: token_value, profile_id: profileId }
            }).done(function(data) {
                //window.location.replace(base_url+"user/messages");
                //console.log(data);
                history.back();
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
                        sendMessage('<?php echo $profile->id;?>', this.getText(), <?php echo $isMobile?'true':'false';?>)
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

        document.getElementById("messageImage").onchange = function () {console.log(this.files[0]);
            readURLimg(this);
            /*var reader = new FileReader();
            reader.onload = function (e) {
                // get loaded data and render thumbnail.
                document.getElementById("image").src = e.target.result;
            };
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);*/
            $('.previewAction').show();
        };

        readURLimg = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = $('#image')
                    img.attr('src', e.target.result);
                    fixExifOrientation(img)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        fixExifOrientation = function ($img) {
            $img.on('load', function() {
                EXIF.getData($img[0], function() {
                    //console.log('Exif=', EXIF.getTag(this, "Orientation"));
                    switch(parseInt(EXIF.getTag(this, "Orientation"))) {
                        case 2:
                            $img.addClass('flip'); break;
                        case 3:
                            $img.addClass('rotate-180'); break;
                        case 4:
                            $img.addClass('flip-and-rotate-180'); break;
                        case 5:
                            $img.addClass('flip-and-rotate-270'); break;
                        case 6:
                            $img.addClass('rotate-90'); break;
                        case 7:
                            $img.addClass('flip-and-rotate-90'); break;
                        case 8:
                            $img.addClass('rotate-270'); break;
                    }
                });
            });
        }

        $('#sendImage').click(function () {
            //Handle click event
            $('.previewAction').hide();
            $('#image').attr('src', '');
            $(".waiting").append('<img src="'+base_url+'templates/images/preloader.gif" width="64">');

            //Send message to comet server
            var appId = "<?php echo $this->config->item('comet_app_id');?>";

            var mediaMessage = new CometChat.MediaMessage('<?php echo $profile->id;?>', document.getElementById('messageImage').files[0], CometChat.MESSAGE_TYPE.IMAGE, CometChat.RECEIVER_TYPE.USER);

            CometChat.init(appId);
            CometChat.sendMediaMessage(mediaMessage).then(
                function(message){
                    console.log(message);
                    $.ajax({
                        type: "post",
                        url: base_url+"ajax/sendImage",
                        dataType: 'text',
                        data: {message: message.url, profileId: <?php echo $profile->id;?>, cometMessageId: message.id, 'csrf_site_name':token_value}
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
        });
    });
</script>