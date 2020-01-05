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
                            <img id="image" style="width: 100px; margin-bottom: 20px; display: none;" />
                            <img id="imagePre" style="width: 100px; margin-bottom: 20px; display: none;" />
                            <span class="previewAction" style="display: none;">
                                <a href="javascript:void(0);" id="deletePreviewImage"><img src="<?php echo base_url(); ?>templates/images/1x/delete_icon.png"></a>
                                <a href="javascript:void(0);" id="sendImage"><img src="<?php echo base_url(); ?>templates/images/1x/paper-plane-24.png"></a>
                                <input type="hidden" id="imageName" value="">
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
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', base_url+'uploads/file/'+imageName, true);
                xhr.responseType = 'blob';
                xhr.onload = function(e) {
                    if (this.status == 200) {
                        var myBlob = this.response;

                        var mediaMessage = new CometChat.MediaMessage('<?php echo $profile->id;?>', myBlob, CometChat.MESSAGE_TYPE.IMAGE, CometChat.RECEIVER_TYPE.USER);

                        CometChat.init(appId);
                        CometChat.sendMediaMessage(mediaMessage).then(
                            function(message){
                                $.ajax({
                                    type: "post",
                                    url: base_url+"ajax/sendImage",
                                    dataType: 'text',
                                    data: {message: message.url, profileId: <?php echo $profile->id;?>, cometMessageId: message.id, imageName: imageName, 'csrf_site_name':token_value}
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

        $("#deletePreviewImage").click(function () {
            $('.previewAction').hide();
            $('#imagePre').attr('src', '');
            $('#image').attr('src', '');
            var imageName = $("#imageName").val();
            if(imageName != ''){
                $.ajax({
                    method: "POST",
                    url: base_url+"ajax/deleteTempMessageImage",
                    data: { csrf_site_name: token_value, imageName: imageName }
                });
            }
        })
    });
</script>