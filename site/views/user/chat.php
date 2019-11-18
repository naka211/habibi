<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css" integrity="sha256-LKawN9UgfpZuYSE2HiCxxDxDgLOVDx2R4ogilBI52oc=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js" integrity="sha256-hhA2Nn0YvhtGlCZrrRo88Exx/6H8h2sd4ITCXwqZOdo=" crossorigin="anonymous"></script>
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
                console.log(e.target);
                document.getElementById("image").src = e.target.result;
            };

            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        };
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
                            <form class="frm_Chat" action="" method="POST" role="form">
                                <input type="text" class="form-control" placeholder="Skriv en besked her........." id="message">
                                <div class="box_sendmedia">
                                    <input type="file" name="messageImage" id="messageImage">
                                </div>
                                <img id="image" width="32" style="margin-top: -10px" />
                                <button type="button" class="btn btnSend" onclick="sendMessage('<?php echo $profile->id;?>', '')" id="btnSend">SEND</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>