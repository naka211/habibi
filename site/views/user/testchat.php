<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="">Forside</a></li>
                <li class="active">Chat</li>
            </ul>
        </div>
    </div>
</section>
<section class="contact">
    <div class="container">
        <div class="frm_resgister">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div id="cometchat_embed_synergy_container" style="width:1100px;height:600px;max-width:100%;border:1px solid #CCCCCC;border-radius:5px;overflow:hidden;" ></div>
                    <script src="<?php echo base_url();?>cometchat/js.php?type=core&name=embedcode" type="text/javascript"></script>
                    <script>
                        var iframeObj = {};
                        iframeObj.module="synergy";
                        iframeObj.style="min-height:420px;min-width:350px;";
                        iframeObj.width="1100px";
                        iframeObj.height="600px";
                        iframeObj.src="<?php echo base_url();?>cometchat/cometchat_embedded.php";
                        if(typeof(addEmbedIframe)=="function"){
                            addEmbedIframe(iframeObj);
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>