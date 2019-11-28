<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css" integrity="sha256-LKawN9UgfpZuYSE2HiCxxDxDgLOVDx2R4ogilBI52oc=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js" integrity="sha256-hhA2Nn0YvhtGlCZrrRo88Exx/6H8h2sd4ITCXwqZOdo=" crossorigin="anonymous"></script>
<!--<script src="<?php /*echo base_url().'templates/';*/?>js/emojionearea.js"></script>-->
<script>
    $(document).ready(function() {
        loadMoreMessages('<?php echo $profile->id;?>', 0, true);

        confirmDeleteMessage = function (profileId, text) {
            $('#confirmText').html(text);
            $('#modalConfirm .btnYes').attr('onclick', 'deleteMessageOnPage('+profileId+')');
            $.fancybox.open({src: '#modalConfirm'});
        }

        deleteMessageOnPage = function (profileId) {
            $.fancybox.destroy();
            $.ajax({
                method: "POST",
                url: base_url+"ajax/deleteMessage",
                data: { csrf_site_name: token_value, profile_id: profile_id }
            }).done(function() {
                window.location.replace(base_url+"user/messages");
            });
        }

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
                        sendMessage('<?php echo $profile->id;?>', this.getText())
                    }
                }
            }
        });

        document.getElementById("messageImage").onchange = function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                // get loaded data and render thumbnail.
                document.getElementById("image").src = e.target.result;
            };
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
            $('.previewAction').show();
        };

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
<div id="content">
    <section class="chat mt52">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="frame_chat frame_chat_pc">
                        <div class="chat">
                            <a href="javascript:void(0);" class="btn bntDelete" onclick="confirmDeleteMessage('<?php echo $profile->id;?>', 'Er du sikker på du vil slette chat historik?');">Slet historik</a>
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
                                <input type="text" class="form-control" placeholder="Skriv en besked her........." id="message">
                                <div class="box_sendmedia">
                                    <input type="file" name="messageImage" id="messageImage" accept="image/*">
                                </div>
                                <button type="button" class="btn btnSend" onclick="sendMessage('<?php echo $profile->id;?>', '')" id="btnSend">SEND</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>